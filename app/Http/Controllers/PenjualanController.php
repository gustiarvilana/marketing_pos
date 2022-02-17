<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function data(Request $request)
    {
        $filter = $request->input('name');        

        DB::table('tbl_penjualan_master')->where('nosp','0')->orWhere('nosp', null)->delete();
        DB::table('tbl_penjualan_detail')->where('nosp','0')->orWhere('nosp', null)->delete();

        $penjualan = DB::table('tbl_penjualan_master')
        ->where('t_manager',Auth::user()->nik)
        ->where('sts_flow','1')
        ->orderBy('id_penjualan','DESC');

        if ($filter != null) {
            $penjualan = DB::table('tbl_penjualan_master')
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
                        <a href="'.route('penjualan.detail', $penjualan->nosp).'" class="btn btn-info btn-xs">Detail</a>
                    ';
            })
            ->rawColumns(['status','aksi'])
            ->make(true); 
    } 

    public function index()
    {
        $provinsi=DB::table('tbl_place_provinsi')->orderBy('prov_name','ASC')->get();
        return view('penjualan.index',compact('provinsi'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $penjualan = new Penjualan();
        $penjualan->nosp = '0';
        $penjualan->batch_user = Auth::user()->nik;
        $penjualan->save();

        session(['id_penjualan' => $penjualan->id_penjualan]);

        return redirect()->route('transaksi.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // save penjualan master
        $penjualan = Penjualan::findOrFail($request->id_penjualan);
        $data=$request->all();

        $cek = Penjualan::where('nosp', $data['nosp'])->pluck('nosp')->first();
        // dd($cek);
        if ($cek == null) {
            $sales=$data['sales'];
            $tm = DB::table('tbl_group_marketing')->where('nik_sales', $sales)->pluck('nik_tm')->first();
            $gtm = DB::table('tbl_group_marketing')->where('nik_sales', $sales)->where('nik_tm', $tm)->pluck('nik_gtm')->first();
            $kdiv = DB::table('tbl_group_marketing')->where('nik_sales', $sales)->where('nik_tm', $tm)->where('nik_gtm', $gtm)->pluck('nik_kdiv')->first();
            
            $data['t_manager'] = $tm;
            $data['gt_manager'] = $gtm;
            $data['kdiv_marketing'] = $kdiv;
            $penjualan->update($data);

            // update penjualan detail
            $detail = PenjualanDetail::where('id_penjualan_detail', $request->id_penjualan)->get();
            foreach ($detail as $item) {
                $item->nosp = $request->nosp;
                $item->update();

                // $produk = Produk::find($item->id_produk);
                // $produk->stok -= $item->jumlah;
                // $produk->update();
            }

            session()->forget('id_penjualan');
            
        } else{
            return Redirect::back()->withErrors(['msg' => 'Nosp Harus Unique']);
        }
        
        return redirect()->route('transaksi.selesai');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $detail = PenjualanDetail::with('produk')->where('id_penjualan', $id)->get();

        return datatables()
            ->of($detail)
            ->addIndexColumn()
            ->addColumn('kode_produk', function ($detail) {
                return '<span class="label label-success">'. $detail->produk->kode_produk .'</span>';
            })
            ->addColumn('nama_produk', function ($detail) {
                return $detail->produk->nama_produk;
            })
            ->addColumn('harga_jual', function ($detail) {
                return 'Rp. '. format_uang($detail->harga_jual);
            })
            ->addColumn('jumlah', function ($detail) {
                return format_uang($detail->jumlah);
            })
            ->addColumn('subtotal', function ($detail) {
                return 'Rp. '. format_uang($detail->subtotal);
            })
            ->rawColumns(['kode_produk'])
            ->make(true);
    }

    public function selesai()
    {
        return redirect()->route('penjualan.index');
    }

    public function notaKecil()
    {
        $setting = Setting::first();
        $penjualan = Penjualan::find(session('id_penjualan'));
        if (! $penjualan) {
            abort(404);
        }
        $detail = PenjualanDetail::with('produk')
            ->where('id_penjualan', session('id_penjualan'))
            ->get();
        
        return view('penjualan.nota_kecil', compact('setting', 'penjualan', 'detail'));
    }

    public function notaBesar()
    {
        $setting = Setting::first();
        $penjualan = Penjualan::find(session('id_penjualan'));
        if (! $penjualan) {
            abort(404);
        }
        $detail = PenjualanDetail::with('produk')
            ->where('id_penjualan', session('id_penjualan'))
            ->get();

        $pdf = PDF::loadView('penjualan.nota_besar', compact('setting', 'penjualan', 'detail'));
        $pdf->setPaper(0,0,609,440, 'potrait');
        return $pdf->stream('Transaksi-'. date('Y-m-d-his') .'.pdf');
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
        // $data = $request->all();
        // $penjualan = DB::table('tbl_penjualan_detail')->where('nosp',$id);
        // $pass = $data['password'];
        
        // $data['password'] = Hash::make($request->input('password'));


        // $penjualan->update(['pass'=>$pass]);
        // $penjualan->update($data);

        // return response()->json('Data Berhasil Update',200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        DB::table('tbl_penjualan_detail')->where('nosp',$id)->delete();
        DB::table('tbl_penjualan_master')->where('nosp',$id)->delete();

        return redirect()->route('penjualan.index');
        // return response(null,204);
    }
    
    public function detail($id)
    {
        
        $customer = DB::table('tbl_penjualan_master')->where('t_manager',Auth::user()->nik)
        ->where('nosp',$id)->first();
        
        if ($customer) {
            $produk = DB::table('tbl_penjualan_detail')
            ->where('nosp',$id)->get();
        }

        
        // dd($customer);
        
        return view('penjualan.detail2', compact('customer', 'produk'));
        // return response()->json($customer);
    }

    public function getkota(Request $request){
        $kota = DB::table('tbl_place_kota')->where("prov_id",$request->prov_id)
        ->orderBy('city_name','ASC')->pluck('city_id','city_name');
        return response()->json($kota);
    }
    public function getkecamatan(Request $request){
        $kecamatan = DB::table('tbl_place_kecamatan')->where("city_id",$request->city_id)
        ->orderBy('dis_name','ASC')->pluck('dis_id','dis_name');
        return response()->json($kecamatan);
    }
    public function getkelurahan(Request $request){
        $kelurahan = DB::table('tbl_place_kelurahan')->where("dis_id",$request->dis_id)
        ->orderBy('subdis_name','ASC')->pluck('subdis_id','subdis_name');
        return response()->json($kelurahan);
    }
    
}