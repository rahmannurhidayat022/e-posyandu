<?php

namespace App\Http\Controllers;

use App\Models\Anak;
use App\Models\Ibu;
use App\Models\Imunisasi;
use App\Models\KesehatanLansia;
use App\Models\Lansia;
use App\Models\PenimbanganAnak;
use App\Models\Posko;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $posko = null;
        if (Auth::user()->posko_id) {
            $posko = Posko::find(Auth::user()->posko_id);
        }

        $totalAnak = Anak::all()->count();
        $totalIbu = Ibu::all()->count();
        $totalLansia = Lansia::all()->count();
        $totalPosko = Posko::all()->count();

        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
        $bb_status['sangat_kurang'] = PenimbanganAnak::where('bb_status', 'Sangat Kurang')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
        $bb_status['kurang'] = PenimbanganAnak::where('bb_status', 'Kurang')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
        $bb_status['normal'] = PenimbanganAnak::where('bb_status', 'Normal')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
        $bb_status['risiko_berat_badan'] = PenimbanganAnak::where('bb_status', 'Risiko Berat Badan')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $tb_status['sangat_pendek'] = PenimbanganAnak::where('tb_status', 'Sangat Pendek')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
        $tb_status['pendek'] = PenimbanganAnak::where('tb_status', 'Pendek')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
        $tb_status['normal'] = PenimbanganAnak::where('tb_status', 'Normal')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
        $tb_status['tinggi'] = PenimbanganAnak::where('tb_status', 'Tinggi')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $penimbangan = PenimbanganAnak::select('created_at')
            ->whereMonth('created_at', Carbon::now()->format('m'))
            ->whereYear('created_at', Carbon::now()->format('Y'))
            ->get()
            ->unique(function ($item) {
                return Carbon::parse($item->created_at)->format('m/Y');
            })
            ->map(function ($item) {
                return [
                    'laporan' => 'Penimbangan Anak',
                    'bulan' => Carbon::parse($item->created_at)->format('m'),
                    'tahun' => Carbon::parse($item->created_at)->format('Y'),
                ];
            });
        $imunisasi = Imunisasi::select('created_at')
            ->whereMonth('created_at', Carbon::now()->format('m'))
            ->whereYear('created_at', Carbon::now()->format('Y'))
            ->get()
            ->unique(function ($item) {
                return Carbon::parse($item->created_at)->format('m/Y');
            })
            ->map(function ($item) {
                return [
                    'laporan' => 'Imunisasi Anak',
                    'bulan' => Carbon::parse($item->created_at)->format('m'),
                    'tahun' => Carbon::parse($item->created_at)->format('Y'),
                ];
            });
        $kesehatan_lansia = KesehatanLansia::select('created_at')
            ->whereMonth('created_at', Carbon::now()->format('m'))
            ->whereYear('created_at', Carbon::now()->format('Y'))
            ->get()
            ->unique(function ($item) {
                return Carbon::parse($item->created_at)->format('m/Y');
            })
            ->map(function ($item) {
                return [
                    'laporan' => 'Kesehatan Lansia',
                    'bulan' => Carbon::parse($item->created_at)->format('m'),
                    'tahun' => Carbon::parse($item->created_at)->format('Y'),
                ];
            });

        $data = new \stdClass();
        $data->total_anak = $totalAnak;
        $data->total_ibu = $totalIbu;
        $data->total_lansia = $totalLansia;
        $data->total_posko = $totalPosko;
        $data->bb_status = $bb_status;
        $data->tb_status = $tb_status;
        $data->date = $startDate->format('d-m-Y');
        $data->laporan = $penimbangan->concat($imunisasi)->concat($kesehatan_lansia);

        return view('dashboard', ['posko' => $posko, 'data' => $data]);
    }
}
