<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Posko;
use App\Models\LingkupPosko;
use Alert;
use Yajra\DataTables\DataTables;

class PoskoController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Posko::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('rt', function ($row) {
                    return LingkupPosko::where('posko_id', $row->id)->select('rt')->get();
                })
                ->make(true);
        }
        return view('posko.index');
    }

    public function create()
    {
        return view('posko.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'jalan' => 'required',
            'rw' => 'required',
        ]);

        try {
            $data = new Posko();
            $data->nama = $validated['nama'];
            $data->jalan = $validated['jalan'];
            $data->rw = $validated['rw'];

            $data->save();

            if ($request->rt) {
                $rt = [];
                foreach ($request->rt as $item) {
                    $rt[] = [
                        "posko_id" => $data->id,
                        "rt" => $item,
                    ];
                }
                LingkupPosko::insert($rt);
            }

            Alert::success('success', 'Berhasil menambahkan data posko');
            return redirect()->route('posko.index');
        } catch (\Throwable $th) {
            Alert::error('error', 'Gagal menambahkan data posko')->autoclose(3000);
            return redirect()->back()->withInput($request->all());
        }
    }

    public function edit($id)
    {
        $data = Posko::findOrFail($id);
        $lingkup = LingkupPosko::where('posko_id', $id)->get();
        return view('posko.edit')->with(["posko" => $data, "lingkup" => $lingkup]);
    }
}
