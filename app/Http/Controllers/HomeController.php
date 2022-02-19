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

        // dd($periode);
        // $periode = '1';

        if (Auth::user()->level == 31) {
            $level_login = 'sales';
        }
        if (Auth::user()->level == 32) {
            $level_login = 't_manager';
        }
        if (Auth::user()->level == 23) {
            $level_login = 'gt_manager';
        }
        if (Auth::user()->level == 25) {
            $level_login = 'kdiv_marketing';
        }

        
         // card Header
            $jml_sp_baru = DB::table('tbl_penjualan_master as a')->leftJoin('tbl_periode as b','a.t_manager','b.nik_tm')->where('tgl_akhir',null)->where('sts_flow','1');
            $jml_sp_verif = DB::table('tbl_penjualan_master as a')->leftJoin('tbl_periode as b','a.t_manager','b.nik_tm')->where('tgl_akhir',null)->where('sts_flow','2');
            $jml_sp_terkirim = DB::table('tbl_penjualan_master as a')->leftJoin('tbl_periode as b','a.t_manager','b.nik_tm')->where('tgl_akhir',null)->where('sts_flow','4');
            $jml_sp_tolak_verif = DB::table('tbl_penjualan_master as a')->leftJoin('tbl_periode as b','a.t_manager','b.nik_tm')->where('tgl_akhir',null)->where('sts_flow','20');
            $jml_sp_tolak_kirim = DB::table('tbl_penjualan_master as a')->leftJoin('tbl_periode as b','a.t_manager','b.nik_tm')->where('tgl_akhir',null)->where('sts_flow','30');
        // card Header
        
        // penjualan kdiv
            $penjualan = $jml_sp_terkirim
            ->leftJoin('tbl_group_marketing as c','a.sales','c.nik_sales')
            ->where($level_login,Auth::user()->nik)
            ->where('tgl_jual','>=','tgl_awal')
            ->get();
        // end penjualan kdiv

        if ($periode) {
            // card Header
                $jml_sp_baru = DB::table('tbl_penjualan_master as a')->leftJoin('tbl_periode as b','a.t_manager','b.nik_tm')->leftJoin('tbl_group_marketing as c','a.sales','c.nik_sales')->where('periode',$periode)->where('sts_flow','1');
                $jml_sp_verif = DB::table('tbl_penjualan_master as a')->leftJoin('tbl_periode as b','a.t_manager','b.nik_tm')->leftJoin('tbl_group_marketing as c','a.sales','c.nik_sales')->where('periode',$periode)->where('sts_flow','2');
                $jml_sp_terkirim = DB::table('tbl_penjualan_master as a')->leftJoin('tbl_periode as b','a.t_manager','b.nik_tm')->leftJoin('tbl_group_marketing as c','a.sales','c.nik_sales')->where('periode',$periode)->where('sts_flow','4');
                $jml_sp_tolak_verif = DB::table('tbl_penjualan_master as a')->leftJoin('tbl_periode as b','a.t_manager','b.nik_tm')->leftJoin('tbl_group_marketing as c','a.sales','c.nik_sales')->where('periode',$periode)->where('sts_flow','20');
                $jml_sp_tolak_kirim = DB::table('tbl_penjualan_master as a')->leftJoin('tbl_periode as b','a.t_manager','b.nik_tm')->leftJoin('tbl_group_marketing as c','a.sales','c.nik_sales')->where('periode',$periode)->where('sts_flow','30');
            // card Header
            
                // penjualan kdiv
                $penjualan = $jml_sp_terkirim
                ->where($level_login,Auth::user()->nik)
                ->get();
                // end penjualan kdiv
        }

        dd($penjualan);
        
        
        
        return view('dashboard', compact(
            'jml_sp_baru',
            'jml_sp_verif',
            'jml_sp_terkirim',
            'jml_sp_tolak_verif',
            'jml_sp_tolak_kirim',

            'penjualan',
            'periode',
            
        ));
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