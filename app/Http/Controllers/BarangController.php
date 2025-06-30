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
       
        $kode_bg = $data->{'kode_bg'};
        $partname = $data->{'partname'};
        $partno = $data->{'partno'};
        $result_jenis = $data->{'result_jenis'};
        $result_satuan = $data->{'result_satuan'};
        $fberat_netto = $data->{'fberat_netto'};
        $description = $data->{'description'};
        $saldo_awal = $data->{'saldo_awal'};

        $barang = new Barang();

        $barang->kode_bg = $kode_bg;
        $barang->partname = $partname;
        $barang->partno = $partno;
        $barang->fk_sat = $result_satuan;
        $barang->fk_jenis = $result_jenis;
        $barang->fberat_netto = $fberat_netto;
        $barang->description = $description;
        $barang->saldo_awal = $saldo_awal;
        $barang->fgambar_brg = $path;
        
        return $barang->save() ? response()->json(['result'=>true]) : response()->json(['result'=>false]);
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

        $kode_bg = $data->{'kode_bg_edit'};
        $partname = $data->{'partname_edit'};
        $partno = $data->{'partno_edit'};
        $result_jenis = $data->{'result_jenis_edit'};
        $result_satuan = $data->{'result_satuan_edit'};
        $fberat_netto = $data->{'fberat_netto_edit'};
        $description = $data->{'description_edit'};
        $saldo_awal = $data->{'saldo_awal_edit'};
       
        $id_edit = $data->{'id_edit'};
        $barang = Barang::find($id_edit);

        $barang->kode_bg = $kode_bg;
        $barang->partname = $partname;
        $barang->partno = $partno;
        $barang->fk_sat = $result_satuan;
        $barang->fk_jenis = $result_jenis;
        $barang->fberat_netto = $fberat_netto;
        $barang->description = $description;
        $barang->saldo_awal = $saldo_awal;
        $barang->fgambar_brg = $path;

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
