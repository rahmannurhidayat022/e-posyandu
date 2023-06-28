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
                        'tanggal' => Carbon::parse($item->created_at)->format('m/Y'),
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
                        'tanggal' => Carbon::parse($item->created_at)->format('m/Y'),
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
                        'tanggal' => Carbon::parse($item->created_at)->format('m/Y'),
                    ];
                });

            $data = $penimbangan->concat($imunisasi)->concat($kesehatan_lansia);

            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }

        return view('laporan');
    }
}
