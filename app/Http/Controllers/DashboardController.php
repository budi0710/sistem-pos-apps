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
use App\Models\H_btbg;
use App\Models\H_krm;
use App\Models\T_krm;
use App\Models\H_poc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function getDashboardData()
    {
        /** START IE CHART */
        $rows = BarangJadi::selectRaw('fn_jns_brj, COUNT(*) AS total')
            ->join('jenisbrj', 'jenisbrj.fk_jns_brj', 'barangjadi.fk_jns_brj')
            ->groupBy('fn_jns_brj')->get();
        $pie_stbj = [];
        foreach ($rows as $row) {
            $pie_stbj[] = [
                'name' =>  $row->fn_jns_brj,
                'y' =>  $row->total,
            ];
        }
        $rows = T_stbj::selectRaw('MAX(ftgl_stbj) AS ftgl_stbj, SUM(fq_stbj) AS total')
            ->join('h_stbj', 'h_stbj.fno_stbj', 't_stbj.fno_stbj')
            ->groupByRaw('YEAR(ftgl_stbj), MONTH(ftgl_stbj)')->get();
        /** END PIE CHART */

        /** LINE CHART */
        $line = [];
        foreach ($rows as $row) {
            $line['categories'][] = date('M-Y', strtotime($row->ftgl_stbj));
            $line['data'][] = $row->total * 1;
        }
        $rows = T_stbj::selectRaw('fn_jns_brj, YEAR(ftgl_stbj) AS ftgl_stbj, SUM(fq_stbj) AS total')
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

        /** Jumlah Data Barang */
        $jumlah_barangs = DB::table('barangs')->count('kode_bg') ?? 0;

        /** Jumlah Data Jadi */
        $jumlah_FG = DB::table('barangjadi')->count('fk_brj') ?? 0;

        /** Jumlah Data Karyawan */
        $jumlah_karyawan = DB::table('karyawan')->count('fnik') ?? 0;

        /** Jumlah Data Supplier */
        $jumlah_supplier = DB::table('supplier')->count('kode_sup') ?? 0;

        /** Jumlah Data Customer */
        $jumlah_customer = DB::table('customer')->count('kode_cus') ?? 0;

        /** Jumlah Data Permintaan */
        $jumlah_permintaan = DB::table('h_btbg')->count('fno_btbg') ?? 0;

        /** Jumlah Data STBJ */
        $jumlah_stbj = DB::table('h_stbj')->count('fno_stbj') ?? 0;

        /** Jumlah Data STBJ */
        $jumlah_krm = DB::table('h_krm')->count('fno_krm') ?? 0;

        /** Jumlah Data PO Customer */
        $jumlah_poc = DB::table('h_poc')->count('fno_poc') ?? 0;

        return compact(
        'pie_stbj', 'line', 'column',
        'jumlah_barangs', 'jumlah_FG', 'jumlah_karyawan',
        'jumlah_supplier', 'jumlah_customer', 'jumlah_permintaan',
        'jumlah_stbj', 'jumlah_krm', 'jumlah_poc'
        );
    }

    public function getDashboardKirimData()
    {
        /** START IE CHART */
        $rows = BarangJadi::selectRaw('fn_jns_brj, COUNT(*) AS total')
            ->join('jenisbrj', 'jenisbrj.fk_jns_brj', 'barangjadi.fk_jns_brj')
            ->groupBy('fn_jns_brj')->get();
        $pie_kirim = [];
        foreach ($rows as $row) {
            $pie_kirim[] = [
                'name' =>  $row->fn_jns_brj,
                'y' =>  $row->total,
            ];
        }
        $rows = T_krm::selectRaw('MAX(ftgl_krm) AS ftgl_krm, SUM(fq_krm) AS total')
            ->join('h_krm', 'h_krm.fno_krm', 't_krm.fno_krm')
            ->groupByRaw('YEAR(ftgl_krm), MONTH(ftgl_krm)')->get();

        /** LINE CHART */
        $line_kirim = [];
        foreach ($rows as $row) {
            $line_kirim['categories'][] = date('M-Y', strtotime($row->ftgl_krm));
            $line_kirim['data'][] = $row->total * 1;
        }
        $rows = T_krm::selectRaw('fn_jns_brj, YEAR(ftgl_krm) AS ftgl_krm, SUM(fq_krm) AS total')
            ->join('h_krm', 'h_krm.fno_krm', 't_krm.fno_krm')
            ->join('t_poc', 't_poc.fnos_poc', 't_krm.fnos_poc')
            ->join('barangjadi', 'barangjadi.fk_brj', 't_poc.fk_brj')
            ->join('jenisbrj', 'jenisbrj.fk_jns_brj', 'barangjadi.fk_jns_brj')
            ->groupByRaw('fn_jns_brj, YEAR(ftgl_krm)')->get();

        /** PIE CHART */
        $column_kirim = [];
        foreach ($rows as $row) {
            $column_kirim['categories'][$row->ftgl_krm] = $row->ftgl_krm;
            $column_kirim['series'][$row->fn_jns_brj]['name'] = $row->fn_jns_brj;
            $column_kirim['series'][$row->fn_jns_brj]['data'][$row->ftgl_krm] = $row->total * 1;
        }
        foreach ($column_kirim['series'] as $key => $val) {
            $column_kirim['series'][$key]['data'] = array_values($val['data']);
        }
        $column_kirim['categories'] = array_values($column_kirim['categories']);
        $column_kirim['series'] = array_values($column_kirim['series']);
        //dd($column);
        return compact('pie_kirim', 'line_kirim', 'column_kirim');
    }

    public function dashboardGabungan()
    {
        $dashboard = $this->getDashboardData();
        $dashboardKirim = $this->getDashboardKirimData();

        return view('dashboard', array_merge($dashboard, $dashboardKirim));
    }
}
