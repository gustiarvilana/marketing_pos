<?php

namespace App\Http\Controllers;

use App\Models\User;
use GrahamCampbell\ResultType\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use function PHPUnit\Framework\returnSelf;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function data(Request $request)
    {

        DB::table('tbl_group_marketing')
        ->where('nama_sales', null)
        ->where('nik_sales', null)
        ->where('nik_tm', null)
        ->where('nik_gtm', null)
        ->delete();

        $filter = $request->input('name');

        if (Auth::user()->level == 32) {
            $karyawan = DB::table('tbl_group_marketing as a')
            ->where('nik_tm',Auth::user()->nik)
            ->leftJoin('tbl_karyawan as b','a.nik_sales','b.nik')
            ->leftJoin('tbl_jabatan as c', 'b.jabatan', 'c.kode_jabatan')
            ->leftJoin('users as d', 'b.nik', 'd.nik')
            ->select(
                'c.nama_jabatan',
                'b.nama',
                'd.username',
                'b.alamat',
                'b.tmk',
                'b.no_ktp',
                'b.nik',
                'b.status',
            );
        }
        if (Auth::user()->level == 23) {
          $nik_sales = DB::table('tbl_group_marketing')->where('nik_gtm',Auth::user()->nik)->get()->pluck('nik_sales');
          $nik_tm = DB::table('tbl_group_marketing')->where('nik_gtm',Auth::user()->nik)->get()->pluck('nik_tm');

            $karyawan = DB::table('tbl_karyawan as b')
            ->whereIn('b.nik', $nik_sales)
            ->orWhereIn('b.nik', $nik_tm)
            ->leftJoin('tbl_jabatan as c', 'b.jabatan', 'c.kode_jabatan')
            ->leftJoin('users as d', 'b.nik', 'd.nik')
            ->select(
                'c.nama_jabatan',
                'b.nama',
                'd.username',
                'b.alamat',
                'b.tmk',
                'b.no_ktp',
                'b.nik',
                'b.status',
            )
            ->get();
            // dd($karyawan);
        }
        if (Auth::user()->level == 25) {
            $nik_sales = DB::table('tbl_group_marketing')->where('nik_kdiv',Auth::user()->nik)->get()->pluck('nik_sales');
            $nik_tm = DB::table('tbl_group_marketing')->where('nik_kdiv',Auth::user()->nik)->get()->pluck('nik_tm');
            $nik_gtm = DB::table('tbl_group_marketing')->where('nik_kdiv',Auth::user()->nik)->get()->pluck('nik_gtm');
            $nik_all = DB::table('tbl_karyawan')->get()->pluck('nik');

            $karyawan = DB::table('tbl_karyawan as b')
            ->whereIn('b.nik', $nik_sales)
            ->orWhereIn('b.nik', $nik_tm)
            ->orWhereIn('b.nik', $nik_gtm)
            ->orWhereIn('b.nik', $nik_all)
            ->leftJoin('tbl_jabatan as c', 'b.jabatan', 'c.kode_jabatan')
            ->leftJoin('users as d', 'b.nik', 'd.nik')
            ->select(
                'c.nama_jabatan',
                'b.nama',
                'd.username',
                'b.alamat',
                'b.tmk',
                'b.no_ktp',
                'b.nik',
                'b.status',
            )
            ->get();
        }
        if (Auth::user()->level == 99) {
            $karyawan = DB::table('tbl_karyawan as b')
            // ->leftJoin('tbl_karyawan','tbl_group_marketing.nik_sales','tbl_karyawan.nik')
            ->leftJoin('tbl_jabatan as c', 'b.jabatan', 'c.kode_jabatan')
            ->leftJoin('users as d', 'b.nik', 'd.nik')
            ->select(
                'c.nama_jabatan',
                'b.nama',
                'd.username',
                'b.alamat',
                'b.tmk',
                'b.no_ktp',
                'b.nik',
                'b.status',
            )
            ->get();
            
        }


        if ($filter != null) {
           $karyawan = DB::table('tbl_group_marketing as a')
            ->where('nik_tm',Auth::user()->nik)
            ->leftJoin('tbl_karyawan as b','a.nik_sales','b.nik')
            ->leftJoin('tbl_jabatan as c', 'b.jabatan', 'c.kode_jabatan')
            ->leftJoin('users as d', 'b.nik', 'd.nik')
            ->select(
                'c.nama_jabatan',
                'b.nama',
                'd.username',
                'b.alamat',
                'b.tmk',
                'b.no_ktp',
                'b.nik',
                'b.status',
            )
            ->where('nama','like', '%' . $filter . '%');
        }

        return datatables()::of($karyawan)
            ->addIndexColumn()
            ->addColumn('aksi', function($karyawan){
                return '
                    <button onclick="editform(`'. route('karyawan.update',$karyawan->nik) .'`)" class="btn btn-info btn-xs">Edit</button>
                    <button onclick="deleteform(`'. route('karyawan.destroy',$karyawan->nik) .'`)" class="btn btn-danger btn-xs" style="display:none" >Hapus</button>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function index()
    {
        $jabatan = DB::table('tbl_jabatan')->get();
        $data_tm = DB::table('tbl_jabatan')->where('kode_jabatan', '32')->get();
        $data_gtm = DB::table('tbl_jabatan')->where('kode_jabatan', '23')->get();
        $data_kdiv = DB::table('tbl_jabatan')->where('kode_jabatan', '25')->get();

        $karyawan = DB::table('tbl_karyawan')->get();
        return view('karyawan.index',compact('jabatan','karyawan','data_tm','data_gtm','data_kdiv'));
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

        if ($request->input('kode_jabatan') == 31) {
             if ($request->input('nik_sales') != null) {
                // insert tbl_group
                DB::table('tbl_group_marketing')
                ->insert([
                    'nik_sales' => $request->input('nik_sales'),
                    'nama_sales' => $request->input('nama_sales'),
                    'nik_tm' => $request->input('nik_tm'),
                    'nama_tm' => $request->input('nama_tm'),
                    'nik_gtm' => $request->input('nik_gtm'),
                    'nama_gtm' => $request->input('nama_gtm'),
                    'nik_kdiv' => $request->input('nik_kdiv'),
                    'nama_kdiv' => $request->input('nama_kdiv'),
                ]);
            }else{
                return redirect()->route('karyawan.index')->with('error', 'form Link Sales harus diisi!');
            }
        }
       

        // insert tbl_karyawan
            DB::table('tbl_karyawan')
            ->insert([
                'nik' => $request->input('nik'),
                'nama' => $request->input('nama'),
                'alamat' => $request->input('alamat'),
                'kec' => $request->input('kec'),
                'kota' => $request->input('kota'),
                'jabatan' => $request->input('kode_jabatan'),
                'photo' => $request->input('photo'),
                'no_hp' => $request->input('no_hp'),
                'no_ktp' => $request->input('no_ktp'),
                'tmk' => $request->input('tmk'),
                'tkk' => $request->input('tkk'),
                'status' => $request->input('status'),
            ]);

        // User::create($karyawan);

        return response()->json('Data Berhasil Disimpan',200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $data_karyawan = DB::table('tbl_karyawan')->where('nik',$id)->first();
        // $level = $data_karyawan->jabatan;

        // if ($level == 32) {
        //      $karyawan = DB::table('tbl_karyawan as b')
        //     ->leftJoin('tbl_jabatan as c', 'b.jabatan', 'c.kode_jabatan')
        //     ->leftJoin('users as d', 'b.nik', 'd.nik')
        //     ->where('b.nik', $id)
        //     ->select(
        //         'c.kode_jabatan',
        //         'c.nama_jabatan',
        //         'b.no_ktp',
        //         'b.nik',
        //         'b.nama',
        //         'b.alamat',
        //         'b.kec',
        //         'b.kota',
        //         'b.photo',
        //         'b.no_hp',
        //         'b.tmk',
        //         'b.tkk',
        //         'b.status',
        //     )
        //     ->first();
        // }
        // dd($level);

        
        $karyawan = DB::table('tbl_karyawan as b')
            ->leftJoin('tbl_group_marketing as a','a.nik_sales','b.nik')
            ->leftJoin('tbl_jabatan as c', 'b.jabatan', 'c.kode_jabatan')
            ->leftJoin('users as d', 'b.nik', 'd.nik')
            // ->where('a.nik_tm',Auth::user()->nik)
            ->where('b.nik', $id)
            ->select(
                'c.kode_jabatan',
                'c.nama_jabatan',
                'b.no_ktp',
                'b.nik',
                'b.nama',
                'b.alamat',
                'b.kec',
                'b.kota',
                'b.photo',
                'b.no_hp',
                'b.tmk',
                'b.tkk',
                'b.status',
                
                'a.nik_sales',
                'a.nama_sales',
                'a.nik_tm',
                'a.nama_tm',
                'a.nik_gtm',
                'a.nama_gtm',
                'a.nik_kdiv',
                'a.nama_kdiv',
            )
            ->first();
        return response()->json($karyawan);
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

        $jabatan = $request->input('kode_jabatan');

        // insert tbl_group
            if ($jabatan == 31) {
                DB::table('tbl_group_marketing')->where( 'nik',$id)
                ->update([
                    'nik_sales' => $request->input('nik_sales'),
                    'nama_sales' => $request->input('nama_sales'),
                    'nik_tm' => $request->input('nik_tm'),
                    'nama_tm' => $request->input('nama_tm'),
                    'nik_gtm' => $request->input('nik_gtm'),
                    'nama_gtm' => $request->input('nama_gtm'),
                    'nik_kdiv' => $request->input('nik_kdiv'),
                    'nama_kdiv' => $request->input('nama_kdiv'),
                ]);
            }
            if ($jabatan == 32) {
                $group = DB::table('tbl_group_marketing')->where( 'nik_tm',$id)->get();
                if ($group) {
                    DB::table('tbl_group_marketing')->where( 'nik',$id)
                    ->update([
                        'nik_tm' => $request->input('nik'),
                        'nama_tm' => $request->input('nama'),
                    ]);
                }
            }
            if ($jabatan == 23) {
                $group = DB::table('tbl_group_marketing')->where( 'nik_tm',$id)->get();
                if ($group) {
                    DB::table('tbl_group_marketing')->where( 'nik_gtm',$id)
                    ->update([
                        'nik_gtm' => $request->input('nik'),
                        'nama_gtm' => $request->input('nama'),
                    ]);
                }
            }
            if ($jabatan == 25) {
                $group = DB::table('tbl_group_marketing')->where( 'nik_tm',$id)->get();
                if ($group) {
                    DB::table('tbl_group_marketing')->where( 'nik_kdiv',$id)
                    ->update([
                        'nik_kdiv' => $request->input('nik'),
                        'nama_kdiv' => $request->input('nama'),
                    ]);
                }
            }

        // update ke table karyawan
            DB::table('tbl_karyawan')->where( 'nik',$id)
            ->update([
                'nik' => $request->input('nik'),
                'nama' => $request->input('nama'),
                'alamat' => $request->input('alamat'),
                'kec' => $request->input('kec'),
                'kota' => $request->input('kota'),
                'jabatan' => $request->input('kode_jabatan'),
                'photo' => $request->input('photo'),
                'no_hp' => $request->input('no_hp'),
                'no_ktp' => $request->input('no_ktp'),
                'tmk' => $request->input('tmk'),
                'tkk' => $request->input('tkk'),
                'status' => $request->input('status'),
            ]);


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
        $karyawan = DB::table('tbl_karyawan')->where( 'nik',$id);
        $karyawan->delete();

        return response(null,204);
    }

    public function group()
    {
        $group_marketing = DB::table('tbl_group_marketing')->get();
        return view('karyawan.group',compact('group_marketing'));
    }
}