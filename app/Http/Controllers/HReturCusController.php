<?php

namespace App\Http\Controllers;
use App\Models\h_retur_customer;
use App\Models\d_retur_customer;
use App\Models\l_retur_customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HReturCusController extends Controller
{
    public function generateNo(){
        $result= h_retur_customer::select('fno_retur_cus')->orderBy('fno_retur_cus','desc')->first();
       if ($result==null){
          return '001';
       }else{
          return ($result);
       }
    }

    public function load() {
        return h_retur_customer::paginate(10);
    }

    public function loadWhere(Request $request){
        return l_retur_customer::where('fno_retur_cus',$request->fno_retur_cus)->get();
    }

    public function saveData(Request $request) {
        $h_retur = new h_retur_customer();

        $fno_retur_cus = $request->fno_retur_cus;

        $h_retur->fno_retur_cus = $request->fno_retur_cus;
        $h_retur->ftgl_retur_cus = $request->ftgl_retur_cus;
        $h_retur->fnama_customer = $request->fnama_customer;
        $h_retur->fsurat_jalan = $request->fsurat_jalan;
        $h_retur->fket = $request->fket;
        $h_retur->userid =  $request->session()->get('user_id');
        $h_retur->save();

        $data = $request->detail_data;
        
        for ($i=0; $i < count($data) ; $i++) { 
            $master_data = $data[$i];
            $fk_brj = $master_data['fk_brj'];
            $fq_retur  = $master_data['fq_retur'];
          
            DB::insert('INSERT INTO t_retur_customer (fno_retur_cus, fk_brj, fq_retur) VALUES (?, ?, ?)', [$fno_retur_cus, $fk_brj, $fq_retur]);
        }

        return response()->json(['result'=>true]) ;
    }

    public function delete(request $request) {
        // check receive apakah sudah pernah dilakukan transaksi 
        // ambil fno_pos terlebih dahulu
        $h_retur_customer = h_retur_customer::select('fno_retur_cus')->where("id",$request->id)->get();
        // ambil data index ke 0 dan key fno_retur_cus
        $h_retur_customer = $h_retur_customer[0]['fno_retur_cus'];
       
        // delete data di table header berdasarkan primary key id
        $h_retur_customer = h_retur_customer::find($request->id);
        $h_retur_customer->delete();

        // delete data di table detail berdasarkan fno_retur_cus
        $d_retur_customer = d_retur_customer::where('fno_retur_cus',$fno_retur_cus)->delete();
        return $detail ? response()->json(['result'=>true]) : response()->json(['result'=>false]);
    }
}
