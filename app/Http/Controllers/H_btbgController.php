<?php

namespace App\Http\Controllers;
use App\Models\H_btbg; 
use App\Models\L_hbtbg;
use App\Models\L_dbtbg;
use App\Models\T_btbg;
use Illuminate\Http\Request;

class H_btbgController extends Controller
{
/**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function saveData(Request $request)
    {
        $Hpo_Customer = new Hpo_Customer();

        $Hpo_Customer->fno_poc = $request->fno_poc;
        $Hpo_Customer->fk_cus = $request->result_customer;
        $Hpo_Customer->fppn = $request->PPN_customer;
        $Hpo_Customer->fpph23 = $request->pph23_customer;
        $Hpo_Customer->fket = $request->ket;
        $Hpo_Customer->ftgl_poc = $request->ftgl_poc;
        $Hpo_Customer->fk_user =  $request->session()->get('admin');
        $Hpo_Customer->save();

        $data = $request->data;
        $data = json_decode($data);
        
       foreach ($data as $item) {
            $fno_rbc = $item->kode_rbc;
            $harga = $item->harga_poc;
            $fqt_poc = $item->fqt_poc;
            $fno_spk = $item->fno_spk;
            $fno_poc =$request->fno_poc;
          
            DB::insert('INSERT INTO dpo_customer (fno_rbc, fno_poc,fharga,fqt_poc,fno_spk) VALUES (?, ?, ?, ? , ?)', [$fno_rbc, $fno_poc, $harga, $fqt_poc, $fno_spk]);
        }

        return response()->json(['result'=>true]) ;
    }

    private function generateFNoPoc(array  $existingNumbers): string{
        // Ambil tahun dan bulan saat ini, misalnya 202506
        $prefix = date('Ym');

        // Filter hanya nomor yang sesuai dengan prefix tahun-bulan sekarang
        $filtered = array_filter($existingNumbers, function ($number) use ($prefix) {
            return strpos((string)$number, $prefix) === 0;
        });

        // Ambil 3 digit urutan terakhir dari nomor yang sesuai
        $lastSequence = 0;
        foreach ($filtered as $number) {
            $sequence = (int)substr((string)$number, -3);
            if ($sequence > $lastSequence) {
                $lastSequence = $sequence;
            }
        }

        // Tambahkan 1 ke urutan terakhir
        $nextSequence = $lastSequence + 1;

        // Gabungkan prefix dan nomor urut dengan format 3 digit
        return $prefix . str_pad($nextSequence, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Display the specified resource.z
     */
    public function load()
    {
        return L_hbtbg::paginate(10);
    }

    private function getLast3($angka){
           // $angka = "202506001"; // Pastikan ini dalam bentuk string
            $tiga_angka_terakhir = substr($angka, -3);
            return $tiga_angka_terakhir; // Output: 001
    }

    public function generateNo(){
        $result= Hpo_Customer::select('fno_poc')->orderBy('fno_poc','desc')->first();
       if ($result==null){
          return '001';
       }else{
          return ($result);
       }
    }

    public function generateKodeSpk(){
         $result= dpo_Customer::select('fno_spk')->orderBy('fno_spk','desc')->first();
       
       if ($result==null){
          return '001';
       }else{
          
          return ($result);
       }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(request $request)
    {
        // check receive apakah sudah pernah dilakukan transaksi 

        // ambil fno_pos terlebih dahulu
        $fno_poc = hpo_customer::select('fno_poc')->where("id",$request->id)->get();
        // ambil data index ke 0 dan key fno_pos
        $fno_poc = $fno_poc[0]['fno_poc'];
       
        // delete data di table header berdasarkan primary key id
        $hpo_customer = hpo_customer::find($request->id);
        $hpo_customer->delete();

        // delete data di table detail berdasarkan fno_pos
        $dpo_customer = dpo_customer::where('fno_poc',$fno_poc)->delete();
        
        return $detail ? response()->json(['result'=>true]) : response()->json(['result'=>false]);
    }
}
