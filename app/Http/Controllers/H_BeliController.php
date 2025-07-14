<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\H_Beli;
//use App\Models\L_hpos;
use App\Models\T_Beli;
use App\Models\L_Beli;
use Illuminate\Support\Facades\DB;

class H_BeliController extends Controller
{
    public function load() {
        return H_Beli ::paginate(10);
    }

    public function loadWhere(Request $request){
        return L_Beli::where('fno_beli',$request->fno_beli)->get();
    }

    public function generateNo(){
        $result= H_Beli::select('fno_beli')->orderBy('fno_beli','desc')->first();
       if ($result==null){
          return '001';
       }else{
          return ($result);
       }
    }
}
