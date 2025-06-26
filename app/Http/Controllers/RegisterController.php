<?php

namespace App\Http\Controllers;
Use Illuminate\Http\Request;
Use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Session;

class RegisterController extends Controller
{
        public function register()
    {
        return view('register');
    }
    
    public function actionregister(Request $request)
    {
        $users = User::create([
            'email' => $request->email,
            'name' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'active' => 1
        ]);

        Session::flash('message', 'Register Berhasil. Akun Anda sudah Aktif silahkan Login menggunakan username dan password.');
        return redirect('register');
    }
}

