<?php

namespace App\Http\Controllers;
use App\Models\H_stbj;
use App\Models\T_stbj;
use App\Models\L_Detail_STBJ;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class H_stbjController extends Controller
{

    public function load() {
        return H_stbj::paginate(10);
    }

    public function loadWhere(Request $request){
        return L_Detail_STBJ::where('fno_stbj',$request->fno_stbj)->get();
    }

    public function saveData(Request $request)
    {
        $h_stbj = new H_stbj();
        $fno_stbj = $request->fno_stbj;

        $h_stbj->fno_stbj =  $fno_stbj;
        $h_stbj->ftgl_stbj = $request->ftgl_stbj;
        $h_stbj->description = $request->description;
        $h_stbj->userid =  $request->session()->get('user_id');
        $h_stbj->save();

        $data = $request->detail_data;
        //dd($data);

        for ($i=0; $i < count($data) ; $i++) { 
            $master_data = $data[$i];
            $fk_brj = $master_data['fk_brj'];
            $fq_stbj  = $master_data['fq_stbj'];
            DB::insert('INSERT INTO t_stbj (fno_stbj, fk_brj, fq_stbj) VALUES (?, ?, ?)', [$fno_stbj, $fk_brj, $fq_stbj]);
        }
       return response()->json(['result'=>true]) ;
    }
    public function generateNo(){
        $result= H_stbj::select('fno_stbj')->orderBy('fno_stbj','desc')->first();
       if ($result==null){
          return '001';
       }else{
          return ($result);
       }
    }

    public function delete(request $request)
    {
        // check receive apakah sudah pernah dilakukan transaksi 

        // ambil fno_pos terlebih dahulu
        $h_stbj = H_stbj::select('fno_stbj')->where("id",$request->id)->get();
        // ambil data index ke 0 dan key fno_pos
        $h_stbj = $h_poc[0]['fno_stbj'];
       
        // delete data di table header berdasarkan primary key id
        $h_stbj = H_stbj::find($request->id);
        $h_stbj->delete();

        // delete data di table detail berdasarkan fno_pos
        $t_stbj = T_stbj::where('fno_stbj',$fno_poc)->delete();
        
        return $detail ? response()->json(['result'=>true]) : response()->json(['result'=>false]);
    }
}
