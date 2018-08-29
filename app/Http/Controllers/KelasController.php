<?php

namespace App\Http\Controllers;

use App\Dosen;
use App\Kelas;
use App\Mtk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KelasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        if (auth()->user()->user_level == '2') {
            $kelas = DB::table('kelas')
                ->join('dosens', 'klsDsnNip', '=', 'dosens.dsnNip')
                ->join('semesters', 'klsSemId', '=', 'semesters.semId')
                ->join('mtks', 'klsMtkId', '=', 'mtks.mtkId')
                ->join('kurikulums', 'mtks.mtkKurId', '=', 'kurikulums.kurId')
                ->orderBy('mtks.mtkId')->orderBy('kelas.klsNama')->where('semIsAktif',1)->paginate(10);

            $user = DB::table('pegawais')
                ->join('prodis', 'pegProdiKode', '=', 'prodis.prodiKode')
                ->join('fakultas', 'prodis.prodiKodeFakultas', '=', 'fakultas.id')
                ->where('pegawais.pegId', auth()->user()->nip)
                ->first();
            return view('admin.direktori.kelas.index', ['user' => $user, 'kelas' => $kelas]);
        } else {
            return redirect('/home');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (auth()->user()->user_level == '2') {
            $dosens = Dosen::pluck('dsnNama','dsnNip');
            $mtks = Mtk::pluck('mtkNama','mtkId');

            $user = DB::table('pegawais')
                ->join('prodis', 'pegProdiKode', '=', 'prodis.prodiKode')
                ->join('fakultas', 'prodis.prodiKodeFakultas', '=', 'fakultas.id')
                ->where('pegawais.pegId', auth()->user()->nip)
                ->first();
            return view('admin.direktori.kelas.create', ['user' => $user, 'dosens' => $dosens,'mtks'=>$mtks]);
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
        $this->validate($request,[
            'klsDsnNip'=>'required',
            'klsMtkId'=>'required',
        ]);

        $semester = DB::table('semesters')->where('semIsAktif','1')->first();

        $mtk = DB::table('mtks')->where('mtkId',$request->input('klsMtkId'))->first();

        $jmlhPer = $mtk->mtkTeoriSks*8;

        $klsSemId = $semester->semId;

        //check kelas sudah ada atau tidak
        $banyakKelas = Kelas::all()->where('klsMtkId',$request->input('klsMtkId'))->count();

        if ($banyakKelas > 0){

            if ($banyakKelas == 1){
                $kelasA = DB::table('kelas')->where('klsMtkId',$request->input('klsMtkId'))->first();
                $kelas = Kelas::find($kelasA->klsId);
                $kelas->klsNama = 1;
                $kelas->save();
            }

            $kelas = new Kelas;
            $kelas->klsSemId = $klsSemId;
            $kelas->klsMtkId = $request->input('klsMtkId');
            $kelas->klsDsnNip = $request->input('klsDsnNip');
            $kelas->klsNama = $banyakKelas+1;
            $kelas->klsId =$kelas->klsMtkId.$kelas->klsNama.$kelas->klsSemId;
            $kelas->klsJumlahPer = $jmlhPer;
            $kelas->save();

        }else{
            $kelas = new Kelas;
            $kelas->klsSemId = $klsSemId;
            $kelas->klsMtkId = $request->input('klsMtkId');
            $kelas->klsDsnNip = $request->input('klsDsnNip');
            $kelas->klsNama = 0;
            $kelas->klsId =$kelas->klsMtkId.$kelas->klsNama.$kelas->klsSemId;
            $kelas->klsJumlahPer = $jmlhPer;
            $kelas->save();

        }


        return redirect('/kelas');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kelas = Kelas::find($id);
        $kelas->delete();

        return redirect('/kelas');
    }

    public function detail(request $request,$id){
        if (auth()->user()->user_level == '2') {

            $kls = DB::table('kelas')
                ->join('dosens', 'klsDsnNip', '=', 'dosens.dsnNip')
                ->join('prodis', 'dsnProdiKode', '=', 'prodis.prodiKode')
                ->join('mtks', 'klsMtkId', '=', 'mtks.mtkId')
                ->where('klsId',$id)->first();

            $krs = DB::table('krs')
                ->join('kelas', 'krsKlsId', '=', 'kelas.klsId')
                ->join('dosens', 'klsDsnNip', '=', 'dosens.dsnNip')
                ->join('mtks', 'klsMtkId', '=', 'mtks.mtkId')
                ->join('mhs_aktifs', 'krsMhsAktifId', '=', 'mhs_aktifs.mhsAktifId')
                ->join('mahasiswas', 'mhs_aktifs.mhsAktifMhsId', '=', 'mahasiswas.mhsId')
                ->join('semesters', 'kelas.klsSemId', '=', 'semesters.semId')
                ->orderBy('mhs_aktifs.mhsAktifMhsId')->where('krsKlsId',$id)->where('semesters.semIsAktif',1)->get();

            $user = DB::table('pegawais')
                ->join('prodis', 'pegProdiKode', '=', 'prodis.prodiKode')
                ->join('fakultas', 'prodis.prodiKodeFakultas', '=', 'fakultas.id')
                ->where('pegawais.pegId', auth()->user()->nip)
                ->first();
            return view('admin.direktori.kelas.krs', ['user' => $user, 'krss' => $krs,'kls'=>$kls]);
        } else {
            return redirect('/home');
        }
    }
}
