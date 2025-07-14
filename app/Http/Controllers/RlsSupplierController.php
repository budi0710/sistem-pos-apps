<?php

namespace App\Http\Controllers;
use App\Models\RlsSupplier;
use App\Models\L_rls_brg_sup;
use Illuminate\Http\Request;

class RlsSupplierController extends Controller
{
    public function load(){
        return L_rls_brg_sup::paginate(5);
    }

    public function loadData(){
        return L_rls_brg_sup::all();
    }

    public function save(Request $request){
        $rls_sup = new RlsSupplier();

        $rls_sup->fn_satuan = $request->satuan;
        $rls_sup->fk_sat = $request->fk_sat;
        return $rls_sup->save() ? response()->json(['result'=>true]) : response()->json(['result'=>false]);
    }

    public function update(Request $request){
        $rls_sup = RlsSupplier::find($request->id);
        $rls_sup->fn_satuan = $request->satuan_edit;
        return $rls_sup->save() ? response()->json(['result'=>true]) : response()->json(['result'=>false]);
    }

      public function delete(Request $request){
        $rls_sup = RlsSupplier::find($request->id);

       return $rls_sup->delete() ? response()->json(['result'=>true]) : response()->json(['result'=>false]);
    }

     public function search(Request $request){
        $rls_sup = RlsSupplier::where('fn_satuan','like','%'.$request->search.'%')->get();

        return ($rls_sup);
    }

    public function generateId_RBS(){
       $result  = RlsSupplier::select('fno_rbs')
                        ->orderBy('fno_rbs','desc')
                        ->first();

       if ($result==null){
        return '001';
       }else{
        return $result;
       }
    }
}
