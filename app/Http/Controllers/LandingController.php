<?php

namespace App\Http\Controllers;

use App\Models\Anak;
use App\Models\Antropometri;
use App\Models\PenimbanganAnak;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        if ($search) {
            $data = Anak::where('nik', 'like', "$search")
                ->orWhere('nama', 'like', "%$search%")->paginate(5);

            if ($data->isEmpty()) {
                return redirect()->back()->with('error', 'Data kosong');
            }

            return redirect()->back()->with('success', $data);
        }
        return view('index');
    }

    public function kms(Request $request, $id)
    {
        if ($request->ajax()) {
            $data_bb = PenimbanganAnak::where('anak_id', $id)->orderBy('created_at', 'asc')->pluck('bb')->toArray();
            $data_tb = PenimbanganAnak::where('anak_id', $id)->orderBy('created_at', 'asc')->pluck('tb')->toArray();

            $data_bb = array_map('floatval', $data_bb);
            $data_tb = array_map('floatval', $data_tb);

            return response()->json(["bb" => $data_bb, "tb" => $data_tb]);
        }

        $profile = Anak::findOrFail($id);
        $age = Carbon::parse($profile->tanggal_lahir)
            ->diff(Carbon::now());
        $latest = PenimbanganAnak::where('anak_id', $id)
            ->latest()
            ->with('posko:id,nama,rw')
            ->first();
        $antropometri_bb = Antropometri::where('bulan', $latest->usia)
            ->where('tipe', 'bb')
            ->where('jenis_kelamin', $profile->jenis_kelamin)
            ->first();
        $antropometri_tb = Antropometri::where('bulan', $latest->usia)
            ->where('tipe', 'tb')
            ->where('jenis_kelamin', $profile->jenis_kelamin)
            ->first();

        $year = $age->y;
        $month = $age->m;
        $day = $age->d;
        $ageString = $year . " tahun " . $month . " bulan " . $day . " hari";

        return view('public_kms', [
            'id' => $id,
            'profile' => $profile,
            'age' => $ageString,
            'latest' => $latest,
            'antropometri_bb' => $antropometri_bb,
            'antropometri_tb' => $antropometri_tb
        ]);
    }
}
