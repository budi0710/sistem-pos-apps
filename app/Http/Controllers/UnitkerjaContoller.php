<?php

namespace App\Http\Controllers;
use App\Models\Unitkerja;
use Illuminate\Http\Request;

class UnitkerjaContoller extends Controller
{
    public function load(){
        return Unitkerja::paginate(5);
    }

    public function loadData(){
        return Unitkerja::all();
    }

    public function save(Request $request){
        $unitkerja = new Unitkerja();

        $unitkerja->fn_unitkerja = $request->fn_unitkerja;
        $unitkerja->fk_unitkerja = $request->fk_unitkerja;
        return $unitkerja->save() ? response()->json(['result'=>true]) : response()->json(['result'=>false]);
    }

    public function update(Request $request){
        $unitkerja = Unitkerja::find($request->id);
        $unitkerja->fn_unitkerja = $request->fn_unitkerja_edit;
        return $unitkerja->save() ? response()->json(['result'=>true]) : response()->json(['result'=>false]);
    }

      public function delete(Request $request){
        $unitkerja = Unitkerja::find($request->id);

       return $unitkerja->delete() ? response()->json(['result'=>true]) : response()->json(['result'=>false]);
    }

     public function search(Request $request){
        $unitkerja = Unitkerja::where('fn_unitkerja','like','%'.$request->search.'%')->get();

        return ($unitkerja);
    }

    public function generateId_Unit(){
       $result  = Unitkerja::select('fk_unitkerja')
                        ->orderBy('fk_unitkerja','desc')
                        ->first();

       if ($result==null){
        return '01';
       }else{
        return $result;
       }
    }
}
