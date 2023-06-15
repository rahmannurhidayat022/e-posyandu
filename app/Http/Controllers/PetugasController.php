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
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = PetugasKesehatan::select('*')->with('user');
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
            'username' => 'required|unique:users',
            'password' => 'required|min:6|required_with:password_confirmation|confirmed',
            'nama' => 'required',
            'nik' => 'required|unique:petugas_kesehatan',
            'telp' => 'required',
            'puskesmas' => 'required',
        ], [
            'username.unique' => 'Username sudah digunakan',
            'nik.unique' => 'NIK sudah digunakan',
            'password.min' => 'Password minimal 6 digit',
            'password.confirmed' => 'Password tidak sama',
        ]);

        if ($validated->fails()) {
            $errors = $validated->errors();
            Alert::error('Gagal', $errors->first())->autoclose(3000);
            return redirect()->back()->withInput($request->all());
        }

        try {
            $user = new User();
            $user->username = $request->username;
            $user->password = $request->password;
            $user->role = 'viewer';
            $user->save();
            DB::beginTransaction();

            if ($user) {
                $petugas = new PetugasKesehatan();
                $petugas->user_id = $user->id;
                $petugas->nama = $request->nama;
                $petugas->nik = $request->nik;
                $petugas->telp = $request->telp;
                $petugas->puskesmas = $request->puskesmas;
                $petugas->save();
                DB::commit();
            }

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

    public function update(Request $request, $id, $user_id)
    {
        $validated = Validator::make($request->all(), [
            'username' => ['required', function ($attribute, $value, $fail) use ($user_id) {
                $user = User::findOrFail($user_id);

                if ($user->username === $value) {
                    return;
                }

                $exists = User::where('username', $value)->where('id', '!=', $user_id)->exists();
                if ($exists) {
                    $fail('Username telah digunakan');
                }
            }],
            'password' => 'nullable|min:6|confirmed',
            // 'password_confirmation' => 'required_if:password,!=,|confirmed',
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
            'password_confirmation.min' => 'Password minimal 6 digit',
            'password.min' => 'Password minimal 6 digit',
            'password_confirmation.confirmed' => 'Password tidak sama',
        ]);

        if ($validated->fails()) {
            $errors = $validated->errors();
            Alert::error('Gagal', $errors->first())->autoclose(3000);
            return redirect()->back()->withInput($request->all());
        }

        try {
            $user = User::findOrFail($user_id);
            $user->username = $request->username;
            if ($request->has('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->save();
            DB::beginTransaction();

            $kader = PetugasKesehatan::findOrFail($id);
            $kader->nama = $request->nama;
            $kader->nik = $request->nik;
            $kader->telp = $request->telp;
            $kader->puskesmas = $request->puskesmas;
            $kader->save();
            DB::commit();

            Alert::success('Berhasil', 'Berhasil memperbaharui data petugas kesehatan');
            return redirect()->route('petugas.index');
        } catch (\Throwable $th) {
            Alert::error('Gagal', 'Gagal memperbaharui data petugas kesehatan')->autoclose(3000);
            return redirect()->back()->withInput($request->all());
        }
    }

    public function destroy($id, $user_id)
    {
        try {
            DB::beginTransaction();
            PetugasKesehatan::findOrFail($id)->delete();
            User::findOrFail($user_id)->delete();
            DB::commit();
            Alert::success('Berhasil', 'Berhasil menghapus data petugas kesehatan');
            return redirect()->back();
        } catch (\Throwable $th) {
            Alert::error('Gagal', 'Gagal menghapus data petugas kesehatan')->autoclose(3000);
            return redirect()->back();
        }
    }
}
