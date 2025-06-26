<?php

namespace App\Http\Controllers;
use App\Models\Satuan;
use Illuminate\Http\Request;

class SatuanController extends Controller
{
    public function load(){
        return Satuan::paginate(5);
    }

    public function loadData(){
        return Satuan::all();
    }

    public function save(Request $request){
        $satuan = new Satuan();

        $satuan->fn_satuan = $request->satuan;
        $satuan->fk_sat = $request->fk_sat;
        return $satuan->save() ? response()->json(['result'=>true]) : response()->json(['result'=>false]);
    }

    public function update(Request $request){
        $satuan = Satuan::find($request->id);
        $satuan->fn_satuan = $request->satuan_edit;
        return $satuan->save() ? response()->json(['result'=>true]) : response()->json(['result'=>false]);
    }

      public function delete(Request $request){
        $Satuan = Satuan::find($request->id);

       return $Satuan->delete() ? response()->json(['result'=>true]) : response()->json(['result'=>false]);
    }

     public function search(Request $request){
        $satuan = Satuan::where('fn_satuan','like','%'.$request->search.'%')->get();

        return ($satuan);
    }
}
