<?php

namespace App\Http\Controllers;
use App\Models\h_krm_fg;
use App\Models\t_krm_fg;
use App\Models\l_krm_fg_detail;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HkrmfgController extends Controller
{

    public function load() {
        return h_krm_fg::paginate(10);
    }

    public function loadWhere(Request $request){
        return l_krm_fg_detail::where('fno_krm_fg',$request->fno_krm_fg)->get();
    }

    public function generateNo(){
        $result= h_krm_fg::select('fno_krm_fg')->orderBy('fno_krm_fg','desc')->first();
       if ($result==null){
          return '001';
       }else{
          return ($result);
       }
    }

    public function saveData(Request $request) {
        $h_krm = new h_krm_fg();

        $fno_krm_fg = $request->fno_krm_fg;

        $h_krm->fno_krm_fg = $request->fno_krm_fg;
        $h_krm->ftgl_krm_fg = $request->ftgl_krm_fg;
        $h_krm->fn_jenis_krm = $request->fn_jenis_krm;
        $h_krm->ftujuan = $request->ftujuan;
        $h_krm->falamat = $request->falamat;
        $h_krm->fket = $request->fket;
        $h_krm->userid =  $request->session()->get('user_id');
        $h_krm->save();

        $data = $request->detail_data;
        
        for ($i=0; $i < count($data) ; $i++) { 
            $master_data = $data[$i];
            $fk_brj = $master_data['fk_brj'];
            $fq_krm_fg  = $master_data['fq_krm_fg'];
          
            DB::insert('INSERT INTO t_krm_fg (fno_krm_fg, fk_brj, fq_krm_fg) VALUES (?, ?, ?)', [$fno_krm_fg, $fk_brj, $fq_krm_fg]);
        }

        return response()->json(['result'=>true]) ;
    }

    public function delete(request $request) {
        // check receive apakah sudah pernah dilakukan transaksi 
        // ambil fno_pos terlebih dahulu
        $h_krm = h_krm_fg::select('fno_krm_fg')->where("id",$request->id)->get();
        // ambil data index ke 0 dan key fno_pos
        $h_krm = $h_krm_fg[0]['fno_krm_fg'];
       
        // delete data di table header berdasarkan primary key id
        $h_krm = fno_krm_fg::find($request->id);
        $h_krm->delete();

        // delete data di table detail berdasarkan kirim
        $t_krm = t_krm_fg::where('fno_krm_fg',$fno_krm_fg)->delete();
        return $detail ? response()->json(['result'=>true]) : response()->json(['result'=>false]);
    }
}
