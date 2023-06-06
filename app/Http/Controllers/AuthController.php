<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Alert;
use App\Models\Kader;

class AuthController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $kaderInformation = Kader::where('user_id', $user->id)->first();

            if ($kaderInformation) {
                $user->user_information = $kaderInformation;
            } else {
                $user->user_information = ['nama' => 'Kang Admin'];
            }
            return redirect()->intended('/dashboard');
        } else {
            Alert::error('Gagal masuk', 'Pastikan username dan password yang anda ketikan sudah benar')->autoclose(5000);
            return redirect()->back()->withInput($request->only('username'));
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('auth.index');
    }
}
