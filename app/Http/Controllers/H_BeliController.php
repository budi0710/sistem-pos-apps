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

    public function saveData(Request $request) {
        $h_beli = new H_Beli();
        $fno_beli = $request->fno_beli;

        $h_beli->fno_beli =  $fno_beli;
        $h_beli->kode_sup = $request->kode_sup;
        $h_beli->ftgl_beli = $request->ftgl_beli;
        $h_beli->surat_jalan = $request->surat_jalan;
        $h_beli->description = $request->description;
        $h_beli->userid =  $request->session()->get('user_id');
        $h_beli->save();

        $data = $request->detail_data;

        for ($i=0; $i < count($data) ; $i++) { 
            $master_data = $data[$i];
            $fno_spo = $master_data['fno_spo'];
            $fq_beli  = $master_data['fq_beli'];
            DB::insert('INSERT INTO t_beli (fno_beli, fno_spo, fq_beli) VALUES (?, ?, ?)', [$fno_beli, $fno_spo, $fq_beli]);
        }
       return response()->json(['result'=>true]) ;
       
    }
}
