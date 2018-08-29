<?php

namespace App\Http\Controllers;

use App\Dosen;
use App\Pegawai;
use App\Pengampu;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UbahPasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
        if (auth()->user()->user_level == '1'){
            $dosen = DB::table('dosens')
                ->join('prodis','dsnProdiKode','=','prodis.prodiKode')
                ->join('fakultas','prodis.prodiKodeFakultas','=','fakultas.id')
                ->where('dsnNip',auth()->user()->nip)
                ->first();
            return view('dosen.ubahPassword',['user'=>$dosen]);
        }

        elseif (auth()->user()->user_level =='2'){
            $pegawai = DB::table('pegawais')
                ->join('prodis','pegProdiKode','=','prodis.prodiKode')
                ->join('fakultas','prodis.prodiKodeFakultas','=','fakultas.id')
                ->where('pegawais.pegId',auth()->user()->nip)
                ->first();
            return view('admin.ubahPassword',['user'=>$pegawai]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    protected function update(Request $request, $id)
    {
        $this->validate($request,[
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::findOrFail($id);
        $user->password = Hash::make($request->input('password'));
        $user->save();

        return redirect('/home');
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
