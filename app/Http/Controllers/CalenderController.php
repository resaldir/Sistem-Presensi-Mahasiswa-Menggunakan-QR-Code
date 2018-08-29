<?php

namespace App\Http\Controllers;

use App\Dosen;
use App\Event;
use App\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use MaddHatter\LaravelFullcalendar\Calendar;

class CalenderController extends Controller
{
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
            $dosen = DB::table('dosens')
                ->join('prodis','dsnProdiKode','=','prodis.prodiKode')
                ->join('fakultas','prodis.prodiKodeFakultas','=','fakultas.id')
                ->where('dsnNip',auth()->user()->nip)
                ->first();

            return view('dosen.calender',['user'=>$dosen]);
        }

        elseif (auth()->user()->user_level =='2'){
            $pegawai = DB::table('pegawais')
                ->join('prodis','pegProdiKode','=','prodis.prodiKode')
                ->join('fakultas','prodis.prodiKodeFakultas','=','fakultas.id')
                ->where('pegawais.pegId',auth()->user()->nip)
                ->first();


            return view('admin.calender',['user'=>$pegawai]);
        }
    }
}
