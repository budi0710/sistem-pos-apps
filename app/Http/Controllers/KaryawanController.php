<?php

namespace App\Http\Controllers;
use App\Models\Karyawan;
use App\Models\StatusNikah;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function load(){
        return Karyawan::paginate(5);
    }

    public function loadData(){
        return Karyawan::all();
    }

    public function loadDataStatus(){
        return StatusNikah::all();
    }
}
