<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MahasiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        if (auth()->user()->user_level == '2') {
            $mahasiswas = DB::table('mahasiswas')
                ->join('kurikulums', 'mhsKurId', '=', 'kurikulums.kurId')
                ->join('prodis', 'mhsProdiKode', '=', 'prodis.prodiKode')
                ->join('fakultas', 'prodis.prodiKodeFakultas', '=', 'fakultas.id')
                ->orderBy('mhsId')->paginate(9);

            $user = DB::table('pegawais')
                ->join('prodis', 'pegProdiKode', '=', 'prodis.prodiKode')
                ->join('fakultas', 'prodis.prodiKodeFakultas', '=', 'fakultas.id')
                ->where('pegawais.pegId', auth()->user()->nip)
                ->first();
            return view('admin.direktori.mahasiswa.index', ['user' => $user, 'mahasiswas' => $mahasiswas]);
        } else {
            return redirect('/home');
        }
    }
}
