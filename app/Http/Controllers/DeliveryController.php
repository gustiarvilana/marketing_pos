<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeliveryController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function data(Request $request)
    {
        $filter = $request->input('name');        

        $penjualan = DB::table('tbl_penjualan_master')->where('sts_flow','2');

        if ($filter != null) {
            $penjualan = DB::table('tbl_penjualan_master')
            ->where('sts_flow','2')
            ->where('nama_customer','like', '%' . $filter . '%')
            ->orWhere('nosp', $filter );
        }

        // dd($penjualan);

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
                        <a href="'.route('delivery.detail', $penjualan->nosp).'" class="btn btn-info btn-xs">Detail</a>
                    ';
            })
            ->rawColumns(['status','aksi'])
            ->make(true); 
    }

    public function index()
    {
        return view('delivery.index');
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
    // UPDATE VERIF
    public function show(Request $request,$id)
    {
        $now=date('Ymd');
        $data = $request->except(['_token']);
        $data['tgl_verif'] =$now;
        $data['verifikator'] =Auth::user()->nik;
        // dd($data);
        DB::table('tbl_penjualan_master')->where('nosp',$id)->update($data);

        return response()->json('Data Berhasil diupdate',200);
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
        // $user = DB::table('tbl_penjualan_master')->where('nosp',$id);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $penjualan = DB::table('tbl_penjualan_detail')->where('nosp',$id);
        $penjualan->delete();

        return response(null,204);
    }
    
    public function detail($id)
    {
        $customer = DB::table('tbl_penjualan_master')
        ->where('nosp',$id)->first();
        
        $produk = DB::table('tbl_penjualan_detail')
        ->where('nosp',$id)->get();

        
        // dd($customer);
        
        return view('delivery.detail2', compact('customer', 'produk'));
        // return response()->json($customer);
    }
}