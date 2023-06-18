<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kader;
use Alert;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class KaderController extends Controller
{
    public function getKader()
    {
        $data = Kader::select('id', 'nama')->orderBy('nama', 'asc')->get();
        return response()->json($data);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Kader::select('*')->with('posko')->with('user');
            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }

        return view('kader.index');
    }

    public function create()
    {
        return view('kader.create');
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'username' => 'required|unique:users',
            'password' => 'required|min:6|required_with:password_confirmation|confirmed',
            'nama' => 'required',
            'nik' => 'required|unique:kader',
            'telp' => 'required',
            'jalan' => 'required',
            'rt' => 'required',
            'rw' => 'required',
            'posko_id' => 'required',
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
            $user->role = 'operator';
            $user->save();
            DB::beginTransaction();

            if ($user) {
                $kader = new Kader();
                $kader->user_id = $user->id;
                $kader->nama = $request->nama;
                $kader->nik = $request->nik;
                $kader->telp = $request->telp;
                $kader->jalan = $request->jalan;
                $kader->rw = $request->rw;
                $kader->rt = $request->rt;
                $kader->posko_id = $request->posko_id;
                $kader->save();
                DB::commit();
            }

            Alert::success('Berhasil', 'Berhasil menambahkan data kader');
            return redirect()->route('kader.index');
        } catch (\Throwable $th) {
            Alert::error('Gagal', 'Gagal menambahkan data kader')->autoclose(3000);
            return redirect()->back()->withInput($request->all());
        }
    }

    public function edit($id)
    {
        $kader = Kader::with(['user:id,username', 'posko:id'])->findOrFail($id);
        return view('kader.edit', compact('kader'));
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
                $kader = Kader::findOrFail($id);

                if ($kader->nik === $value) {
                    return;
                }

                $exists = Kader::where('nik', $value)->where('id', '!=', $id)->exists();
                if ($exists) {
                    $fail('NIK telah digunakan');
                }
            }],
            'telp' => 'required',
            'jalan' => 'required',
            'rt' => 'required',
            'rw' => 'required',
            'posko_id' => 'required',
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

            $kader = Kader::findOrFail($id);
            $kader->nama = $request->nama;
            $kader->nik = $request->nik;
            $kader->telp = $request->telp;
            $kader->jalan = $request->jalan;
            $kader->rw = $request->rw;
            $kader->rt = $request->rt;
            $kader->posko_id = $request->posko_id;
            $kader->save();
            DB::commit();

            Alert::success('Berhasil', 'Berhasil memperbaharui data kader');
            return redirect()->route('kader.index');
        } catch (\Throwable $th) {
            Alert::error('Gagal', 'Gagal memperbaharui data kader')->autoclose(3000);
            return redirect()->back()->withInput($request->all());
        }
    }

    public function destroy($id, $user_id)
    {
        try {
            DB::beginTransaction();
            Kader::findOrFail($id)->delete();
            User::findOrFail($user_id)->delete();
            DB::commit();
            Alert::success('Berhasil', 'Berhasil menghapus data kader');
            return redirect()->back();
        } catch (\Throwable $th) {
            Alert::error('Gagal', 'Gagal menghapus data kader')->autoclose(3000);
            return redirect()->back();
        }
    }
}
