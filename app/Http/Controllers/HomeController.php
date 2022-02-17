<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $periode = $request -> input('periode'); 

        if (Auth::user()->level == 32) {
            $level = 't_manager';
            $level_group = 'nik_tm';
        }
        if (Auth::user()->level == 23) {
            $level = 'gt_manager';
            $level_group = 'nik_gtm';
        }
        if (Auth::user()->level == 25) {
            $level = 'kdiv_marketing';
            $level_group = 'nik_kdiv';
        }

        $periode = DB::table('tbl_periode')->orderBy('tahun_periode','desc')->orderBy('periode','desc')->get();
        $periode_berjalan = DB::table('tbl_periode')->where('tgl_akhir',null)->get();
        $karyawan = DB::table('tbl_karyawan')->get();
        
        $penjualan = DB::table('tbl_penjualan_master')->where($level,Auth::user()->nik)->get();
        $nik_gtm = DB::table('tbl_penjualan_master')->where($level,Auth::user()->nik)->distinct()->get('gt_manager');
        $nik_tm = DB::table('tbl_penjualan_master')->where($level,Auth::user()->nik)->distinct()->get('t_manager');
        $nik_sales = DB::table('tbl_penjualan_master')->where($level,Auth::user()->nik)->distinct()->get('sales');
        $group = DB::table('tbl_group_marketing')->where($level_group,Auth::user()->nik)->get();
        // dd($periode_berjalan);
        return view('dashboard',compact('penjualan','karyawan','periode_berjalan','nik_gtm','nik_tm','nik_sales','group'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Respons
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}