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
       
        $supplier->kode_sup = $request->kode_sup;
        $supplier->nama_sup = $request->nama_sup;
        $supplier->notelp_sup = $request->notelp_sup;
        $supplier->alamat_sup = $request->alamat_sup;
        $supplier->email_sup = $request->email_sup;
        $supplier->PPN_sup = $request->PPN_sup;
        $supplier->NPWP_sup = $request->NPWP_sup;
        $supplier->CP_sup = $request->CP_sup;
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
