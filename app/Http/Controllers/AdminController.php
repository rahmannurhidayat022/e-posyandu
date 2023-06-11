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
            'password' => 'required|min:6|confirmed',
        ], [
            'username.unique' => 'Username sudah terpakai',
            'password.min:6' => 'Password minimal 6 digit',
            'password.confirmed' => 'Password tidak sama',
        ]);

        if ($validated->fails()) {
            $errors = $validated->errors();
            Alert::error('Gagal', $errors->first())->autoclose(3000);
            return redirect()->back()->withInput($request->all());
        }

        try {
            $data = new User();
            $data->username = $request->username;
            $data->jalan = Hash::make($request->password);
            $data->role = 'admin';
            $data->save();

            Alert::success('Berhasil', 'Berhasil menambahkan data akun admin');
            return redirect()->route('admin.index');
        } catch (\Throwable $th) {
            Alert::error('Gagal', 'Gagal menambahkan data akun admin')->autoclose(3000);
            return redirect()->back()->withInput($request->all());
        }
    }
}
