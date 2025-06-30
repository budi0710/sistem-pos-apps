<?php

namespace App\Http\Controllers;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
public function load(){
        return Supplier::paginate(5);
    }

    public function loadData(){
        return Supplier::all();
    }

    public function save(Request $request){
        $supplier = new Supplier();

        $supplier->nama_sup = $request->nama_sup;
        $supplier->kode_sup = $request->kode_sup;
        return $supplier->save() ? response()->json(['result'=>true]) : response()->json(['result'=>false]);
    }

    public function update(Request $request){
        $supplier = Supplier::find($request->id);
        $supplier->nama_sup = $request->nama_sup_edit;
        return $jenis->save() ? response()->json(['result'=>true]) : response()->json(['result'=>false]);
    }

      public function delete(Request $request){
        $supplier = Supplier::find($request->id);
       return $supplier->delete() ? response()->json(['result'=>true]) : response()->json(['result'=>false]);
    }

     public function search(Request $request){
        $supplier = Supplier::where('nama_sup','like','%'.$request->search.'%')->get();
        return ($supplier);
    }
}
