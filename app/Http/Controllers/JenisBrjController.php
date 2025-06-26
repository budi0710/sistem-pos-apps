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

        $jenisbrj->fn_jenis = $request->jenis;
        $jenisbrj->fk_jenis = $request->fk_jenis;
        return $jenisbrj->save() ? response()->json(['result'=>true]) : response()->json(['result'=>false]);
    }

    public function update(Request $request){
        $jenis = Jenis::find($request->id);
        $jenis->fn_jenis = $request->jenis_edit;
        return $jenis->save() ? response()->json(['result'=>true]) : response()->json(['result'=>false]);
    }

      public function delete(Request $request){
        $Jenis = Jenis::find($request->id);
       return $Jenis->delete() ? response()->json(['result'=>true]) : response()->json(['result'=>false]);
    }

     public function search(Request $request){
        $Jenis = Jenis::where('fn_jenis','like','%'.$request->search.'%')->get();
        return ($Jenis);
    }
}
