<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Posko;
use App\Models\LingkupPosko;
use Alert;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class PoskoController extends Controller
{
    public function getPosko(): JsonResponse
    {
        $data = Posko::select('id', 'nama', 'rw')->orderBy('rw', 'asc')->get();
        return response()->json($data);
    }

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
        $validated = Validator::make($request->all(), [
            'nama' => 'required',
            'jalan' => 'required',
            'rw' => 'required|unique:posko',
        ], [
            'rw.unique' => 'RW tersebut sudah terdaftar di posko lain',
        ]);

        if ($validated->fails()) {
            $errors = $validated->errors();
            Alert::error('Gagal', $errors->first())->autoclose(3000);
            return redirect()->back()->withInput($request->all());
        }

        try {
            $data = new Posko();
            $data->nama = $request->nama;
            $data->jalan = $request->jalan;
            $data->rw = $request->rw;
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

            Alert::success('Berhasil', 'Berhasil menambahkan data posko');
            return redirect()->route('posko.index');
        } catch (\Throwable $th) {
            Alert::error('Gagal', 'Gagal menambahkan data posko')->autoclose(3000);
            return redirect()->back()->withInput($request->all());
        }
    }

    public function edit($id)
    {
        $data = Posko::findOrFail($id);
        $lingkup = LingkupPosko::where('posko_id', $id)->get();
        return view('posko.edit')->with(["id" => $id, "posko" => $data, "lingkup" => $lingkup]);
    }

    public function update(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'nama' => 'required',
            'jalan' => 'required',
            'rw' => [
                'required',
                function ($attribute, $value, $fail) use ($id) {
                    $posko = Posko::findOrFail($id);

                    if ($posko->rw === $value) {
                        return;
                    }

                    $exists = Posko::where('rw', $value)->where('id', '!=', $id)->exists();
                    if ($exists) {
                        $fail('RW tersebut sudah digunakan di posko lain');
                    }
                },
            ],
        ]);

        if ($validated->fails()) {
            $errors = $validated->errors();
            Alert::error('Gagal', $errors->first())->autoclose(3000);
            return redirect()->back()->withInput($request->all());
        }

        try {
            $data = Posko::findOrFail($id);
            $data->nama = $request->nama;
            $data->jalan = $request->jalan;
            $data->rw = $request->rw;
            $data->save();

            LingkupPosko::where('posko_id', $data->id)->delete();

            $rt = [];
            foreach ($request->rt as $item) {
                $rt[] = [
                    "posko_id" => $data->id,
                    "rt" => $item,
                ];
            }
            LingkupPosko::insert($rt);

            Alert::success('Berhasil', 'Berhasil update data posko');
            return redirect()->route('posko.index');
        } catch (\Throwable $th) {
            Alert::error('Gagal', 'Gagal update data posko')->autoclose(3000);
            return redirect()->back()->withInput($request->all());
        }
    }

    public function destroy($id)
    {
        try {
            $posko = Posko::findOrFail($id);
            LingkupPosko::where('posko_id', $posko->id)->delete();
            $posko->delete();

            Alert::success('Berhasil', 'Berhasil menghapus data posko');
            return redirect()->back();
        } catch (\Throwable $th) {
            Alert::error('Gagal', 'Gagal menghapus data posko')->autoclose(3000);
            return redirect()->back();
        }
    }
}
