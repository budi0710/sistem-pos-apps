<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
     public function login(Request $request){
        
        $email = $request->email;
        $password = $request->password;
        
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $users = User::where('email', $email)
                          //  ->orWhere('username',$email)
                            ->where('password',md5($password))->count();
       
        if ($users){
            $data = User::where('email', $email)->where('password',md5($password))->first();
            
            session(['user_role' => $data->role]);
            session(['user_id' => $data->id]);
            
            return response()->json(['result'=>true,'message'=>"Login berhasil"]);
        }
    }
}
