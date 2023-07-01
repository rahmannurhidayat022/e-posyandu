<?php

namespace App\Http\Controllers;

use App\Models\PetugasKesehatan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class PetugasController extends Controller
{
    public function getPetugas()
    {
        $data = PetugasKesehatan::select('id', 'nama')->orderBy('nama', 'asc')->get();
        return response()->json($data);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = PetugasKesehatan::select('*')->orderBy('created_at', 'desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }

        return view('petugas.index');
    }

    public function create()
    {
        return view('petugas.create');
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'nama' => 'required',
            'nik' => 'required|unique:petugas_kesehatan',
            'telp' => 'required',
            'puskesmas' => 'required',
        ], [
            'nik.unique' => 'NIK sudah digunakan',
        ]);

        if ($validated->fails()) {
            $errors = $validated->errors();
            Alert::error('Gagal', $errors->first())->autoclose(3000);
            return redirect()->back()->withInput($request->all());
        }

        try {
            $petugas = new PetugasKesehatan();
            $petugas->nama = $request->nama;
            $petugas->nik = $request->nik;
            $petugas->telp = $request->telp;
            $petugas->puskesmas = $request->puskesmas;
            $petugas->save();

            Alert::success('Berhasil', 'Berhasil menambahkan data petugas kesehatan');
            return redirect()->route('petugas.index');
        } catch (\Throwable $th) {
            Alert::error('Gagal', 'Gagal menambahkan data petugas kesehatan')->autoclose(3000);
            return redirect()->back()->withInput($request->all());
        }
    }

    public function edit($id)
    {
        $petugas = PetugasKesehatan::with(['user:id,username'])->findOrFail($id);
        return view('petugas.edit', compact('petugas'));
    }

    public function update(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'nama' => 'required',
            'nik' => ['required', function ($attribute, $value, $fail) use ($id) {
                $kader = PetugasKesehatan::findOrFail($id);

                if ($kader->nik === $value) {
                    return;
                }

                $exists = PetugasKesehatan::where('nik', $value)->where('id', '!=', $id)->exists();
                if ($exists) {
                    $fail('NIK telah digunakan');
                }
            }],
            'telp' => 'required',
            'puskesmas' => 'required',
        ], [
            'nik.unique' => 'NIK sudah digunakan',
        ]);

        if ($validated->fails()) {
            $errors = $validated->errors();
            Alert::error('Gagal', $errors->first())->autoclose(3000);
            return redirect()->back()->withInput($request->all());
        }

        try {
            $kader = PetugasKesehatan::findOrFail($id);
            $kader->nama = $request->nama;
            $kader->nik = $request->nik;
            $kader->telp = $request->telp;
            $kader->puskesmas = $request->puskesmas;
            $kader->save();

            Alert::success('Berhasil', 'Berhasil memperbaharui data petugas kesehatan');
            return redirect()->route('petugas.index');
        } catch (\Throwable $th) {
            Alert::error('Gagal', 'Gagal memperbaharui data petugas kesehatan')->autoclose(3000);
            return redirect()->back()->withInput($request->all());
        }
    }

    public function destroy($id)
    {
        try {
            PetugasKesehatan::findOrFail($id)->delete();
            Alert::success('Berhasil', 'Berhasil menghapus data petugas kesehatan');
            return redirect()->back();
        } catch (\Throwable $th) {
            Alert::error('Gagal', 'Gagal menghapus data petugas kesehatan')->autoclose(3000);
            return redirect()->back();
        }
    }
}
