<?php

namespace App\Http\Controllers;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BarangController extends Controller
{
public function load(){
        return Barang::paginate(5);
    }

    public function loadData(){
        return Barang::all();
    }

    public function save(Request $request){
        $file = $request->file('file_barang');
        $path = $file->store('barang', 'public');
       
        $data = $request->_data;
        $data = json_decode($data);
       
        $fk_brj = $data->{'fk_brj'};
        $fn_brj = $data->{'fn_brj'};
        $result_jenis = $data->{'result_jenis'};
        $fpartno = $data->{'fpartno'};
        $fbrt_bruto = $data->{'fbrt_bruto'};
        $fbrt_neto = $data->{'fbrt_neto'};
        $fdimensi = $data->{'fdimensi'};

        $barang = new Barang();

        $barang->fn_brj = $fn_brj;
        $barang->fk_brj = $fk_brj;
        $barang->fk_jns_brj = $result_jenis;
        $barang->fpartno = $fpartno;
        $barang->fbrt_bruto = $fbrt_bruto;
        $barang->fbrt_neto = $fbrt_neto;
        $barang->fdimensi = $fdimensi;
        $barang->fgambar = $path;
        
        return $Barang->save() ? response()->json(['result'=>true]) : response()->json(['result'=>false]);
    }

    public function update(Request $request){

        $data = $request->_data;
        $data = json_decode($data);
       
        $id_edit = $data->{'id_edit'};
        $barang = Barang::find($id_edit);

        $file = $request->file('file_barang_edit');
        $path = $file->store('barang', 'public');


        $data = $request->_data;
        $data = json_decode($data);

        $fk_brj = $data->{'fk_brj_edit'};
        $fn_brj = $data->{'fn_brj_edit'};
        $result_jenis = $data->{'result_jenis_edit'};
        $fpartno = $data->{'fpartno_edit'};
        $fbrt_bruto = $data->{'fbrt_bruto_edit'};
        $fbrt_neto = $data->{'fbrt_neto_edit'};
        $fdimensi = $data->{'fdimensi_edit'};
       
        $id_edit = $data->{'id_edit'};
        $barang = Barang::find($id_edit);

        $barang->fn_brj = $fn_brj;
        $barang->fk_jns_brj = $result_jenis;
        $barang->fpartno = $fpartno;
        $barang->fbrt_neto = $fbrt_neto;
        $barang->fbrt_bruto = $fbrt_bruto;
        $barang->fdimensi = $fdimensi;
        $barang->fgambar = $path;

        return $barang->save() ? response()->json(['result'=>true]) : response()->json(['result'=>false]);
    }

      public function delete(Request $request){
        $barang = Barang::find($request->id);
       return $barang->delete() ? response()->json(['result'=>true]) : response()->json(['result'=>false]);
    }

     public function search(Request $request){
        $barang = Barang::where('partname','like','%'.$request->search.'%')->get();
        return ($barang);
    }

}
