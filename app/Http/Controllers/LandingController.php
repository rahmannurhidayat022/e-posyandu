<?php

namespace App\Http\Controllers;

use App\Models\PenimbanganAnak;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        if ($search) {
            $data = PenimbanganAnak::whereHas('anak', function ($query) use ($search) {
                $query->where('nik', 'like', "$search")
                    ->orWhere('nama', 'like', "%$search%");
            })->paginate(5);

            if ($data->isEmpty()) {
                return redirect()->back()->with('error', 'Data kosong');
            }

            return redirect()->back()->with('success', $data);
        }
        return view('index');
    }
}
