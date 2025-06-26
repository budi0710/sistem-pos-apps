<?php

namespace App\Http\Controllers;
use App\Models\barang;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BarangController extends Controller
{
    public function index() : view {
        $barangs = barang::latest()->paginate(10);
        return view('barang.index', compact('barangs'));
    }
}
