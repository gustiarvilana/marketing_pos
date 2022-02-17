<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\CnExport;
use App\Imports\CnImport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class CnController extends Controller
{
     /**
    * @return \Illuminate\Support\Collection
    */
    public function importExportView()
    {
       return view('import');
    }
     
    /**
    * @return \Illuminate\Support\Collection
    */
    public function export() 
    {
        return Excel::download(new CnExport, 'users.xlsx');
    }
     
    /**
    * @return \Illuminate\Support\Collection
    */
    public function import(Request $request) 
    {
        $tahun = $request->input('tahun');
        $periode = $request->input('periode');
        $now= date('Ymd');
        session([
            'tahun' => $tahun,
            'periode' => $periode,
        ]);
        
        Excel::import(new CnImport,request()->file('file'));

        DB::table('tbl_cn')->where('nosp','nosp')->delete();

        $data_cn = DB::table('tbl_cn')->where('tahun', session('tahun'))->where('periode' , session('periode'))->get();
        $jumlah_cn = $data_cn->count('*');
        $nominal_cn = $data_cn->sum('nominal');
        
        // dd($nominal_cn);
        // insert log
        
        DB::table('tbl_cn_log')->insert([
            'tahun' => session('tahun'),
            'periode' =>session('periode'),
            'jumlah_cn' =>$jumlah_cn,
            'nominal_cn' =>$nominal_cn,
            'tanggal_input' =>$now,
        ]);

        $tahun =session()->forget('tahun');
        $periode =session()->forget('periode'); 
        return back()->with('import', 'Success ~ Data CN Telah diupoload!');
    }
}