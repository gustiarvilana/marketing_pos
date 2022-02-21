<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $periode = DB::table('tbl_periode')->where('nik_tm',Auth::user()->nik)->where('tahun_periode','>=',2022)->get();
        $periode_jalan = $periode->where('tgl_akhir','>=',0)->where('tgl_akhir','=',null)->first();
        $log_upload_cn = DB::table('tbl_cn_log')->limit(13)->orderBy('periode', 'desc')->get();

        return view('setting.index',compact('periode_jalan','periode','log_upload_cn'));
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
        $data = $request->except('_token');
        $kdiv= DB::table('tbl_group_marketing')->where('nik_tm',$data['nik_tm'])->first();

        DB::table('tbl_periode')->insert([
            'nik_kdiv' => $kdiv->nik_kdiv,
            'nik_gtm' => $kdiv->nik_gtm,
            'nik_tm' => $kdiv->nik_tm,
            'tahun_periode' => $data['tahun_periode'],
            'periode' => $data['periode'],
            'tgl_awal' => $data['tgl_awal'],
        ]);

        return redirect()->back()->with('alert', 'Penjualan Telah Dimulai!');
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

        //proses update gaji
            $data_sales = DB::table('tbl_group_marketing as a')
                ->leftJoin('tbl_karyawan as b','a.nik_sales','b.nik')
                ->where('b.status',1)
                ->distinct()->pluck('b.nik');
            $data_tm = DB::table('tbl_group_marketing as a')
                ->leftJoin('tbl_karyawan as b','a.nik_tm','b.nik')
                ->where('b.status',1)
                ->distinct()->pluck('b.nik');
            $data_gtm = DB::table('tbl_group_marketing as a')
                ->leftJoin('tbl_karyawan as b','a.nik_gtm','b.nik')
                ->where('b.status',1)
                ->distinct()->pluck('b.nik');
            $data_kdiv = DB::table('tbl_group_marketing as a')
                ->leftJoin('tbl_karyawan as b','a.nik_kdiv','b.nik')
                ->where('b.status',1)
                ->distinct()->pluck('b.nik');

            DB::table('tbl_gaji')->where('tgl_close_tm',null)->delete();
            
            //gaji sales
                $penjualan_sales = DB::table('tbl_penjualan_master as a')
                ->whereIn('sales',$data_sales)
                ->where('sts_flow',4)
                ->leftJoin('tbl_group_marketing as b','a.sales','b.nik_sales')
                ->leftJoin('tbl_karyawan as c','a.sales','c.nik')
                ->leftJoin('tbl_jabatan as d','c.jabatan','d.kode_jabatan')
                ->leftJoin('tbl_periode as e','a.t_manager','e.nik_tm')
                ->where('tgl_akhir',null)
                ->get();
                    foreach ($penjualan_sales->unique('sales') as $sales) {   
                        // dd($sales);  
                        $nominal_penjualan_sales=$penjualan_sales->where('sales',$sales->sales)->sum('total_harga');
                        $cn_sales =DB::table('tbl_cn')->where('sales',$sales->sales)->sum('nominal');
                        $penjualan_bersih_sales = $nominal_penjualan_sales - $cn_sales;
                        // insentif
                            if ($penjualan_bersih_sales >= 17774999) {
                                $persen_sales = 8;
                                $insentif_sales = $penjualan_bersih_sales * $persen_sales / 100;
                                $bonus_sales = 0;
                            }elseif ($penjualan_bersih_sales >= 22665000) {
                                $persen_sales = 10;
                                $insentif_sales = $penjualan_bersih_sales * $persen_sales / 100;
                                $bonus_sales = 0;
                            }elseif ($penjualan_bersih_sales >= 28650000) {
                                $persen_sales = 12;
                                $insentif_sales = $penjualan_bersih_sales * $persen_sales / 100;
                                $bonus_sales = 0;
                            }elseif ($penjualan_bersih_sales >= 33650000) {
                                $persen_sales = 14;
                                $insentif_sales = $penjualan_bersih_sales * $persen_sales / 100;
                                $bonus_sales = 0;
                            }elseif ($penjualan_bersih_sales >= 38999999) {
                                $persen_sales = 16;
                                $insentif_sales = $penjualan_bersih_sales * $persen_sales / 100;
                                $bonus_sales = 0;
                            }elseif ($penjualan_bersih_sales >= 39000000) {
                                $persen_sales = 19;
                                $insentif_sales = $penjualan_bersih_sales * $persen_sales / 100;
                                $bonus_sales = 500000;
                            }else{
                                $persen_sales = 0;
                                $insentif_sales = 0;
                                $bonus_sales = 0;
                            }
                        // end insentif
                        $gaji_sales = $insentif_sales + $bonus_sales;
                        $kasbon_sales = DB::table('tbl_kasbon')->where('nik',$sales->nik)->sum('nom_kasbon');
                        $total_gaji_sales = $gaji_sales - $kasbon_sales;

                        DB::table('tbl_gaji')->updateOrInsert([
                        // $save = ([
                            'nik' => $sales->nik,
                            'nama' => $sales->nama,
                            'jabatan' =>  $sales->nama_jabatan,
                            'level_jabatan' =>  $sales->level_jabatan,
                            'periode' => $sales->periode,
                            'tahun' => $sales->tahun_periode,
                            'penjualan' =>  $nominal_penjualan_sales,
                            'cn' => $cn_sales,
                            'penjualan_bersih' => $penjualan_bersih_sales,
                            'incentive_persen' => $persen_sales,
                            'incentive' => $insentif_sales,
                            'bonus' => $bonus_sales,
                            'tunjangan_ops' => '',
                            'gaji' => $gaji_sales,
                            'kasbon' => $kasbon_sales,
                            'total_gaji' => $total_gaji_sales,
                            'nik_kdiv' => $sales->kdiv_marketing,
                            'nik_gtm' => $sales->gt_manager,
                            'nik_tm' => $sales->t_manager,
                            'tgl_open_tm' => $sales->tgl_awal,
                            'tgl_close_tm' => $sales->tgl_akhir,
                        ]);
                        // dd($save);
                    }
            //end gaji sales
            
            //gaji TM
                $penjualan_tm = DB::table('tbl_penjualan_master as a')
                ->whereIn('t_manager',$data_tm)
                ->where('sts_flow',4)
                ->leftJoin('tbl_group_marketing as b','a.sales','b.nik_sales')
                ->leftJoin('tbl_karyawan as c','a.t_manager','c.nik')
                ->leftJoin('tbl_jabatan as d','c.jabatan','d.kode_jabatan')
                ->leftJoin('tbl_periode as e','a.t_manager','e.nik_tm')
                ->where('tgl_akhir',null)
                ->get(); 
                    foreach ($penjualan_tm->unique('t_manager') as $tm) {  
                        $nominal_penjualan_tm=$penjualan_tm->where('t_manager',$tm->t_manager)->sum('total_harga');
                        $cn_tm =DB::table('tbl_cn')->where('koordinator',$tm->t_manager)->sum('nominal');
                        $penjualan_bersih_tm = $nominal_penjualan_tm - $cn_tm;
                        // insentif
                            if ($penjualan_bersih_tm < 150000000) {
                                $persen_tm = 0;
                                $insentif_tm = 0;
                                $tunjangan_ops_tm = 0;
                            }elseif ($penjualan_bersih_tm <= 200000000) {
                                $persen_tm = 3;
                                $insentif_tm = $penjualan_bersih_tm * $persen_tm / 100;
                                $tunjangan_ops_tm = 2500000;
                            }elseif ($penjualan_bersih_tm <= 255000000) {
                                $persen_tm = 3.5;
                                $insentif_tm = $penjualan_bersih_tm * $persen_tm / 100;
                                $tunjangan_ops_tm = 2500000;
                            }elseif ($penjualan_bersih_tm <= 325000000) {
                                $persen_tm = 4.5;
                                $insentif_tm = $penjualan_bersih_tm * $persen_tm / 100;
                                $tunjangan_ops_tm = 2500000;
                            }elseif ($penjualan_bersih_tm <= 405000000) {
                                $persen_tm = 5;
                                $insentif_tm = $penjualan_bersih_tm * $persen_tm / 100;
                                $tunjangan_ops_tm = 2500000;
                            }else{
                                $persen_tm = 7;
                                $insentif_tm = $penjualan_bersih_tm * $persen_tm / 100;
                                $tunjangan_ops_tm = 2500000;
                            }
                        // end insentif
                        $gaji_tm = $insentif_tm + $tunjangan_ops_tm;
                        $kasbon_tm = DB::table('tbl_kasbon')->where('nik',$tm->nik)->sum('nom_kasbon');
                        $total_gaji_tm = $gaji_tm - $kasbon_tm;

                        DB::table('tbl_gaji')->updateOrInsert([
                        // $save = ([
                            'nik' => $tm->nik,
                            'nama' => $tm->nama,
                            'jabatan' =>  $tm->nama_jabatan,
                            'level_jabatan' =>  $tm->level_jabatan,
                            'periode' => $tm->periode,
                            'tahun' => $tm->tahun_periode,
                            'penjualan' =>  $nominal_penjualan_tm,
                            'cn' => $cn_tm,
                            'penjualan_bersih' => $penjualan_bersih_tm,
                            'incentive_persen' => $persen_tm,
                            'incentive' => $insentif_tm,
                            'bonus' => '',
                            'tunjangan_ops' => $tunjangan_ops_tm,
                            'gaji' => $gaji_tm,
                            'kasbon' => $kasbon_tm,
                            'total_gaji' => $total_gaji_tm,
                            'nik_kdiv' => $tm->kdiv_marketing,
                            'nik_gtm' => $tm->gt_manager,
                            'nik_tm' => $tm->t_manager,
                            'tgl_open_tm' => $tm->tgl_awal,
                            'tgl_close_tm' => $tm->tgl_akhir,
                        ]);
                        // dd($save);
                    }
            //end gaji TM
            
            //gaji GTM
                $penjualan_gtm = DB::table('tbl_penjualan_master as a')
                ->whereIn('gt_manager',$data_gtm)
                ->where('sts_flow',4)
                ->leftJoin('tbl_group_marketing as b','a.sales','b.nik_sales')
                ->leftJoin('tbl_karyawan as c','a.gt_manager','c.nik')
                ->leftJoin('tbl_jabatan as d','c.jabatan','d.kode_jabatan')
                ->leftJoin('tbl_periode as e','a.t_manager','e.nik_tm')
                ->where('tgl_akhir',null)
                ->get(); 
                    foreach ($penjualan_gtm->unique('gt_manager') as $gtm) {  
                        // dd($penjualan_gtm);
                        $nominal_penjualan_gtm=$penjualan_gtm->where('gt_manager',$gtm->gt_manager)->sum('total_harga');
                        $cn_gtm =DB::table('tbl_cn')->where('koordinator',$gtm->sales)->sum('nominal');
                        $penjualan_bersih_gtm = $nominal_penjualan_gtm - $cn_gtm;
                        // insentif gtm
                            if ($penjualan_bersih_gtm <150000000) {
                                $persen_gtm = 0;
                                $incentive_gtm = 0;
                                $tunjangan_ops_gtm = 0;
                            }elseif ($penjualan_bersih_gtm <250000000) {
                                $persen_gtm = 2;
                                $incentive_gtm = $penjualan_bersih_gtm * $persen_gtm / 100;
                                $tunjangan_ops_gtm = 4500000;
                            }elseif ($penjualan_bersih_gtm <400000000) {
                                $persen_gtm = 2.5;
                                $incentive_gtm = $penjualan_bersih_gtm * $persen_gtm / 100;
                                $tunjangan_ops_gtm = 4500000;
                            }else{
                                $persen_gtm = 2.7;
                                $incentive_gtm = $penjualan_bersih_gtm * $persen_gtm / 100;
                                $tunjangan_ops_gtm = 4500000;
                            }
                         // end insentif
                        $gaji_gtm = $incentive_gtm + $tunjangan_ops_gtm;
                        $kasbon_gtm = DB::table('tbl_kasbon')->where('nik',$gtm->nik)->sum('nom_kasbon');
                        $total_gaji_gtm = $gaji_tm - $kasbon_tm;

                        DB::table('tbl_gaji')->updateOrInsert([
                        // $save = ([
                            'nik' => $gtm->nik,
                            'nama' => $gtm->nama,
                            'jabatan' =>  $gtm->nama_jabatan,
                            'level_jabatan' =>  $gtm->level_jabatan,
                            'periode' => $gtm->periode,
                            'tahun' => $gtm->tahun_periode,
                            'penjualan' =>  $nominal_penjualan_gtm,
                            'cn' => $cn_gtm,
                            'penjualan_bersih' => $penjualan_bersih_gtm,
                            'incentive_persen' => $persen_gtm,
                            'incentive' => $incentive_gtm,
                            'bonus' => '',
                            'tunjangan_ops' => $tunjangan_ops_gtm,
                            'gaji' => $gaji_gtm,
                            'kasbon' => $kasbon_gtm,
                            'total_gaji' => $total_gaji_gtm,
                            'nik_kdiv' => $gtm->kdiv_marketing,
                            'nik_gtm' => $gtm->gt_manager,
                            'nik_tm' => $gtm->t_manager,
                            'tgl_open_tm' => $gtm->tgl_awal,
                            'tgl_close_tm' => $gtm->tgl_akhir,
                        ]);
                        // dd($save);
                    }
            //end gaji GTM
            
            //gaji KDIV
                $penjualan_kdiv = DB::table('tbl_penjualan_master as a')
                ->whereIn('kdiv_marketing',$data_kdiv)
                ->where('sts_flow',4)
                ->leftJoin('tbl_group_marketing as b','a.sales','b.nik_sales')
                ->leftJoin('tbl_karyawan as c','a.kdiv_marketing','c.nik')
                ->leftJoin('tbl_jabatan as d','c.jabatan','d.kode_jabatan')
                ->leftJoin('tbl_periode as e','a.t_manager','e.nik_tm')
                ->where('tgl_akhir',null)
                ->get(); 
                // dd($penjualan_kdiv);
                    foreach ($penjualan_kdiv->unique('kdiv_marketing') as $kdiv) {  
                        $nominal_penjualan_kdiv=$penjualan_kdiv->where('kdiv_marketing',$kdiv->kdiv_marketing)->sum('total_harga');
                        $cn_kdiv =DB::table('tbl_cn')->where('koordinator',$kdiv->sales)->sum('nominal');
                        $penjualan_bersih_kdiv = $nominal_penjualan_kdiv - $cn_kdiv;
                         // insentif gtm
                            if ($penjualan_bersih_kdiv < 150000000) {
                                $persen_kdiv = 0;
                                $incentive_kdiv = 0;
                            }elseif ($penjualan_bersih_kdiv < 250000000) {
                                $persen_kdiv = 0.6;
                                $incentive_kdiv = $penjualan_bersih_kdiv * $persen_kdiv / 100;
                            }elseif ($penjualan_bersih_kdiv < 400000000) {
                                $persen_kdiv = 1;
                                $incentive_kdiv = $penjualan_bersih_kdiv * $persen_kdiv / 100;
                            }else{
                                $persen_kdiv = 1.4;
                                $incentive_kdiv = $penjualan_bersih_kdiv * $persen_kdiv / 100;
                            }
                        // end insentif
                        $jumlah_tm = DB::table('tbl_penjualan_master')
                        ->where('tgl_jual','>=',$kdiv->tgl_awal)
                        ->where('sts_flow',4)
                        ->where('kdiv_marketing',$kdiv->nik)
                        ->distinct()
                        ->count('t_manager');

                        $tunjangan_ops_kdiv = $jumlah_tm * 2000000 ;

                        $gaji_kdiv = $incentive_kdiv + $tunjangan_ops_kdiv;
                        $kasbon_kdiv = DB::table('tbl_kasbon')->where('nik',$kdiv->nik)->sum('nom_kasbon');
                        $total_gaji_kdiv = $gaji_tm - $kasbon_tm;

                        DB::table('tbl_gaji')->updateOrInsert([
                        // $save = ([
                            'nik' => $kdiv->nik,
                            'nama' => $kdiv->nama,
                            'jabatan' =>  $kdiv->nama_jabatan,
                            'level_jabatan' =>  $kdiv->level_jabatan,
                            'periode' => $kdiv->periode,
                            'tahun' => $kdiv->tahun_periode,
                            'penjualan' =>  $nominal_penjualan_kdiv,
                            'cn' => $cn_kdiv,
                            'penjualan_bersih' => $penjualan_bersih_kdiv,
                            'incentive_persen' => $persen_kdiv,
                            'incentive' => $incentive_kdiv,
                            'bonus' => '',
                            'tunjangan_ops' => $tunjangan_ops_kdiv,
                            'gaji' => $gaji_kdiv,
                            'kasbon' => $kasbon_kdiv,
                            'total_gaji' => $total_gaji_kdiv,
                            'nik_kdiv' => $kdiv->kdiv_marketing,
                            'nik_gtm' => $kdiv->gt_manager,
                            'nik_tm' => $kdiv->t_manager,
                            'tgl_open_tm' => $kdiv->tgl_awal,
                            'tgl_close_tm' => $kdiv->tgl_akhir,
                        ]);
                        // dd($save);
                    }
            //end gaji KDIV
        //proses update gaji

        $data = $request->except('_token');
            // update table periode
        DB::table('tbl_periode')
        ->where('nik_tm',$data['nik_tm'])
        ->where('tahun_periode',$data['tahun_periode'])
        ->where('periode',$data['periode'])
        ->where('tgl_awal',$id)
        ->update($data);
        
        // update gaji close
        DB::table('tbl_gaji')
        ->where('nik_tm',$data['nik_tm'])
        ->orwhere('nik',$data['nik_tm'])
        ->where('tahun',$data['tahun_periode'])
        ->where('periode',$data['periode'])
        ->where('tgl_open_tm',$id)
        ->update([
            'tgl_close_tm' => $data['tgl_akhir']
        ]);
        // dd($data['tgl_akhir']);
        
        return redirect()->back()->with('alert', 'Penjualan Telah Close!'); 
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