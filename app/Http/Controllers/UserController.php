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
            $role = $data->role;
            session(['user_role' => $data->role]);
            session(['user_id' => $data->id]);

            switch ($role) {
                case 1:
                    $user_detail = 'Admin';
                    break;
                 case 2:
                    $user_detail = 'Engineer';
                    break;
                case 3:
                    $user_detail = 'Keuangan';
                    break;
                case 4:
                    $user_detail = 'Karyawan';
                    break;
                default:
                    # code...
                    break;
            }

            session(['user_detail'=>$user_detail]);

            return response()->json(['result'=>true,'message'=>"Email or password is true",'data'=>$role]);
        }else{
            return response()->json(['result'=>false,'message'=>"Email or password is incorrect"]);


        }
    }
}
