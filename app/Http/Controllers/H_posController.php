<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\H_pos;
use App\Models\L_hpos;
use App\Models\T_pos;
use App\Models\L_PSupplier;
use Illuminate\Support\Facades\DB;

class H_posController extends Controller
{
/**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function loadWhere(Request $request){
        return L_PSupplier::where('fno_pos',$request->fno_pos)->get();
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
        $h_pos = new H_pos();
        $fno_pos = $request->fno_pos;

        $h_pos->fno_pos =  $fno_pos;
        $h_pos->kode_sup = $request->kode_sup;
        $h_pos->ppn = $request->ppn;
        $h_pos->description = $request->description;
        $h_pos->ftgl_pos = $request->ftgl_pos;
        $h_pos->userid =  $request->session()->get('user_id');
        $h_pos->save();

        $data = $request->detail_data;

        for ($i=0; $i < count($data) ; $i++) { 
            $master_data = $data[$i];

            $fno_spo = $this->generateKodeSpk();
            $kode_bg = $master_data['kode_bg'];
            $fq_pos  = $master_data['fq_pos'];
            $harga  = $master_data['harga'];

            DB::insert('INSERT INTO t_pos (fno_pos, fno_spo, kode_bg, fq_pos,fharga) VALUES (?, ?, ?, ? , ?)', [$fno_pos, $fno_spo, $kode_bg, $fq_pos, $harga]);
            $fno_spo = '';
        }
       return response()->json(['result'=>true]) ;


        // $data = json_decode($data);

        // foreach ($data as $item) {
        //     // otomatis dari tabel
        //     $fno_spo = $this->generateNo();
        //     $kode_bg = $item->kode_bg;
        //     $fq_pos  = $item->fq_pos;
        //     $fharga  = $request->fharga;


        //     echo $kode_bg;
        //     // DB::insert('INSERT INTO t_pos (fno_pos, fno_spo, kode_bg, fq_pos, fharga) VALUES (?, ?, ?, ? , ?)', [$fno_pos, $fno_spo, $kode_bg, $fq_pos, $fharga]);
        // }
       
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
        return L_hpos::paginate(10);
    }

    private function getLast3($angka){
           // $angka = "202506001"; // Pastikan ini dalam bentuk string
            $tiga_angka_terakhir = substr($angka, -3);
            return $tiga_angka_terakhir; // Output: 001
    }

    public function generateNo(){
        $result= H_pos::select('fno_pos')->orderBy('fno_pos','desc')->first();
       if ($result==null){
          return '001';
       }else{
          return ($result);
       }
    }

    public function  generateFormattedNumber($number) {
        return sprintf('%04d', $number+1);
    }

    public function generateKodeSpk(){
         $result= T_pos::select('fno_spo')->orderBy('fno_spo','desc')->first();
       
       if ($result==null){
          return date('Ym').'0001';
       }else{
          $angka =substr($result->fno_spo, -4);
          return date('Ym').$this->generateFormattedNumber($angka);
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
        $h_poc = H_poc::select('fno_pos')->where("id",$request->id)->get();
        // ambil data index ke 0 dan key fno_pos
        $h_poc = $h_poc[0]['fno_pos'];
       
        // delete data di table header berdasarkan primary key id
        $h_poc = H_poc::find($request->id);
        $h_poc->delete();

        // delete data di table detail berdasarkan fno_pos
        $t_poc = T_poc::where('fno_pos',$fno_poc)->delete();
        
        return $detail ? response()->json(['result'=>true]) : response()->json(['result'=>false]);
    }
}
