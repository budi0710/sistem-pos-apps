<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Session;

class LoginController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect('layouts.home');
        }else{
            return view('login');
        }
    }

    public function actionlogin(Request $request)
    {
        $data = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        if (Auth::Attempt($data)) {
            return redirect('layouts.home');
        }else{
            Session::flash('error', 'Email atau Password Salah');
            return redirect('/');
        }
    }
    public function actionlogout()
    {
        Auth::logout();
        return redirect('/');
    }
}
