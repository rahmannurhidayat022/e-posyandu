<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Alert;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;


class AdminController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::where('role', 'admin');
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('d/m/Y');
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d/m/Y');
                })
                ->make(true);
        }

        return view('admin.index');
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'username' => 'required|unique:users',
            'password' => 'required|min:6|required_with:password_confirmation|confirmed',
        ], [
            'username.unique' => 'Username sudah digunakan',
            'password.min' => 'Password minimal 6 digit',
            'password.confirmed' => 'Password tidak sama',
        ]);

        if ($validated->fails()) {
            $errors = $validated->errors();
            Alert::error('Gagal', $errors->first())->autoclose(3000);
            return redirect()->back()->withInput($request->only('username'));
        }

        try {
            $data = new User();
            $data->username = $request->username;
            $data->password = Hash::make($request->password);
            $data->role = 'admin';
            $data->save();

            Alert::success('Berhasil', 'Berhasil menambahkan data akun admin');
            return redirect()->route('admin.index');
        } catch (\Throwable $th) {
            Alert::error('Gagal', 'Gagal menambahkan data akun admin')->autoclose(3000);
            return redirect()->back()->withInput($request->all());
        }
    }

    public function edit($id)
    {
        $data = User::select('id', 'username')->findOrFail($id);
        return view('admin.edit', ["user" => $data, 'id' => $id]);
    }

    public function update(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'username' => ['required', function ($attribute, $value, $fail) use ($id) {
                $user = User::findOrFail($id);

                if ($user->username === $value) {
                    return;
                }

                $exists = User::where('username', $value)->where('id', '!=', $id)->exists();
                if ($exists) {
                    $fail('Username telah digunakan');
                }
            }],
            'password' => 'required|min:6|required_with:password_confirmation|confirmed',
        ], [
            'password.min' => 'Password minimal 6 digit',
            'password.confirmed' => 'Password tidak sama',
        ]);

        if ($validated->fails()) {
            $errors = $validated->errors();
            Alert::error('Gagal', $errors->first())->autoclose(3000);
            return redirect()->back()->withInput($request->only('username'));
        }

        try {
            $data = User::findOrFail($id);
            $data->username = $request->username;
            $data->password = Hash::make($request->password);
            $data->role = 'admin';
            $data->save();

            Alert::success('Berhasil', 'Berhasil memperbaharui data akun admin');
            return redirect()->route('admin.index');
        } catch (\Throwable $th) {
            Alert::error('Gagal', 'Gagal memperbaharui data akun admin')->autoclose(3000);
            return redirect()->back()->withInput($request->all());
        }
    }

    public function destroy($id)
    {
        try {
            User::findOrFail($id)->delete();
            Alert::success('Berhasil', 'Berhasil menghapus data posko');
            return redirect()->back();
        } catch (\Throwable $th) {
            Alert::error('Gagal', 'Gagal menghapus data posko')->autoclose(3000);
            return redirect()->back();
        }
    }
}
