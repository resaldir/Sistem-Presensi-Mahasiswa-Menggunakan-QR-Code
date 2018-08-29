<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DosenController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

        if (auth()->user()->user_level == '2'){
            $dosens = DB::table('dosens')
                ->join('prodis','dsnProdiKode','=','prodis.prodiKode')
                ->join('fakultas','prodis.prodiKodeFakultas','=','fakultas.id')
                ->orderBy('dsnNip') ->paginate(6);

            $user = DB::table('pegawais')
                ->join('prodis','pegProdiKode','=','prodis.prodiKode')
                ->join('fakultas','prodis.prodiKodeFakultas','=','fakultas.id')
                ->where('pegawais.pegId',auth()->user()->nip)
                ->first();
            return view('admin.direktori.dosen.index',['user'=>$user,'dosens'=>$dosens]);
        }

        else{
            return redirect('/home');
        }
    }
}
