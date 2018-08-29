<?php

namespace App\Http\Controllers;

use App\Dosen;
use App\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->user_level == '1'){
            $kelas = DB::table('kelas')
                ->join('dosens','klsDsnNip','=','dsnNip')
                ->join('mtks','klsMtkId','=','mtkId')
                ->join('semesters','klsSemId','=','semId')
                ->join('totalqrcodes','klsId','=','totKlsId')
                ->orderBy('mtkId')->orderBy('klsNama')
                ->where('semIsAktif',1)->where('dsnNip',auth()->user()->nip)->get();

            $user = DB::table('dosens')
                ->join('prodis','dsnProdiKode','=','prodis.prodiKode')
                ->join('fakultas','prodis.prodiKodeFakultas','=','fakultas.id')
                ->where('dsnNip',auth()->user()->nip)
                ->first();
            return view('dosen.main',['user'=>$user,'kelas'=>$kelas]);
        }

        elseif (auth()->user()->user_level =='2'){
           $kelas = DB::table('kelas')
               ->join('dosens','klsDsnNip','=','dsnNip')
               ->join('mtks','klsMtkId','=','mtkId')
               ->join('semesters','klsSemId','=','semId')
               ->join('totalqrcodes','klsId','=','totKlsId')
               ->orderBy('mtkId')->orderBy('klsNama')
               ->where('semIsAktif',1)->get();

            $user = DB::table('pegawais')
                ->join('prodis','pegProdiKode','=','prodis.prodiKode')
                ->join('fakultas','prodis.prodiKodeFakultas','=','fakultas.id')
                ->where('pegawais.pegId',auth()->user()->nip)
                ->first();
            return view('admin.main',['user'=>$user,'kelas'=>$kelas]);
        }elseif (auth()->user()->user_level =='3'){

            return view('welcome');
        }
    }



}
