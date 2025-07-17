<?php

namespace App\Http\Controllers;
use App\Models\H_btbg; 
use App\Models\L_hbtbg;
use App\Models\l_hbtbg2;
use App\Models\L_dbtbg;
use App\Models\T_btbg;
use Illuminate\Support\Facades\DB;
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
        $h_btbg = new H_btbg();
        $fno_btbg = $request->fno_btbg;

        $h_btbg->fno_btbg =  $fno_btbg;
        $h_btbg->fk_brj = $request->fk_brj;
        $h_btbg->ftgl_btbg = $request->ftgl_btbg;
        $h_btbg->fq_brj = $request->fq_brj;
        $h_btbg->description = $request->description;
        $h_btbg->userid =  $request->session()->get('user_id');
        $h_btbg->save();

        $data = $request->detail_data;

        for ($i=0; $i < count($data) ; $i++) { 
            $master_data = $data[$i];
            $kode_bg = $master_data['kode_bg'];
            $fq_btbg = $master_data['fq_btbg'];

            DB::insert('INSERT INTO t_btbg (fno_btbg, kode_bg, fq_btbg_rcn) VALUES (?, ?, ?)', [$fno_btbg, $kode_bg, $fq_btbg]);
            $fno_spo = '';
        }
       return response()->json(['result'=>true]) ;

    }

    private function generatefno_btbg(array  $existingNumbers): string{
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

    public function load_Akt()
    {
        return l_hbtbg2::paginate(10);
    }

    private function getLast3($angka){
           // $angka = "202506001"; // Pastikan ini dalam bentuk string
            $tiga_angka_terakhir = substr($angka, -3);
            return $tiga_angka_terakhir; // Output: 001
    }

    public function generateNo(){
        $result= H_btbg::select('fno_btbg')->orderBy('fno_btbg','desc')->first();
       if ($result==null){
          return '001';
       }else{
          return ($result);
       }
    }

    public function generateKodeSbtbg(){
         $result= T_btbg::select('fno_spk')->orderBy('fno_spk','desc')->first();
       
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
        $fno_btbg = H_btbg::select('fno_btbg')->where("id",$request->id)->get();
        // ambil data index ke 0 dan key fno_pos
        $fno_btbg = $fno_btbg[0]['fno_btbg'];
       
        // delete data di table header berdasarkan primary key id
        $H_btbg = H_btbg::find($request->id);
        $H_btbg->delete();

        // delete data di table detail berdasarkan fno_pos
       // $t_btbg = T_btbg::where('fno_poc',$fno_poc)->delete();
        
       // return $t_btbg ? response()->json(['result'=>true]) : response()->json(['result'=>false]);
    }

    public function editBTBG(Request $request){
        $fno_btbg = $request->fno_btbg;
        $data = $request->detail_data;

        for ($i = 0; $i < count($data); $i++) {
            $master_data = $data[$i];
            $kode_bg = $master_data['kode_bg'];
            $fq_btbg_akt = $master_data['fq_btbg_akt'];

            T_btbg::where('kode_bg', $kode_bg)
                ->where('fno_btbg', $fno_btbg)
                ->update([
                    'fq_btbg_akt' => $fq_btbg_akt,
                ]);
        }

        return response()->json(['result' => true]);
    }
}
