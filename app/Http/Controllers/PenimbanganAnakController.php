<?php

namespace App\Http\Controllers;

use App\Models\Anak;
use App\Models\Antropometri;
use App\Models\PenimbanganAnak;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class PenimbanganAnakController extends Controller
{
    public function index(Request $request, $id)
    {
        if ($request->ajax()) {
            $data = PenimbanganAnak::where('anak_id', $id)->with(['posko:id,nama,rw', 'kader:id,nama', 'petugas:id,nama', 'anak:id,nama,ibu_id', 'anak.ibu:id,nama'])->orderBy('created_at', 'desc');
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

        $anak = Anak::where('id', $id)->select('nama')->get()->first();
        return view('penimbangan.index', ['id' => $id, 'anak' => $anak]);
    }

    public function create($id)
    {
        $anak = Anak::where('id', $id)->select('nama')->get()->first();
        return view('penimbangan.create', ['id' => $id, 'anak' => $anak]);
    }

    public function edit($id, $penimbangan_id)
    {
        $anak = Anak::where('id', $id)->select('nama')->get()->first();
        $penimbangan = PenimbanganAnak::where('id', $penimbangan_id)->get()->first();
        return view('penimbangan.edit', ['id' => $id, 'anak' => $anak, 'penimbangan' => $penimbangan]);
    }

    public function store(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'posko_id' => 'required|exists:posko,id',
            'petugas_id' => 'required|exists:petugas_kesehatan,id',
            'anak_id' => 'required|exists:anak,id',
            'kader_id' => 'required|exists:kader,id',
            'usia' => 'required',
            'bb' => 'required',
            'tb' => 'required',
            'keluhan' => 'nullable',
            'catatan' => 'nullable',
        ]);

        if ($validated->fails()) {
            $errors = $validated->errors();
            Alert::error('Gagal', $errors->first())->autoclose(3000);
            return redirect()->back()->withInput($request->all());
        }

        try {

            $penimbangan = PenimbanganAnak::create($request->all());

            $jenisKelamin = Anak::find($request->input('anak_id'))->jenis_kelamin;
            $bulan = $request->input('usia');
            $antropometri = Antropometri::where('jenis_kelamin', $jenisKelamin)
                ->where('bulan', $bulan)
                ->first();

            $bb = $request->input('bb');
            if ($antropometri && $antropometri->bb_min <= $bb && $bb <= $antropometri->bb_max) {
                $bb_status = 'normal';
            } elseif ($antropometri && $bb < $antropometri->bb_min) {
                $bb_status = 'kurang';
            } elseif ($antropometri && $bb > $antropometri->bb_max) {
                $bb_status = 'obesitas';
            } else {
                $bb_status = null;
            }

            $tb = $request->input('tb');
            if ($antropometri && $antropometri->tb_min <= $tb && $tb <= $antropometri->tb_max) {
                $tb_status = 'normal';
            } elseif ($antropometri && $tb < $antropometri->tb_min) {
                $tb_status = 'pendek';
            } elseif ($antropometri && $tb > $antropometri->tb_max) {
                $tb_status = 'tinggi';
            } else {
                $tb_status = null;
            }
            $penimbangan->bb_status = $bb_status;
            $penimbangan->tb_status = $tb_status;
            $penimbangan->save();

            Alert::success('Berhasil', 'Berhasil menambahkan data penimbangan anak');
            return redirect()->route('penimbangan.index', $id);
        } catch (\Throwable $th) {
            Alert::error('Gagal', 'Gagal menambahkan data penimbangan anak')->autoclose(3000);
            return redirect()->back()->withInput($request->all());
        }
    }

    public function update(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'posko_id' => 'required|exists:posko,id',
            'petugas_id' => 'required|exists:petugas_kesehatan,id',
            'anak_id' => 'required|exists:anak,id',
            'kader_id' => 'required|exists:kader,id',
            'usia' => 'required',
            'bb' => 'required',
            'tb' => 'required',
            'keluhan' => 'nullable',
            'catatan' => 'nullable',
        ]);

        if ($validated->fails()) {
            $errors = $validated->errors();
            Alert::error('Gagal', $errors->first())->autoclose(3000);
            return redirect()->back()->withInput($request->all());
        }

        try {

            $penimbangan = PenimbanganAnak::findOrFail($id);
            $penimbangan->update($request->all());

            $jenisKelamin = Anak::find($request->input('anak_id'))->jenis_kelamin;
            $bulan = $request->input('usia');
            $antropometri = Antropometri::where('jenis_kelamin', $jenisKelamin)
                ->where('bulan', $bulan)
                ->first();

            $bb = $request->input('bb');
            if ($antropometri && $antropometri->bb_min <= $bb && $bb <= $antropometri->bb_max) {
                $bb_status = 'normal';
            } elseif ($antropometri && $bb < $antropometri->bb_min) {
                $bb_status = 'kurang';
            } elseif ($antropometri && $bb > $antropometri->bb_max) {
                $bb_status = 'obesitas';
            } else {
                $bb_status = null;
            }

            $tb = $request->input('tb');
            if ($antropometri && $antropometri->tb_min <= $tb && $tb <= $antropometri->tb_max) {
                $tb_status = 'normal';
            } elseif ($antropometri && $tb < $antropometri->tb_min) {
                $tb_status = 'pendek';
            } elseif ($antropometri && $tb > $antropometri->tb_max) {
                $tb_status = 'tinggi';
            } else {
                $tb_status = null;
            }
            $penimbangan->bb_status = $bb_status;
            $penimbangan->tb_status = $tb_status;
            $penimbangan->save();

            Alert::success('Berhasil', 'Berhasil perbaharui data penimbangan anak');
            return redirect()->route('penimbangan.index', $request->input('anak_id'));
        } catch (\Throwable $th) {
            Alert::error('Gagal', 'Gagal perbaharui data penimbangan anak')->autoclose(3000);
            return redirect()->back()->withInput($request->all());
        }
    }

    public function destroy($id)
    {
        try {
            PenimbanganAnak::findOrFail($id)->delete();
            Alert::success('Berhasil', 'Berhasil menghapus data penimbangan anak');
            return redirect()->back();
        } catch (\Throwable $th) {
            Alert::error('Gagal', 'Gagal menghapus data penimbangan anak')->autoclose(3000);
            return redirect()->back();
        }
    }
}
