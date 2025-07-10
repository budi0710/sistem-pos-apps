<?php

namespace App\Http\Controllers;

use App\Models\Absens;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use DateTime;

class AbsenController extends Controller
{
    public function uploadAbsenMasuk(Request $request)
    {
        $file = $request->file('imageAbsenMasuk');
        $path = $file->store('absen', 'public');

        $absen = new Absens();
        $now = new DateTime();
        // $now =  now();

        $absen->id_user = $request->session()->get('user_id');
        $absen->date = date('Y-m-d');
        $absen->time_in = date('H:i:s');
        $absen->time_out = '00:00:00';
        $absen->image = $path;

        // check jika absen masuk dua kali
        // $exist = Absens::whereDate('date', $now)->exists();
        $exist = Absens::where('date', date('Y-m-d'))
            ->where('time_in', '<>', '00:00:00')
            ->where('time_out', '=', '00:00:00')
            ->count();

        if ($exist) {
            return response()->json(['result' => false]);
        } else {
            return $absen->save() ? response()->json(['result' => true]) : response()->json(['result' => false]);
        }
    }

    public function uploadAbsenPulang(Request $request)
    {
        $file = $request->file('imageAbsenPulang');
        $path = $file->store('absen', 'public');

        $absen = new Absens();
        $now = new DateTime();

        $absen->id_user = $request->session()->get('user_id');
        $absen->date = date('Y-m-d');
        $absen->time_in = '00:00:00';
        $absen->time_out = date('H:i:s');
        $absen->image = $path;

        $exist = Absens::where('date', date('Y-m-d'))
            ->where('time_out', '<>', '00:00:00')
            ->where('time_in', '=', '00:00:00')
            ->count();
        if ($exist) {
            return response()->json(['result' => false]);
         } else {
            return $absen->save() ? response()->json(['result' => true]) : response()->json(['result' => false]);
       
        }
    }
}
