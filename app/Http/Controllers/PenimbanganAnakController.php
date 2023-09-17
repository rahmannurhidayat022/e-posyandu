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

        $anak = Anak::where('id', $id)->select('id', 'nama')->get()->first();
        $bulan = PenimbanganAnak::where('anak_id', $anak->id)->select('usia')->latest()->value('usia') ?? null;
        $limit = ($bulan === null || $bulan < 60) ? false : true;
        $is_kms = $bulan === null ? false : true;

        return view('penimbangan.index', ['id' => $id, 'anak' => $anak, 'limit' => $limit, 'is_kms' => $is_kms]);
    }

    public function create($id)
    {
        $anak = Anak::where('id', $id)->select('id', 'nama')->get()->first();
        $bulan = PenimbanganAnak::where('anak_id', $anak->id)->select('usia')->latest()->value('usia') ?? null;
        if ($bulan === null) {
            $bulan = 0;
        } else {
            $bulan += 1;
        }
        return view('penimbangan.create', ['id' => $id, 'anak' => $anak, 'bulan' => $bulan]);
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

            $bmi = $this->indexMasaTubuh($request->input('bb'), $request->input('tb'));
            $antropometri_imt = Antropometri::where('jenis_kelamin', $jenisKelamin)
                ->where('bulan', $bulan)
                ->where('tipe', 'imt')
                ->first();
            if ($antropometri_imt && $bmi < $antropometri_imt->minus_3_sd) {
                $gizi_status = 'Gizi Buruk';
            } else if ($antropometri_imt && $bmi >= $antropometri_imt->minus_3_sd && $bmi <= $antropometri_imt->minus_2_sd) {
                $gizi_status = 'Gizi Kurang';
            } else if ($antropometri_imt && $bmi >= $antropometri_imt->minus_2_sd && $bmi <= $antropometri_imt->plus_1_sd) {
                $gizi_status = 'Gizi Normal';
            } else if ($antropometri_imt && $bmi >= $antropometri_imt->plus_1_sd && $bmi <= $antropometri_imt->plus_2_sd) {
                $gizi_status = 'Berisiko Gizi Lebih';
            } else if ($antropometri_imt && $bmi >= $antropometri_imt->plus_2_sd && $bmi <= $antropometri_imt->plus_3_sd) {
                $gizi_status = 'Gizi Lebih';
            } else if ($antropometri_imt && $bmi > $antropometri_imt->plus_3_sd) {
                $gizi_status = 'Obesitas';
            } else {
                $gizi_status = null;
            }

            $penimbangan->bb_status = $bb_status;
            $penimbangan->tb_status = $tb_status;
            $penimbangan->gizi_status = $gizi_status;
            $penimbangan->save();

            Alert::success('Berhasil', 'Berhasil menambahkan data penimbangan anak');
            return redirect()->route('penimbangan.index', $id);
        } catch (\Throwable $th) {
            Alert::error('Gagal', 'Gagal menambahkan data penimbangan anak')->autoclose(3000);
            return redirect()->back()->withInput($request->all());
        }
    }

    private function indexMasaTubuh($bb, $tb)
    {
        $heightMeter =  $tb / 100;
        $bmi = $bb / ($heightMeter * $heightMeter);
        return $bmi;
    }

    public function update(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'posko_id' => 'required|exists:posko,id',
            'petugas_id' => 'required|exists:petugas_kesehatan,id',
            'anak_id' => 'required|exists:anak,id',
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

            $bmi = $this->indexMasaTubuh($request->input('bb'), $request->input('tb'));
            $antropometri_imt = Antropometri::where('jenis_kelamin', $jenisKelamin)
                ->where('bulan', $bulan)
                ->where('tipe', 'imt')
                ->first();
            if ($antropometri_imt && $bmi < $antropometri_imt->minus_3_sd) {
                $gizi_status = 'Gizi Buruk';
            } else if ($antropometri_imt && $bmi >= $antropometri_imt->minus_3_sd && $bmi <= $antropometri_imt->minus_2_sd) {
                $gizi_status = 'Gizi Kurang';
            } else if ($antropometri_imt && $bmi >= $antropometri_imt->minus_2_sd && $bmi <= $antropometri_imt->plus_1_sd) {
                $gizi_status = 'Gizi Normal';
            } else if ($antropometri_imt && $bmi >= $antropometri_imt->plus_1_sd && $bmi <= $antropometri_imt->plus_2_sd) {
                $gizi_status = 'Berisiko Gizi Lebih';
            } else if ($antropometri_imt && $bmi >= $antropometri_imt->plus_2_sd && $bmi <= $antropometri_imt->plus_3_sd) {
                $gizi_status = 'Gizi Lebih';
            } else if ($antropometri_imt && $bmi > $antropometri_imt->plus_3_sd) {
                $gizi_status = 'Obesitas';
            } else {
                $gizi_status = null;
            }

            $penimbangan->bb_status = $bb_status;
            $penimbangan->tb_status = $tb_status;
            $penimbangan->gizi_status = $gizi_status;
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
