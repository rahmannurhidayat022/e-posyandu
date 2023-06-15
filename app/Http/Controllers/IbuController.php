<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Alert;
use App\Models\Ibu;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert as FacadesAlert;

class IbuController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Ibu::select('*')->with('posko');
            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }

        return view('ibu.index');
    }

    public function create()
    {
        return view('ibu.create');
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'nama' => 'required',
            'nik' => 'required|unique:ibu',
            'telp' => 'required',
            'jalan' => 'required',
            'rt' => 'required',
            'rw' => 'required',
            'ayah' => 'required',
            'darah' => 'required',
            'tanggal_lahir' => 'required',
            'posko_id' => 'required',
        ]);

        if ($validated->fails()) {
            $errors = $validated->errors();
            FacadesAlert::error('Gagal', $errors->first())->autoclose(3000);
            return redirect()->back()->withInput($request->all());
        }

        try {
            $ibu = new Ibu();
            $ibu->nama = $request->nama;
            $ibu->nik = $request->nik;
            $ibu->telp = $request->telp;
            $ibu->ayah = $request->ayah;
            $ibu->tanggal_lahir = $request->tanggal_lahir;
            $ibu->darah = $request->darah;
            $ibu->jalan = $request->jalan;
            $ibu->rw = $request->rw;
            $ibu->rt = $request->rt;
            $ibu->posko_id = $request->posko_id;
            $ibu->save();

            Alert::success('Berhasil', 'Berhasil menambahkan data ibu');
            return redirect()->route('ibu.index');
        } catch (\Throwable $th) {
            Alert::error('Gagal', 'Gagal menambahkan data ibu')->autoclose(3000);
            return redirect()->back()->withInput($request->all());
        }
    }

    public function edit($id)
    {
        $ibu = Ibu::with(['posko:id'])->findOrFail($id);
        return view('ibu.edit', compact('ibu'));
    }

    public function update(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'nama' => 'required',
            'nik' => ['required', function ($attribute, $value, $fail) use ($id) {
                $ibu = Ibu::findOrFail($id);

                if ($ibu->nik === $value) {
                    return;
                }

                $exists = Ibu::where('nik', $value)->where('id', '!=', $id)->exists();
                if ($exists) {
                    $fail('NIK telah digunakan');
                }
            }],
            'telp' => 'required',
            'jalan' => 'required',
            'ayah' => 'required',
            'darah' => 'required',
            'tanggal_lahir' => 'required',
            'rt' => 'required',
            'rw' => 'required',
            'posko_id' => 'required',
        ]);

        if ($validated->fails()) {
            $errors = $validated->errors();
            Alert::error('Gagal', $errors->first())->autoclose(3000);
            return redirect()->back()->withInput($request->all());
        }

        try {
            $ibu = Ibu::findOrFail($id);
            $ibu->nama = $request->nama;
            $ibu->nik = $request->nik;
            $ibu->telp = $request->telp;
            $ibu->jalan = $request->jalan;
            $ibu->ayah = $request->ayah;
            $ibu->darah = $request->darah;
            $ibu->tanggal_lahir = $request->tanggal_lahir;
            $ibu->rw = $request->rw;
            $ibu->rt = $request->rt;
            $ibu->posko_id = $request->posko_id;
            $ibu->save();
            DB::commit();

            Alert::success('Berhasil', 'Berhasil memperbaharui data ibu');
            return redirect()->route('ibu.index');
        } catch (\Throwable $th) {
            Alert::error('Gagal', 'Gagal memperbaharui data ibu')->autoclose(3000);
            return redirect()->back()->withInput($request->all());
        }
    }

    public function destroy($id)
    {
        try {
            Ibu::findOrFail($id)->delete();
            Alert::success('Berhasil', 'Berhasil menghapus data ibu');
            return redirect()->back();
        } catch (\Throwable $th) {
            Alert::error('Gagal', 'Gagal menghapus data ibu')->autoclose(3000);
            return redirect()->back();
        }
    }
}
