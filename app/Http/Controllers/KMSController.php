<?php

namespace App\Http\Controllers;

use App\Models\Anak;
use App\Models\Antropometri;
use App\Models\PenimbanganAnak;
use Carbon\Carbon;
use Illuminate\Http\Request;

class KMSController extends Controller
{
    public function index(Request $request, $id)
    {
        if ($request->ajax()) {
            $data_bb = PenimbanganAnak::where('anak_id', $id)->orderBy('created_at', 'asc')->pluck('bb')->toArray();
            $data_tb = PenimbanganAnak::where('anak_id', $id)->orderBy('created_at', 'asc')->pluck('tb')->toArray();

            $data_bb = array_map('floatval', $data_bb);
            $data_tb = array_map('floatval', $data_tb);

            return response()->json(["bb" => $data_bb, "tb" => $data_tb]);
        }

        $latest = PenimbanganAnak::where('anak_id', $id)->latest()->with('posko:id,nama,rw')->first();
        $antropometri = Antropometri::where('bulan', $latest->usia)->first();
        $profile = Anak::findOrFail($id);
        $age = Carbon::parse($profile->tanggal_lahir)->diff(Carbon::now());
        $year = $age->y;
        $month = $age->m;
        $day = $age->d;
        $ageString = $year . " tahun " . $month . " bulan " . $day . " hari";

        return view('kms', ['id' => $id, 'profile' => $profile, 'age' => $ageString, 'latest' => $latest, 'antropometri' => $antropometri]);
    }
}