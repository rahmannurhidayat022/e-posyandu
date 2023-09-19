<?php

namespace App\Http\Controllers;

use App\Models\Anak;
use App\Models\Imunisasi;
use App\Models\PenimbanganAnak;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class ImunisasiController extends Controller
{
    public function index(Request $request, $id)
    {
        if ($request->ajax()) {
            $data = Imunisasi::where('anak_id', $id)->with(['posko:id,nama,rw', 'petugas:id,nama', 'anak:id,nama,ibu_id', 'anak.ibu:id,nama'])->orderBy('created_at', 'desc');
            return DataTables::of($data)
                ->filter(function (Builder $query) {
                    if (request()->has("posko_id")) {
                        $query->where("posko_id", request("posko_id"));
                    }
                    if (request()->has("jenis_vaksin")) {
                        $query->where("jenis_vaksin", request("jenis_vaksin"));
                    }

                    $search = request()->input('search');
                    if (!empty($search)) {
                        $query->where(function ($query) use ($search) {
                            $query->orWhere('id_layanan', 'like', "%$search%");
                            $query->orWhere('created_at', 'like', "%$search%");
                        });
                    }
                })
                ->addIndexColumn()
                ->make(true);
        }

        $anak = Anak::where('id', $id)->select('id', 'nama')->get()->first();
        $bulan = PenimbanganAnak::where('anak_id', $anak->id)->select('usia')->latest()->value('usia') ?? null;
        $limit = ($bulan === null || $bulan < 60) ? false : true;
        $is_kms = $bulan === null ? false : true;

        return view('imunisasi.index', ['id' => $id, 'anak' => $anak, 'limit' => $limit, 'is_kms' => $is_kms]);
    }

    public function create($id)
    {
        $anak = Anak::where('id', $id)->select('id', 'nama')->get()->first();
        return view('imunisasi.create', ['id' => $id, 'anak' => $anak]);
    }

    public function edit($id, $imunisasi_id)
    {
        $anak = Anak::where('id', $id)->select('nama')->get()->first();
        $imunisasi = Imunisasi::where('id', $imunisasi_id)->get()->first();
        return view('imunisasi.edit', ['id' => $id, 'anak' => $anak, 'imunisasi' => $imunisasi]);
    }

    public function store(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'posko_id' => 'required|exists:posko,id',
            'petugas_id' => 'required|exists:petugas_kesehatan,id',
            'anak_id' => 'required|exists:anak,id',
            'usia' => 'required',
            'jenis_vaksin' => 'required',
            'batch_number' => 'required',
            'expired_date' => 'required',
            'keluhan' => 'nullable',
            'catatan' => 'nullable',
        ]);

        if ($validated->fails()) {
            $errors = $validated->errors();
            Alert::error('Gagal', $errors->first())->autoclose(3000);
            return redirect()->back()->withInput($request->all());
        }

        try {

            $imunisasi = Imunisasi::create($request->all());
            $imunisasi->save();

            Alert::success('Berhasil', 'Berhasil menambahkan data imunisasi anak');
            return redirect()->route('imunisasi.index', $id);
        } catch (\Throwable $th) {
            Alert::error('Gagal', 'Gagal menambahkan data imunisasi anak')->autoclose(3000);
            return redirect()->back()->withInput($request->all());
        }
    }

    public function update(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'posko_id' => 'required|exists:posko,id',
            'petugas_id' => 'required|exists:petugas_kesehatan,id',
            'anak_id' => 'required|exists:anak,id',
            'usia' => 'required',
            'jenis_vaksin' => 'required',
            'batch_number' => 'required',
            'expired_date' => 'required',
            'keluhan' => 'nullable',
            'catatan' => 'nullable',
        ]);

        if ($validated->fails()) {
            $errors = $validated->errors();
            Alert::error('Gagal', $errors->first())->autoclose(3000);
            return redirect()->back()->withInput($request->all());
        }

        try {

            $imunisasi = Imunisasi::findOrFail($id);
            $imunisasi->update($request->all());
            $imunisasi->save();

            Alert::success('Berhasil', 'Berhasil perbaharui data imunisasi anak');
            return redirect()->route('imunisasi.index', $request->input('anak_id'));
        } catch (\Throwable $th) {
            Alert::error('Gagal', 'Gagal perbaharui data imunisasi anak')->autoclose(3000);
            return redirect()->back()->withInput($request->all());
        }
    }

    public function destroy($id)
    {
        try {
            Imunisasi::findOrFail($id)->delete();
            Alert::success('Berhasil', 'Berhasil menghapus data imunisasi anak');
            return redirect()->back();
        } catch (\Throwable $th) {
            Alert::error('Gagal', 'Gagal menghapus data imunisasi anak')->autoclose(3000);
            return redirect()->back();
        }
    }
}
