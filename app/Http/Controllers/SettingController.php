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