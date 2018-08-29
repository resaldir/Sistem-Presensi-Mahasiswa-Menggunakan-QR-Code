<?php

namespace App\Http\Controllers;

use App\Kelas;
use App\Krs;
use App\MhsAktif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KrsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        if (auth()->user()->user_level == '2') {
            $krs = DB::table('krs')
                ->join('kelas', 'krsKlsId', '=', 'kelas.klsId')
                ->join('mtks', 'klsMtkId', '=', 'mtks.mtkId')
                ->join('mhs_aktifs', 'krsMhsAktifId', '=', 'mhs_aktifs.mhsAktifId')
                ->join('mahasiswas', 'mhs_aktifs.mhsAktifMhsId', '=', 'mahasiswas.mhsId')
                ->join('semesters', 'mhsAktifSemId', '=', 'semesters.semId')
                ->orderBy('mahasiswas.mhsId')->where('semIsAktif',1)->get();

            $user = DB::table('pegawais')
                ->join('prodis', 'pegProdiKode', '=', 'prodis.prodiKode')
                ->join('fakultas', 'prodis.prodiKodeFakultas', '=', 'fakultas.id')
                ->where('pegawais.pegId', auth()->user()->nip)
                ->first();
            return view('admin.direktori.krs.index', ['user' => $user, 'krss' => $krs]);
        } else {
            return redirect('/home');
        }
    }

    public function create()
    {
        if (auth()->user()->user_level == '2') {

            $mhsAktif = DB::table('mhs_aktifs')
                ->join('mahasiswas', 'mhsAktifMhsId', '=', 'mahasiswas.mhsId')
                ->join('semesters', 'mhsAktifSemId', '=', 'semesters.semId')
                ->orderBy('mahasiswas.mhsId')
                ->where('semIsAktif',1)->get();

            $select = [];
            foreach($mhsAktif as $mhs){
                $select[$mhs->mhsAktifId] = $mhs->mhsNama;
            }

            $kelas = DB::table('kelas')
                    ->join('mtks', 'klsMtkId', '=', 'mtks.mtkId')
                    ->join('semesters', 'klsSemId', '=', 'semesters.semId')
                    ->orderBy('mtks.mtkNama')
                    ->where('semIsAktif', 1)->get();


                $user = DB::table('pegawais')
                    ->join('prodis', 'pegProdiKode', '=', 'prodis.prodiKode')
                    ->join('fakultas', 'prodis.prodiKodeFakultas', '=', 'fakultas.id')
                    ->where('pegawais.pegId', auth()->user()->nip)
                    ->first();
                return view('admin.direktori.krs.create', ['user' => $user, 'select' => $select, 'kelas' => $kelas]);
            } else {
                return redirect('/home');
            }

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        $this->validate($request,[
//            'mhsAktifId'=>'required',
//        ]);

        foreach ($request->input("kls") as $kls){
            $krs = new Krs();
            $krs->krsMhsAktifId = $request->input('mhsAktifId');
            $krs->krsKlsId= $kls;
            $krs->save();
        }

        return redirect('/krs');
    }


    public function destroy($id)
    {
        $krs = Krs::find($id);
        $krs->delete();

        return redirect('/krs');
    }
}
