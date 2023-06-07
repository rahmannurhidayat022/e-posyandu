<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Posko;
use Alert;

class PoskoController extends Controller
{
    public function index()
    {
        return view('posko');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'jalan' => 'required',
            'rw' => 'required',
        ]);

        try {
            $data = new Posko();
            $data->nama = $validated['nama'];
            $data->jalan = $validated['jalan'];
            $data->rw = $validated['rw'];

            $data->save();

            Alert::success('success', 'Berhasil menambahkan data posko');
            return redirect()->back();
        } catch (\Throwable $th) {
            Alert::error('error', 'Gagal menambahkan data posko')->autoclose(3000);
            return redirect()->back()->withInput($request->all());
        }
    }
}
