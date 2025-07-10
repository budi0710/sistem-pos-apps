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
             

            $role = $data['role'];
            $id = $data->id;
            session(['user_role' => $role]);
            session(['user_id' => $id]);

             $role = $data['role'];
             
             session(['user_id' => $data->id]);
             session(['user_role'=> $role]);

            return response()->json(['result'=>true,'message'=>"Email or password is true"]);
        }else{
            return response()->json(['result'=>false,'message'=>"Email or password is incorrect"]);
        }

    }
}
