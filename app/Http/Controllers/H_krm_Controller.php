<?php

namespace App\Http\Controllers;
use App\Models\H_krm;
use App\Models\T_krm;
use App\Models\L_H_KRM;
use App\Models\L_Detail_Krm;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class H_krm_Controller extends Controller
{

    public function loadWhere(Request $request){
        return L_Detail_Krm::where('fno_krm',$request->fno_krm)->get();
    }

    public function load()
    {
        return L_H_KRM::paginate(10);
    }

    public function generateNo(){
        $result= H_krm::select('fno_krm')->orderBy('fno_krm','desc')->first();
       if ($result==null){
          return '001';
       }else{
          return ($result);
       }
    }

    public function saveData(Request $request) {
        $h_kirim = new H_krm();

        $fno_krm = $request->fno_krm;

        $h_kirim->fno_krm = $request->fno_krm;
        $h_kirim->ftgl_krm = $request->ftgl_krm;
        $h_kirim->kode_cus = $request->kode_cus;
        $h_kirim->fno_poc = $request->fno_poc;
        $h_kirim->description = $request->description;
        $h_kirim->fno_plat_mobil = $request->fno_plat_mobil;
        $h_kirim->fnama_supir = $request->fnama_supir;
        $h_kirim->userid =  $request->session()->get('user_id');
        $h_kirim->save();

        $data = $request->detail_data;
        
        for ($i=0; $i < count($data) ; $i++) { 
            $master_data = $data[$i];
            $fnos_poc= $master_data['fnos_poc'];
            $fq_krm  = $master_data['fq_krm'];
            DB::insert('INSERT INTO t_krm (fno_krm, fnos_poc, fq_krm) VALUES (?, ?, ?)', [$fno_krm, $fnos_poc, $fq_krm]);
        }

        return response()->json(['result'=>true]) ;
    }
}
