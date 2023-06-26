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
            'lansia_id' => 'required|exists:anak,id',
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
            $antropometri_bb = Antropometri::where('jenis_kelamin', $jenisKelamin)
                ->where('bulan', $bulan)
                ->where('tipe', 'bb')
                ->first();
            $antropometri_tb = Antropometri::where('jenis_kelamin', $jenisKelamin)
                ->where('bulan', $bulan)
                ->where('tipe', 'tb')
                ->first();

            $bb = $request->input('bb');
            if ($antropometri_bb && $bb < $antropometri_bb->minus_3_sd) {
                $bb_status =  'Sangat Kurang';
            } else if ($antropometri_bb && $bb <= $antropometri_bb->minus_2_sd && $bb >= $antropometri_bb->minus_3_sd) {
                $bb_status =  'Kurang';
            } else if ($antropometri_bb && $bb >= $antropometri_bb->minus_2_sd && $bb <= $antropometri_bb->plus_1_sd) {
                $bb_status =  'Normal';
            } else if ($antropometri_bb && $bb > $antropometri_bb->plus_1_sd) {
                $bb_status =  'Risiko Berat Badan';
            } else {
                $bb_status = null;
            }

            $tb = $request->input('tb');
            if ($antropometri_tb && $tb < $antropometri_tb->minus_3_sd) {
                $tb_status = 'Sangat Pendek';
            } else if ($antropometri_tb && $tb >= $antropometri_tb->minus_3_sd && $tb <= $antropometri_tb->minus_2_sd) {
                $tb_status = 'Pendek';
            } else if ($antropometri_tb && $tb >= $antropometri_tb->minus_2_sd && $tb <= $antropometri_tb->plus_3_sd) {
                $tb_status = 'Normal';
            } else if ($antropometri_tb && $tb > $antropometri_tb->plus_3_sd) {
                $tb_status = 'Tinggi';
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