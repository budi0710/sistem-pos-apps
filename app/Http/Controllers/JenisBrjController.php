<?php

namespace App\Http\Controllers;
use App\Models\JenisBRJ;
use Illuminate\Http\Request;

class JenisBrjController extends Controller
{
    public function load(){
        return JenisBRJ::paginate(5);
    }

    public function loadData(){
        return JenisBRJ::all();
    }

    public function save(Request $request){
        $jenisbrj = new JenisBRJ();

        $jenisbrj->fn_jns_brj = $request->jenis;
        $jenisbrj->fk_jns_brj = $request->fk_jenis;
        return $jenisbrj->save() ? response()->json(['result'=>true]) : response()->json(['result'=>false]);
    }

    public function update(Request $request){
        $jenisbrg = JenisBRJ::find($request->id);
        $jenisbrg->fn_jns_brj = $request->jenis_edit;
        return $jenisbrg->save() ? response()->json(['result'=>true]) : response()->json(['result'=>false]);
    }

      public function delete(Request $request){
        $jenisbrg = JenisBRJ::find($request->id);
       return $jenisbrg->delete() ? response()->json(['result'=>true]) : response()->json(['result'=>false]);
    }

     public function search(Request $request){
        $jenisbrg = JenisBRJ::where('fn_jns_brj','like','%'.$request->search.'%')->get();
        return ($jenisbrg);
    }
}
