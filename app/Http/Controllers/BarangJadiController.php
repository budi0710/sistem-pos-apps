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

        $file = $request->file('file_barang');
        $path = $file->store('barang', 'public');
        exit($path);
        $data = $request->_data;
        $data = json_decode($data);
       
        $fk_brj = $data->{'fk_brj'};
        $fn_brj = $data->{'fn_brj'};
        $result_jenis = $data->{'result_jenis'};
        $fpartno = $data->{'fpartno'};
        $fbrt_bruto = $data->{'fbrt_bruto'};
        $fbrt_neto = $data->{'fbrt_neto'};
        $fdimensi = $data->{'fdimensi'};

        $barangjadi = new BarangJadi();

        $barangjadi->fn_brj = $fn_brj;
        $barangjadi->fk_brj = $fk_brj;
        $barangjadi->fk_jns_brj = $result_jenis;
        $barangjadi->fpartno = $fpartno;
        $barangjadi->fbrt_bruto = $fbrt_bruto;
        $barangjadi->fbrt_neto = $fbrt_neto;
        $barangjadi->fdimensi = $fdimensi;
        $barangjadi->fgambar = $path;
        
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
