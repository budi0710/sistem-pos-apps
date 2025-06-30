<?php

namespace App\Http\Controllers;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function load(){
        return Customer::paginate(5);
    }

    public function loadData(){
        return Customer::all();
    }

    public function save(Request $request){
        $customer = new Customer();

        $customer->nama_cus = $request->nama_cus;
        $customer->kode_cus = $request->kode_cus;
        return $customer->save() ? response()->json(['result'=>true]) : response()->json(['result'=>false]);
    }

    public function update(Request $request){
        $customer = Customer::find($request->id);
        $customer->nama_cus = $request->nama_cus_edit;
        return $jenis->save() ? response()->json(['result'=>true]) : response()->json(['result'=>false]);
    }

      public function delete(Request $request){
        $customer = Customer::find($request->id);
       return $customer->delete() ? response()->json(['result'=>true]) : response()->json(['result'=>false]);
    }

     public function search(Request $request){
        $customer = Customer::where('nama_cus','like','%'.$request->search.'%')->get();
        return ($customer);
    }
}
