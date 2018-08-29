<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MtkController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

        if (auth()->user()->user_level == '2'){
            $mtks = DB::table('mtks')
                ->join('kurikulums','mtkKurId','=','kurikulums.kurId')
                ->join('prodis','kurikulums.kurProdiKode','=','prodis.prodiKode')
                ->join('fakultas','prodis.prodiKodeFakultas','=','fakultas.id')
                ->orderBy('mtkId')->orderBy('mtkSemester')->paginate(10);

            $user = DB::table('pegawais')
                ->join('prodis','pegProdiKode','=','prodis.prodiKode')
                ->join('fakultas','prodis.prodiKodeFakultas','=','fakultas.id')
                ->where('pegawais.pegId',auth()->user()->nip)
                ->first();
            return view('admin.direktori.mata-kuliah.index',['user'=>$user,'mtks'=>$mtks]);
        }

        else{
            return redirect('/home');
        }
    }
}
