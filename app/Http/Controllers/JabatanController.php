<?php

namespace App\Http\Controllers;
use App\Models\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    public function load(){
        return Jabatan::paginate(5);
    }

    public function loadData(){
        return Jabatan::all();
    }

    public function save(Request $request){
        $jabatan = new Jabatan();

        $jabatan->fn_jabatan = $request->fn_jabatan;
        $jabatan->fk_jabatan = $request->fk_jabatan;
        return $jabatan->save() ? response()->json(['result'=>true]) : response()->json(['result'=>false]);
    }

    public function update(Request $request){
        $jabatan = Jabatan::find($request->id);
        $jabatan->fn_jabatan = $request->fn_jabatan_edit;
        return $jabatan->save() ? response()->json(['result'=>true]) : response()->json(['result'=>false]);
    }

      public function delete(Request $request){
        $jabatan = Jabatan::find($request->id);
       return $jabatan->delete() ? response()->json(['result'=>true]) : response()->json(['result'=>false]);
    }

     public function search(Request $request){
        $jabatan = Jabatan::where('fn_jabatan','like','%'.$request->search.'%')->get();
        return ($jabatan);
    }

    public function generateId_Jabatan(){
       $result  = Jabatan::select('fk_jabatan')
                        ->orderBy('fk_jabatan','desc')
                        ->first();

       if ($result==null){
        return '01';
       }else{
        return $result;
       }
    }
}
