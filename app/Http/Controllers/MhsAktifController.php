<?php

namespace App\Http\Controllers;

use App\Mahasiswa;
use App\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MhsAktifController extends Controller
{ public function __construct()
{
    $this->middleware('auth');
}

    public function index()
    {

        if (auth()->user()->user_level == '2') {
            $mhs_aktifs = DB::table('mhs_aktifs')
                ->join('mahasiswas', 'mhsAktifMhsId', '=', 'mahasiswas.mhsId')
                ->join('kurikulums', 'mahasiswas.mhsKurId', '=', 'kurikulums.kurId')
                ->join('semesters', 'mhsAktifSemId', '=', 'semesters.semId')
                ->join('prodis', 'mahasiswas.mhsProdiKode', '=', 'prodis.prodiKode')
                ->join('fakultas', 'prodis.prodiKodeFakultas', '=', 'fakultas.id')
                ->orderBy('mhsId')->where('semIsAktif',1)->paginate(9);

            $user = DB::table('pegawais')
                ->join('prodis', 'pegProdiKode', '=', 'prodis.prodiKode')
                ->join('fakultas', 'prodis.prodiKodeFakultas', '=', 'fakultas.id')
                ->where('pegawais.pegId', auth()->user()->nip)
                ->first();
            return view('admin.direktori.mahasiswa-aktif.index', ['user' => $user, 'mhsAktifs' => $mhs_aktifs]);
        } else {
            return redirect('/home');
        }
    }

    public function detail(request $request,$id){
        if (auth()->user()->user_level == '2') {

            $mhs = DB::table('mahasiswas')->join('prodis', 'mhsProdiKode', '=', 'prodis.prodiKode')->where('mhsId',$id)->first();
            $krs = DB::table('krs')
                ->join('kelas', 'krsKlsId', '=', 'kelas.klsId')
                ->join('dosens', 'klsDsnNip', '=', 'dosens.dsnNip')
                ->join('mtks', 'klsMtkId', '=', 'mtks.mtkId')
                ->join('mhs_aktifs', 'krsMhsAktifId', '=', 'mhs_aktifs.mhsAktifId')
                ->join('mahasiswas', 'mhs_aktifs.mhsAktifMhsId', '=', 'mahasiswas.mhsId')
                ->join('semesters', 'kelas.klsSemId', '=', 'semesters.semId')
                ->orderBy('kelas.klsNama')->where('mhsAktifMhsId',$id)->where('semesters.semIsAktif',1)->get();

            $user = DB::table('pegawais')
                ->join('prodis', 'pegProdiKode', '=', 'prodis.prodiKode')
                ->join('fakultas', 'prodis.prodiKodeFakultas', '=', 'fakultas.id')
                ->where('pegawais.pegId', auth()->user()->nip)
                ->first();
            return view('admin.direktori.mahasiswa-aktif.krs', ['user' => $user, 'krss' => $krs,'mhs'=>$mhs]);
        } else {
            return redirect('/home');
        }
    }
}
