<?php

namespace App\Http\Controllers;
use App\Models\H_stbj;
use App\Models\T_stbj;
use App\Models\BarangJadi;
use App\Models\JenisBRJ;
use App\Models\Barang;
use App\Models\Customer;
use App\Models\Karyawan;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
    {
        /** PIE CHART */
        $rows = BarangJadi::selectRaw('fn_jns_brj, COUNT(*) AS total')
            ->join('jenisbrj', 'jenisbrj.fk_jns_brj', 'barangjadi.fk_jns_brj')
            ->groupBy('fn_jns_brj')->get();
        $pie = [];
        foreach ($rows as $row) {
            $pie[] = [
                'name' =>  $row->fn_jns_brj,
                'y' =>  $row->total,
            ];
        }
        $rows = T_stbj::selectRaw('MAX(ftgl_stbj) AS ftgl_stbj, SUM(fq_stbj) AS total')
            ->join('h_stbj', 'h_stbj.fno_stbj', 't_stbj.fno_stbj')
            ->groupByRaw('YEAR(ftgl_stbj), MONTH(ftgl_stbj)')->get();

        /** LINE CHART */
        $line = [];
        foreach ($rows as $row) {
            $line['categories'][] = date('M-Y', strtotime($row->ftgl_stbj));
            $line['data'][] = $row->total * 1;
        }
        $rows = T_stbj::selectRaw('fn_jns_brj, YEAR(ftgl_stbj) AS order_date, SUM(fq_stbj) AS total')
            ->join('h_stbj', 'h_stbj.fno_stbj', 't_stbj.fno_stbj')
            ->join('barangjadi', 'barangjadi.fk_brj', 't_stbj.fk_brj')
            ->join('jenisbrj', 'jenisbrj.fk_jns_brj', 'barangjadi.fk_jns_brj')
            ->groupByRaw('fn_jns_brj, YEAR(ftgl_stbj)')->get();

        /** PIE CHART */
        $column = [];
        foreach ($rows as $row) {
            $column['categories'][$row->ftgl_stbj] = $row->ftgl_stbj;
            $column['series'][$row->fn_jns_brj]['name'] = $row->fn_jns_brj;
            $column['series'][$row->fn_jns_brj]['data'][$row->ftgl_stbj] = $row->total * 1;
        }
        foreach ($column['series'] as $key => $val) {
            $column['series'][$key]['data'] = array_values($val['data']);
        }
        $column['categories'] = array_values($column['categories']);
        $column['series'] = array_values($column['series']);
        //dd($column);
        return view('dashboard', compact('pie', 'line', 'column'));
    }
}
