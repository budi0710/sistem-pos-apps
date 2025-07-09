<?php

namespace App\Http\Controllers;
use App\Models\H_poc;
use App\Models\L_H_POC;
use App\Models\T_poc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class H_poc_Controller extends Controller
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
        $h_poc = new H_poc();

        $fno_poc = $request->fno_poc;

        $h_poc->fno_poc = $request->fno_poc;
        $h_poc->fno_poc_cus = $request->fno_poc_cus;
        $h_poc->kode_cus = $request->kode_cus;
        $h_poc->PPN_cus = $request->ppn;
        $h_poc->description = $request->description;
        $h_poc->ftgl_poc = $request->ftgl_poc;
        $h_poc->userid =  $request->session()->get('user_id');
        $h_poc->save();

        $data = $request->detail_data;
        
        for ($i=0; $i < count($data) ; $i++) { 
            $master_data = $data[$i];

            $fnos_poc = $this->generateKodeSpk();
            $fk_brj = $master_data['fk_brj'];
            $fq_poc  = $master_data['fq_poc'];
            $fharga  = $master_data['fharga_jual'];
          
            DB::insert('INSERT INTO t_poc (fno_poc, fk_brj, fnos_poc, fq_poc, fharga) VALUES (?, ?, ?, ? , ?)', [$fno_poc, $fk_brj, $fnos_poc,  $fq_poc, $fharga]);
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
        return L_H_POC::paginate(10);
    }

    private function getLast3($angka){
           // $angka = "202506001"; // Pastikan ini dalam bentuk string
            $tiga_angka_terakhir = substr($angka, -3);
            return $tiga_angka_terakhir; // Output: 001
    }

    public function generateNo(){
        $result= H_poc::select('fno_poc')->orderBy('fno_poc','desc')->first();
       if ($result==null){
          return '001';
       }else{
          return ($result);
       }
    }

    public function generateKodeSpk(){
         $result= T_poc::select('fnos_poc')->orderBy('fnos_poc','desc')->first();
       
       if ($result==null){
          return date('Ym').'0001';
       }else{
          $angka =substr($result->fno_spo, -4);
          return date('Ym').$this->generateFormattedNumber($angka);
       }
    }

    public function  generateFormattedNumber($number) {
        return sprintf('%04d', $number+1);
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
        $h_poc = H_poc::select('fno_poc')->where("id",$request->id)->get();
        // ambil data index ke 0 dan key fno_pos
        $h_poc = $h_poc[0]['fno_poc'];
       
        // delete data di table header berdasarkan primary key id
        $h_poc = H_poc::find($request->id);
        $h_poc->delete();

        // delete data di table detail berdasarkan fno_pos
        $t_poc = T_poc::where('fno_poc',$fno_poc)->delete();
        return $detail ? response()->json(['result'=>true]) : response()->json(['result'=>false]);
    }
}
