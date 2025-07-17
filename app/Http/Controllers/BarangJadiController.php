<?php

namespace App\Http\Controllers;
use App\Models\BarangJadi;
use App\Models\KartuStok_fg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

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

        $data = $request->_data;
        $data = json_decode($data);
       
        $id_edit = $data->{'id_edit'};
        $barangjadi = BarangJadi::find($id_edit);

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
        $barangjadi = BarangJadi::find($id_edit);

        $barangjadi->fn_brj = $fn_brj;
        $barangjadi->fk_jns_brj = $result_jenis;
        $barangjadi->fpartno = $fpartno;
        $barangjadi->fbrt_neto = $fbrt_neto;
        $barangjadi->fbrt_bruto = $fbrt_bruto;
        $barangjadi->fdimensi = $fdimensi;
        $barangjadi->fgambar = $path;

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

    public function loadDataks(){
        return KartuStok_fg::all();
    }

    public function prosesDataFg(Request $request){
        $year = $request->year;
        $month = $request->month;
        $barang = $request->barang;

        if ($year!=null && $month==null && $barang==null) { 

             $data = KartuStok_fg::where(DB::raw('YEAR(ftgl_transaksi)'), '=', $year)->get();

        }else if ($year==null && $month!=null && $barang==null){
             $data = KartuStok_fg::where(DB::raw('MONTH(ftgl_transaksi)'), '=', $month)->get();
             
        }else if($barang!=null && $year==null && $month == null){
            $data = KartuStok_fg::where('fk_brj',$barang)->get();
        }else{
             $data = KartuStok_fg::where(DB::raw('YEAR(ftgl_transaksi)'), '=', $year)
                                ->where(DB::raw('MONTH(ftgl_transaksi)'), '=', $month)
                                ->where('fk_brj',$barang)->get();
        }

       
        return $data;
    }

}
