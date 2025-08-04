<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Session;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $users = User::where('email', $email)
                           // ->orWhere('username',$email)
                            ->where('password',md5($password))->count();
       
        

        if ($users){
            
            $data = User::where('email', $email)->where('password',md5($password))->first();
            $role = $data['role'];

            $role = '';
            session(['user' => $role]);
            return response()->json(['result'=>true,'message'=>"Email or password is true"]);
        }else{
            return response()->json(['result'=>false,'message'=>"Email or password is incorrect"]);
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
            Session::flash('error', 'Email atau Password Salah Silahkan dicek kembali');
            return redirect('/');
        }
    }
    public function actionlogout()
    {
        Auth::logout();
        return redirect('/');
    }
}
