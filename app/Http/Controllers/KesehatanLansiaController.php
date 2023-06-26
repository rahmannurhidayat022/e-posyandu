<?php

namespace App\Http\Controllers;

use App\Models\KesehatanLansia;
use App\Models\Lansia;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class KesehatanLansiaController extends Controller
{
    public function index(Request $request, $id)
    {
        if ($request->ajax()) {
            $data = KesehatanLansia::where('lansia_id', $id)->with(['posko:id,nama,rw', 'petugas:id,nama'])->orderBy('created_at', 'desc');
            return DataTables::of($data)
                ->filter(function (Builder $query) {
                    if (request()->has("posko_id")) {
                        $query->where("posko_id", request("posko_id"));
                    }

                    $search = request()->input('search');
                    if (!empty($search)) {
                        $query->where(function ($query) use ($search) {
                            $query->orWhere('id_layanan', 'like', "%$search%");
                            $query->orWhere('usia', 'like', "%$search%");
                            $query->orWhere('bb', 'like', "%$search%");
                            $query->orWhere('tb', 'like', "%$search%");
                            $query->orWhere('created_at', 'like', "%$search%");
                        });
                    }
                })
                ->addIndexColumn()
                ->make(true);
        }

        $lansia = Lansia::where('id', $id)->select('id', 'nama')->get()->first();

        return view('kesehatan_lansia.index', ['id' => $id, 'lansia' => $lansia]);
    }

    public function create($id)
    {
        $lansia = Lansia::where('id', $id)->select('id', 'nama')->get()->first();
        return view('kesehatan_lansia.create', ['id' => $id, 'lansia' => $lansia]);
    }

    public function edit($id, $kesehatan_id)
    {
        $lansia = Lansia::where('id', $id)->select('nama')->get()->first();
        $kesehatan = KesehatanLansia::where('id', $kesehatan_id)->get()->first();
        return view('kesehatan_lansia.edit', ['id' => $id, 'lansia' => $lansia, 'kesehatan' => $kesehatan]);
    }

    public function store(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'posko_id' => 'required|exists:posko,id',
            'petugas_id' => 'required|exists:petugas_kesehatan,id',
            'lansia_id' => 'required|exists:lansia,id',
            'bb' => 'required',
            'tb' => 'required',
            'tekanan_darah' => 'required',
            'kolestrol' => 'required',
            'gula_darah' => 'required',
            'keluhan' => 'nullable',
            'catatan' => 'nullable',
        ]);

        if ($validated->fails()) {
            $errors = $validated->errors();
            Alert::error('Gagal', $errors->first())->autoclose(3000);
            return redirect()->back()->withInput($request->all());
        }

        try {

            $penimbangan = KesehatanLansia::create($request->all());
            $penimbangan->save();

            Alert::success('Berhasil', 'Berhasil menambahkan data kesehatan lansia');
            return redirect()->route('kesehatan_lansia.index', $id);
        } catch (\Throwable $th) {
            Alert::error('Gagal', 'Gagal menambahkan data kesehatan lansia')->autoclose(3000);
            return redirect()->back()->withInput($request->all());
        }
    }

    public function update(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'posko_id' => 'required|exists:posko,id',
            'petugas_id' => 'required|exists:petugas_kesehatan,id',
            'lansia_id' => 'required|exists:lansia,id',
            'bb' => 'required',
            'tb' => 'required',
            'tekanan_darah' => 'required',
            'kolestrol' => 'required',
            'gula_darah' => 'required',
            'keluhan' => 'nullable',
            'catatan' => 'nullable',
        ]);

        if ($validated->fails()) {
            $errors = $validated->errors();
            Alert::error('Gagal', $errors->first())->autoclose(3000);
            return redirect()->back()->withInput($request->all());
        }

        try {

            $penimbangan = KesehatanLansia::findOrFail($id);
            $penimbangan->update($request->all());
            $penimbangan->save();

            Alert::success('Berhasil', 'Berhasil perbaharui data kesehatan lansia');
            return redirect()->route('kesehatan_lansia.index', $request->input('lansia_id'));
        } catch (\Throwable $th) {
            Alert::error('Gagal', 'Gagal perbaharui data kesehatan lansia')->autoclose(3000);
            return redirect()->back()->withInput($request->all());
        }
    }

    public function destroy($id)
    {
        try {
            KesehatanLansia::findOrFail($id)->delete();
            Alert::success('Berhasil', 'Berhasil menghapus data kesehatan lansia');
            return redirect()->back();
        } catch (\Throwable $th) {
            Alert::error('Gagal', 'Gagal menghapus data kesehatan lansia')->autoclose(3000);
            return redirect()->back();
        }
    }
}
