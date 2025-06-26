<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class barang extends Model
{
    protected $filable = [
            'image',
            'nama_brg',
            'decrition',
            'fk_sat',
            'fk_jenis',
            'harga',
            'stok',
    ];
}
