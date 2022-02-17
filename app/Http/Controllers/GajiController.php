<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GajiController extends Controller
{
    public function data(Request $request)
    {
        $login_level = Auth::user()->level;
        
        if ($login_level == '32') {
            $level = 'nik_tm';
        }
        if ($login_level == '23') {
            $level = 'nik_gtm';
        }
        if ($login_level == '25') {
            $level = 'nik_kdiv';
        }
        // dd($login_level);

        $filter_tahun = $request->input('tahun');
        $filter_bulan = $request->input('bulan');

        $user = DB::table('tbl_gaji')->where('tgl_close_tm',null)->where($level,Auth::user()->nik);
       
        if ($filter_tahun != null && $filter_bulan != null ) {
            $user = DB::table('tbl_gaji')   
            ->where('tgl_close_tm','>', 0)
            ->where('tahun', $filter_tahun)
            ->where('periode', $filter_bulan)
            ->where($level,Auth::user()->nik);
        }

        // dd($user);

        return datatables()::of($user)
        ->addIndexColumn()
        ->addColumn('aksi', function($user){
        return '
                <button onclick="editform(`'. route('user.update',$user->nik) .'`)" class="btn btn-info btn-xs">Edit</button>
                <button onclick="deleteform(`'. route('user.destroy',$user->nik) .'`)" class="btn btn-danger btn-xs" style="display:none">Hapus</button>
            ';
        })
        ->rawColumns(['aksi'])
        ->make(true);
    }

    public function index()
    {
        return view('gaji.index');
    }

    public function prosess()
    {
        
        if (Auth::user()->level == 32 || Auth::user()->level == 23 || Auth::user()->level == 25) {
            
            $periode_now = DB::table('tbl_periode')
                ->where('tgl_akhir',null)
                ->orderBy('tgl_awal','asc')
                ->first();

            $data_sales = DB::table('tbl_group_marketing as a')
                ->leftJoin('tbl_karyawan as b','a.nik_sales','b.nik')
                ->where('b.status',1)
                ->distinct()->get('b.nik');
            $data_tm = DB::table('tbl_group_marketing as a')
                ->leftJoin('tbl_karyawan as b','a.nik_tm','b.nik')
                ->where('b.status',1)
                ->distinct()->get('b.nik');
            $data_gtm = DB::table('tbl_group_marketing as a')
                ->leftJoin('tbl_karyawan as b','a.nik_gtm','b.nik')
                ->where('b.status',1)
                ->distinct()->get('b.nik');
            $data_kdiv = DB::table('tbl_group_marketing as a')
                ->leftJoin('tbl_karyawan as b','a.nik_kdiv','b.nik')
                ->where('b.status',1)
                ->distinct()->get('b.nik');

            DB::table('tbl_gaji')->where('tgl_close_tm',null)->delete();
            
            //gaji sales
                foreach ($data_sales as $nik_array) {

                    $sales_detail = DB::table('tbl_karyawan as a')->where('nik',$nik_array->nik)
                        ->leftJoin('tbl_jabatan as b', 'a.jabatan', 'b.kode_jabatan')
                        ->get();
                    
                        foreach ($sales_detail as $sales_array) {
                            $penjualan_sales = DB::table('tbl_penjualan_master')->where('sales',$sales_array->nik)
                            ->get();
                            $up_level = $penjualan_sales->first();
                            
                            $total_penjualan_sales = $penjualan_sales->sum('total_harga');
                            $cn_sales = $penjualan_sales->sum('cn');
                            $penjualan_bersih_sales = $total_penjualan_sales - $cn_sales;

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
                            $cn_sales = DB::table('tbl_cn')->where('sales', $nik_array->nik)->where('tgl_penarikan','>=',$periode_now->tgl_awal)->sum('nominal');
                            $kasbon_sales = DB::table('tbl_kasbon')->where('nik', $nik_array->nik)->where('tgl_kasbon','>=', $periode_now->tgl_awal)->sum('nom_kasbon');

                            $total_gaji_sales = $gaji_sales - $kasbon_sales;

                            DB::table('tbl_gaji')->updateOrInsert([
                            // $save = ([
                                'nik' => $sales_array->nik,
                                'nama' => $sales_array->nama,
                                'jabatan' =>  $sales_array->nama_jabatan,
                                'periode' => $periode_now->periode,
                                'tahun' => $periode_now->tahun_periode,
                                'penjualan' =>  $total_penjualan_sales,
                                'cn' => $cn_sales,
                                'penjualan_bersih' => $penjualan_bersih_sales,
                                'incentive_persen' => $persen_sales,
                                'incentive' => $insentif_sales,
                                'bonus' => $bonus_sales,
                                'tunjangan_ops' => '',
                                'gaji' => $gaji_sales,
                                'kasbon' => $cn_sales,
                                'total_gaji' => $total_gaji_sales,
                                'nik_kdiv' => $up_level->kdiv_marketing,
                                'nik_gtm' => $up_level->gt_manager,
                                'nik_tm' => $up_level->t_manager,
                                'tgl_open_tm' => $periode_now->tgl_awal,
                                'tgl_close_tm' => $periode_now->tgl_akhir,
                            ]);

                        }
                }
            //end gaji sales
            
            //gaji tm
                foreach ($data_tm as $nik_array) {

                    $tm_detail = DB::table('tbl_karyawan as a')->where('nik',$nik_array->nik)
                        ->leftJoin('tbl_jabatan as b', 'a.jabatan', 'b.kode_jabatan')
                        ->get();

                    foreach ($tm_detail as $tm_array) {
                        $penjualan_tm = DB::table('tbl_penjualan_master')->where('t_manager',$tm_array->nik)
                        ->get();

                        $up_level = $penjualan_tm->first();

                        $total_penjualan_tm = $penjualan_tm->sum('total_harga');
                        $cn_tm = $penjualan_tm->sum('cn');
                        $penjualan_bersih_tm = $total_penjualan_tm - $cn_tm;

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
                        $cn_tm = DB::table('tbl_cn')->where('koordinator', $nik_array->nik)->where('tgl_penarikan','>=',$periode_now->tgl_awal)->sum('nominal');
                        $kasbon_tm = DB::table('tbl_kasbon')->where('nik', $nik_array->nik)->where('tgl_kasbon','>=', $periode_now->tgl_awal)->sum('nom_kasbon');

                        $total_gaji_tm = $gaji_tm - $kasbon_tm;

                        DB::table('tbl_gaji')->Insert([
                        // $save = ([
                            'nik' => $tm_array->nik,
                            'nama' => $tm_array->nama,
                            'jabatan' => $tm_array->nama_jabatan,
                            'periode' => $periode_now->periode,
                            'tahun' => $periode_now->tahun_periode,
                            'penjualan' =>  $total_penjualan_tm,
                            'cn' => $cn_tm,
                            'penjualan_bersih' =>  $penjualan_bersih_tm,
                            'incentive_persen' => $persen_tm ,
                            'incentive' => $insentif_tm,
                            'bonus' => '0',
                            'tunjangan_ops' => $tunjangan_ops_tm,
                            'gaji' => $gaji_tm,
                            'kasbon' => $kasbon_tm,
                            'total_gaji' => $total_gaji_tm,
                            'nik_kdiv' => $up_level->kdiv_marketing,
                            'nik_gtm' => $up_level->gt_manager,
                            'nik_tm' => $up_level->t_manager,
                            'tgl_open_tm' => $periode_now->tgl_awal,
                            'tgl_close_tm' => $periode_now->tgl_akhir,
                        ]);
                    }     
                }
            // end gaji tm
            
            //gaji gtm
                foreach ($data_gtm as $nik_array) {

                    $gtm_detail = DB::table('tbl_karyawan as a')->where('nik',$nik_array->nik)
                        ->leftJoin('tbl_jabatan as b', 'a.jabatan', 'b.kode_jabatan')
                        ->get();

                    foreach ($gtm_detail as $gtm_array) {
                        $penjualan_gtm = DB::table('tbl_penjualan_master')->where('gt_manager',$gtm_array->nik)
                        ->get();

                        $up_level_gtm = $penjualan_gtm->first();

                        $total_penjualan_gtm = $penjualan_gtm->sum('total_harga');
                        $cn_gtm = $penjualan_gtm->sum('cn');
                        $penjualan_bersih_gtm = $total_penjualan_gtm - $cn_gtm;

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
                //     // end insentif

                        $gaji_gtm = $incentive_gtm + $tunjangan_ops_gtm;
                        $cn_gtm = DB::table('tbl_cn')->where('supervisor_mrk', $nik_array->nik)->where('tgl_penarikan','>=',$periode_now->tgl_awal)->sum('nominal');
                        $kasbon_gtm = DB::table('tbl_kasbon')->where('nik', $nik_array->nik)->where('tgl_kasbon','>=', $periode_now->tgl_awal)->sum('nom_kasbon');

                        $total_gaji_gtm = $gaji_gtm - $kasbon_gtm;

                        DB::table('tbl_gaji')->Insert([
                            'nik' => $gtm_array->nik,
                            'nama' => $gtm_array->nama,
                            'jabatan' => $gtm_array->nama_jabatan,
                            'periode' => $periode_now->periode,
                            'tahun' => $periode_now->tahun_periode,
                            'penjualan' =>  $total_penjualan_gtm,
                            'cn' => $cn_gtm,
                            'penjualan_bersih' =>  $penjualan_bersih_gtm,
                            'incentive_persen' => $persen_gtm ,
                            'incentive' => $incentive_gtm,
                            'bonus' => '0',
                            'tunjangan_ops' => $tunjangan_ops_gtm,
                            'gaji' => $gaji_gtm,
                            'kasbon' => $kasbon_gtm,
                            'total_gaji' => $total_gaji_gtm,
                            'nik_kdiv' => $up_level_gtm->kdiv_marketing,
                            'nik_gtm' => $up_level_gtm->gt_manager,
                            'nik_tm' => $up_level_gtm->t_manager,
                            'tgl_open_tm' => $periode_now->tgl_awal,
                            'tgl_close_tm' => $periode_now->tgl_akhir,
                        ]);
                    }     
                }
            // end gaji gtm
            
            //gaji kdiv
                foreach ($data_kdiv as $nik_array) {

                    $kdiv_detail = DB::table('tbl_karyawan as a')->where('nik',$nik_array->nik)
                        ->leftJoin('tbl_jabatan as b', 'a.jabatan', 'b.kode_jabatan')
                        ->get();

                    foreach ($kdiv_detail as $kdiv_array) {
                        $penjualan_kdiv = DB::table('tbl_penjualan_master')->where('kdiv_marketing',$kdiv_array->nik)
                        ->get();

                        $up_level_kdiv = $penjualan_kdiv->first();
                        // dd($kdiv_array);

                        $total_penjualan_kdiv = $penjualan_kdiv->sum('total_harga');
                        $cn_kdiv = $penjualan_kdiv->sum('cn');
                        $penjualan_bersih_kdiv = $total_penjualan_kdiv - $cn_kdiv;

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
                        ->where('tgl_jual','>=',$periode_now->tgl_awal)
                        ->where('sts_flow',4)
                        ->where('kdiv_marketing',$kdiv_array->nik)
                        ->distinct()
                        ->count('t_manager');

                        $tunjangan_ops_kdiv = $jumlah_tm * 2000000 ;

                        $gaji_kdiv = $incentive_kdiv + $tunjangan_ops_kdiv;
                        $cn_kdiv = DB::table('tbl_cn')->where('kdiv', $nik_array->nik)->where('tgl_penarikan','>=',$periode_now->tgl_awal)->sum('nominal');
                        $kasbon_kdiv = DB::table('tbl_kasbon')->where('nik', $nik_array->nik)->where('tgl_kasbon','>=', $periode_now->tgl_awal)->sum('nom_kasbon');

                        $total_gaji_kdiv = $gaji_kdiv - $kasbon_kdiv;

                        DB::table('tbl_gaji')->Insert([
                        // $save = ([
                            'nik' => $kdiv_array->nik,
                            'nama' => $kdiv_array->nama,
                            'jabatan' => $kdiv_array->nama_jabatan,
                            'periode' => $periode_now->periode,
                            'tahun' => $periode_now->tahun_periode,
                            'penjualan' =>  $total_penjualan_kdiv,
                            'cn' => $cn_kdiv,
                            'penjualan_bersih' =>  $penjualan_bersih_kdiv,
                            'incentive_persen' => $persen_kdiv ,
                            'incentive' => $incentive_kdiv,
                            'bonus' => '0',
                            'tunjangan_ops' => $tunjangan_ops_kdiv,
                            'gaji' => $gaji_kdiv,
                            'kasbon' => $kasbon_kdiv,
                            'total_gaji' => $total_gaji_kdiv,
                            'nik_kdiv' => $up_level_kdiv->kdiv_marketing,
                            'nik_gtm' => $up_level_kdiv->gt_manager,
                            'nik_tm' => $up_level_kdiv->t_manager,
                            'tgl_open_tm' => $periode_now->tgl_awal,
                            'tgl_close_tm' => $periode_now->tgl_akhir,
                        ]);
                                                // dd($save);
                    }     
                }
            // end gaji kdiv

        }

        return redirect()->back()->with('msg', 'Data berjalan telah diupdate!');
    }
}