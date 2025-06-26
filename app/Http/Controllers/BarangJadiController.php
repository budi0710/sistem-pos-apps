<?php

namespace App\Http\Controllers;
use App\Models\BarangJadi;
use Illuminate\Http\Request;

class BarangJadiController extends Controller
{
    public function load(){
        return BarangJadi::paginate(5);
    }

    public function loadData(){
        return BarangJadi::all();
    }

    public function save(Request $request){
        $barangjadi = new BarangJadi();

        $barangjadi->fn_brj = $request->fn_brj;
        $barangjadi->fk_brj = $request->fk_brj;
        
        return $barangjadi->save() ? response()->json(['result'=>true]) : response()->json(['result'=>false]);
    }

    public function update(Request $request){
        $barangjadi = BarangJadi::find($request->id);

        $barangjadi->fn_brj = $request->fn_brj_edit;
        $barangjadi->fk_jns_brj = $request->result_jenis_edit;
        $barangjadi->fpartno = $request->fpartno_edit;
        $barangjadi->fbrt_neto = $request->fbrt_neto_edit;
        $barangjadi->fbrt_bruto = $request->fbrt_bruto_edit;
        $barangjadi->fdimensi = $request->fdimensi_edit;

        return $barangjadi->save() ? response()->json(['result'=>true]) : response()->json(['result'=>false]);
    }

      public function delete(Request $request){
        $barangjadi = BarangJadi::find($request->id);
       return $barangjadi->delete() ? response()->json(['result'=>true]) : response()->json(['result'=>false]);
    }

     public function search(Request $request){
        $barangjadi = BarangJadi::where('fn_brj','like','%'.$request->search.'%')->get();
        return ($barangjadi);
    }

}
