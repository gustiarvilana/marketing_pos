<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenjualanMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function data(Request $request)
    {
        $filter_tahun = $request->input('tahun');        
        $filter_bulan = $request->input('bulan');
        $filter_flow = $request->input('flow');

        if (Auth::user()->level == 32) {
            $level = 't_manager';
            $level_periode = 'nik_tm';
        }elseif (Auth::user()->level == 23) {
            $level = 'gt_manager';
            $level_periode = 'nik_gtm';
        }elseif (Auth::user()->level == 25 ) {
            $level = 'kdiv_marketing';
            $level_periode = 'nik_kdiv';
        }

        // ambil tanggal periode
        $periode=DB::table('tbl_periode')
            ->where( $level_periode,Auth::user()->nik)
            ->where('tahun_periode',$filter_tahun)
            ->where('periode',$filter_bulan)->select('tgl_awal','tgl_akhir')
            ->first();
        
        $penjualan = DB::table('tbl_penjualan_master as a')
        ->leftJoin('tbl_place_kelurahan as b', 'a.kelurahan','b.subdis_id')
        ->leftJoin('tbl_place_kecamatan as c', 'a.kecamatan','c.dis_id')
        ->leftJoin('tbl_place_kota as d', 'a.kota','d.city_id')
        ->leftJoin('tbl_group_marketing as e', 'a.sales','e.nik_sales')
        ->where($level,Auth::user()->nik)
        ->select(
            'nosp',
            'nama_customer',
            'alamat',
            'b.subdis_name',
            'dis_name',
            'd.city_name',
            'tgl_jual',
            'sts_flow',
            'e.nama_sales',
            'e.nama_tm',
            'e.nama_gtm',
        )
        ->orderBy('id_penjualan','DESC');
        
        if ($filter_tahun && $filter_bulan) {
            
            if ($periode) {
                $tgl_awal = $periode->tgl_awal;
                $tgl_akhir = $periode->tgl_akhir;
                
                    $penjualan = DB::table('tbl_penjualan_master as a')
                    ->leftJoin('tbl_place_kelurahan as b', 'a.kelurahan','b.subdis_id')
                    ->leftJoin('tbl_place_kecamatan as c', 'a.kecamatan','c.dis_id')
                    ->leftJoin('tbl_place_kota as d', 'a.kota','d.city_id')
                    ->leftJoin('tbl_group_marketing as e', 'a.sales','e.nik_sales')
                    ->where($level,Auth::user()->nik)
                    ->where('periode_tahun',$filter_tahun)
                    ->where('periode_bulan',$filter_bulan)
                    ->select(
                        'nosp',
                        'nama_customer',
                        'alamat',
                        'b.subdis_name',
                        'dis_name',
                        'd.city_name',
                        'tgl_jual',
                        'sts_flow',
                        'e.nama_sales',
                        'e.nama_tm',
                        'e.nama_gtm',
                        )
                        ->orderBy('id_penjualan','DESC');
                        // dd($tgl_awal);
                        
                         if ($filter_flow != null) {
                            $penjualan = DB::table('tbl_penjualan_master as a')
                            ->leftJoin('tbl_place_kelurahan as b', 'a.kelurahan','b.subdis_id')
                            ->leftJoin('tbl_place_kecamatan as c', 'a.kecamatan','c.dis_id')
                            ->leftJoin('tbl_place_kota as d', 'a.kota','d.city_id')
                            ->leftJoin('tbl_group_marketing as e', 'a.sales','e.nik_sales')
                            ->where($level,Auth::user()->nik)
                            ->where('sts_flow',$filter_flow)
                            ->where('periode_tahun',$filter_tahun)
                            ->where('periode_bulan',$filter_bulan)
                            ->select(
                                'nosp',
                                'nama_customer',
                                'alamat',
                                'b.subdis_name',
                                'dis_name',
                                'd.city_name',
                                'tgl_jual',
                                'sts_flow',
                                'e.nama_sales',
                                'e.nama_tm',
                                'e.nama_gtm',
                            )
                            ->orderBy('id_penjualan','DESC');
                        }

                // tutup periode
                    // if ($tgl_awal && $tgl_akhir) {
                    //     $penjualan = DB::table('tbl_penjualan_master as a')
                    //     ->leftJoin('tbl_place_kelurahan as b', 'a.kelurahan','b.subdis_id')
                    //     ->leftJoin('tbl_place_kecamatan as c', 'a.kecamatan','c.dis_id')
                    //     ->leftJoin('tbl_place_kota as d', 'a.kota','d.city_id')
                    //     ->leftJoin('tbl_group_marketing as e', 'a.sales','e.nik_sales')
                    //     ->where($level,Auth::user()->nik)
                    //     ->where('periode_tahun',$filter_tahun)
                    //     ->select(
                    //         'nosp',
                    //         'nama_customer',
                    //         'alamat',
                    //         'b.subdis_name',
                    //         'dis_name',
                    //         'd.city_name',
                    //         'tgl_jual',
                    //         'sts_flow',
                    //         'e.nama_sales',
                    //         'e.nama_tm',
                    //         'e.nama_gtm',
                    //     )
                    //     ->orderBy('id_penjualan','DESC');

                    //     if ($filter_flow != null) {
                    //         $penjualan = DB::table('tbl_penjualan_master as a')
                    //         ->leftJoin('tbl_place_kelurahan as b', 'a.kelurahan','b.subdis_id')
                    //         ->leftJoin('tbl_place_kecamatan as c', 'a.kecamatan','c.dis_id')
                    //         ->leftJoin('tbl_place_kota as d', 'a.kota','d.city_id')
                    //         ->leftJoin('tbl_group_marketing as e', 'a.sales','e.nik_sales')
                    //         ->where($level,Auth::user()->nik)
                    //         ->where('sts_flow',$filter_flow)
                    //         ->where('periode_bulan',$filter_bulan)
                    //         ->select(
                    //             'nosp',
                    //             'nama_customer',
                    //             'alamat',
                    //             'b.subdis_name',
                    //             'dis_name',
                    //             'd.city_name',
                    //             'tgl_jual',
                    //             'sts_flow',
                    //             'e.nama_sales',
                    //             'e.nama_tm',
                    //             'e.nama_gtm',
                    //         )
                    //         ->orderBy('id_penjualan','DESC');
                    //     }
                    // }
                // tutup periode
                
                
            }else{
                $penjualan = DB::table('tbl_penjualan_master')
                ->where('t_manager','123456566')
                ->orderBy('id_penjualan','DESC');
            }
            // dd($penjualan);
        }
        
        return datatables()::of($penjualan)
            ->addIndexColumn()
            ->addColumn('status', function($penjualan){
                if ($penjualan->sts_flow == '1') {
                    return '
                        <span class="label label-warning">Order</span>
                    ';
                }
                if ($penjualan->sts_flow == '2') {
                    return '
                        <span class="label label-info">Verified</span>
                    ';
                }
                if ($penjualan->sts_flow == '3') {
                    return '
                        <span class="label label-primary">Delivery</span>
                    ';
                }
                if ($penjualan->sts_flow == '4') {
                    return '
                        <span class="label label-success">Delivered</span>
                    ';
                }
                if ($penjualan->sts_flow == '20') {
                    return '
                        <span class="label label-danger">Unverified</span>
                    ';
                }
                if ($penjualan->sts_flow == '30') {
                    return '
                        <span class="label label-danger">Undelivery</span>
                    ';
                }
            })
            ->addColumn('aksi', function($penjualan){
                return '
                        <a href="'.route('penjualan_master.detail', $penjualan->nosp).'" class="btn btn-info btn-xs">Details</a>
                    ';
            })
            ->rawColumns(['status','aksi'])
            ->make(true); 
    } 

    public function index()
    {
        $sts_flow = DB::table('tbl_status')->get();
        return view('penjualan_master.index',compact('sts_flow'));
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
     * @return \Illuminate\Http\Response
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

     public function detail($id)
    {
        
        $customer = DB::table('tbl_penjualan_master')->where('nosp',$id)->first();
        
        // dd($customer);
        if ($customer) {
            $produk = DB::table('tbl_penjualan_detail')->where('nosp',$id)->get();
        }

        return view('penjualan_master.detail2', compact('customer', 'produk'));
        // return response()->json($customer);
    }
}