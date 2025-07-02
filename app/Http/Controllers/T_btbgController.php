<?php

namespace App\Http\Controllers;
use App\Models\L_dbtbg;
use Illuminate\Http\Request;

class T_btbgController extends Controller
{
    public function loadWhere(Request $request){
        return L_dbtbg::where('fno_btbg',$request->fno_btbg)->get();
    }
}
