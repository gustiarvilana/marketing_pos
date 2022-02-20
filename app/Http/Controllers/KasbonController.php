<?php

namespace App\Http\Controllers;

use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KasbonController extends Controller
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

        $user = DB::table('tbl_kasbon as a')
        ->Join('tbl_karyawan as b', 'a.nik', 'b.nik')
        ->select(
            'a.nik',
            'b.nama',
            'a.tgl_kasbon',
            'a.nom_kasbon',
            'a.ket_keperluan',
            'a.batch',
        )
        ->orderBy('tgl_kasbon','DESC');

        if ($filter_tahun != null && $filter_bulan != null) {
            // ambil tanggal periode
            $periode=DB::table('tbl_periode')
            ->where('nik_tm',Auth::user()->nik)
            ->where('tahun_periode',$filter_tahun)
            ->where('periode',$filter_bulan)->select('tgl_awal','tgl_akhir')
            ->first();
            // end ambil tanggal periode
            
            
            if ($periode) {
                $tgl_awal = $periode->tgl_awal;
                $tgl_akhir = $periode->tgl_akhir;
                
                if ($tgl_akhir == null) {
                    $user = DB::table('tbl_kasbon as a')
                    ->leftJoin('tbl_karyawan as b', 'a.nik', 'b.nik')
                    ->leftJoin('tbl_periode as c', 'a.nik', 'c.nik_tm')
                    ->where('a.tgl_kasbon', '>=' ,$tgl_awal)
                    ->select(
                        'a.nik',
                        'b.nama',
                        'a.tgl_kasbon',
                        'a.nom_kasbon',
                        'a.ket_keperluan',
                        'a.batch',
                    )
                    ->orderBy('a.tgl_kasbon','asc');
                }else {
                    $user = DB::table('tbl_kasbon as a')
                    ->leftJoin('tbl_karyawan as b', 'a.nik', 'b.nik')
                    ->leftJoin('tbl_periode as c', 'a.nik', 'c.nik_tm')
                    ->whereBetween('a.tgl_kasbon', [$tgl_awal, $tgl_akhir])
                    ->select(
                        'a.nik',
                        'b.nama',
                        'a.tgl_kasbon',
                        'a.nom_kasbon',
                        'a.ket_keperluan',
                        'a.batch',
                    )
                    ->orderBy('a.tgl_kasbon','asc');
                }
            }else {
                $user = DB::table('tbl_kasbon as a')
                ->Join('tbl_karyawan as b', 'a.nik', 'b.nik')
                ->Join('tbl_periode as c', 'a.nik', 'c.nik_tm')
                ->where('c.nik_tm',1234567543);
            }
        }


        return datatables()::of($user)
            ->addIndexColumn()
            ->addColumn('aksi', function($user){
                return '
                    <button onclick="editform(`'. route('kasbon.update',$user->nik) .'`)" class="btn btn-info btn-xs">Edit</button>
                    <button onclick="deleteform(`'. route('kasbon.destroy',$user->nik) .'`)" class="btn btn-danger btn-xs">Hapus</button>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
    
    public function index() 
    {
        if (Auth::user()->level == '32') {
            $w_nik = 'nik_tm';
            $w_nama = 'nama_sales';
            $nik_pluck = 'nik_sales';
        }
        if (Auth::user()->level == '23') {
            $w_nik = 'nik_gtm';
            $w_nama = 'nama_tm';
            $nik_pluck = 'nik_tm';
        }
        if (Auth::user()->level == '25') {
            $w_nik = 'nik_kdiv';
            $w_nama = 'nama_gtm';
            $nik_pluck = 'nik_gtm';
        }
        $nik=Auth::user()->nik;
        $karyawan =  DB::table('tbl_group_marketing')->where($w_nik, $nik)->orderBy($w_nama,'asc')->pluck( $nik_pluck,$w_nama); 
        
        // dd($karyawan);
        
        return view('kasbon.index',compact('karyawan'));
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
        $data = $request->except('_token','_method','nama');
        DB::table('tbl_kasbon')->insert($data);

        return response()->json('Data Berhasil Disimpan',200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($nik)
    {
        $user = DB::table('tbl_kasbon as a')
        ->Join('tbl_karyawan as b', 'a.nik', 'b.nik')
        ->where('a.nik',$nik)->first();
        
        return response()->json($user);
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
        $data = $request->except('_token','_method','nama');
        $user =  DB::table('tbl_kasbon as a')->where('nik',$id);
        $user->update($data);

        return response()->json('Data Berhasil Update',200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user =  DB::table('tbl_kasbon')->where('nik',$id);
        $user->delete();

        return response(null,204);
    }
}