<?php

namespace App\Http\Controllers;

use App\Models\User;
use GrahamCampbell\ResultType\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function data(Request $request)
    {
        $filter = $request->input('name');

        $user = DB::table('users as a')
        ->Join('tbl_jabatan as b', 'a.level', 'b.kode_jabatan')->get();

        if ($filter != null) {
            $user = DB::table('users as a')
        ->Join('tbl_jabatan as b', 'a.level', 'b.kode_jabatan')
        ->where('name','like', '%' . $filter . '%');
        }

        return datatables()::of($user)
            ->addIndexColumn()
            ->addColumn('aksi', function($user){
                return '
                    <button onclick="editform(`'. route('user.update',$user->nik) .'`)" class="btn btn-info btn-xs">Edit</button>
                    <button onclick="deleteform(`'. route('user.destroy',$user->nik) .'`)" class="btn btn-danger btn-xs">Hapus</button>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function index()
    {
        $jabatan = DB::table('tbl_jabatan')->get();
        return view('user.index',compact('jabatan'));
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
        $user = $request->all();
        $pass = $user['password'];
        $user['password'] = Hash::make($request->input('password'));
        User::create($user);
        
        // pass
        $user_ = User::where('username',$user['username']);
        $user_->update(['pass'=>$pass]);

        return redirect()->route('user.index');
        // return response()->json('Data Berhasil Disimpan',200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
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
        $data = $request->all();
        $user = User::find($id);
        $pass = $data['password'];
        
        $data['password'] = Hash::make($request->input('password'));


        $user->update(['pass'=>$pass]);
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
        $user = User::findOrFail($id);
        $user->delete();

        return response(null,204);
    }
}