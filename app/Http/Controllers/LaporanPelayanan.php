<?php

namespace App\Http\Controllers;

use App\Models\Imunisasi;
use App\Models\KesehatanLansia;
use App\Models\PenimbanganAnak;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class LaporanPelayanan extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $penimbangan = PenimbanganAnak::select('created_at')
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

            $data = $penimbangan->concat($imunisasi)->concat($kesehatan_lansia);

            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }

        return view('laporan');
    }

    public function getReportByMonth(Request $request)
    {
        $kategori = $request->input('kategori');
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');
        $data = null;

        if ($kategori == "Penimbangan Anak") {
            $data = PenimbanganAnak::whereMonth('created_at', $bulan)
                ->whereYear('created_at', $tahun)
                ->with(['anak'])
                ->get();
        }

        if ($kategori == "Imunisasi Anak") {
            $data = Imunisasi::whereMonth('created_at', $bulan)
                ->whereYear('created_at', $tahun)
                ->with(['anak'])
                ->get();
        }

        if ($kategori == "Kesehatan Lansia") {
            $data = KesehatanLansia::whereMonth('created_at', $bulan)
                ->whereYear('created_at', $tahun)
                ->with(['lansia'])
                ->get();
        }

        return response()->json($data);
    }
}
