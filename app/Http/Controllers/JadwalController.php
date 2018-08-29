<?php

namespace App\Http\Controllers;

use App\Dosen;
use App\Hari;
use App\Jadwal;
use App\Kelas;
use App\Ruangan;
use App\Semester;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;

class JadwalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        if (auth()->user()->user_level == '2') {
            $jadwals = DB::table('jadwals')
                ->join('kelas', 'jdwlKlsId', '=', 'kelas.klsId')
                ->join('dosens', 'kelas.klsDsnNip', '=', 'dosens.dsnNip')
                ->join('semesters', 'kelas.klsSemId', '=', 'semesters.semId')
                ->join('mtks', 'kelas.klsMtkId', '=', 'mtks.mtkId')
                ->join('ruangans', '.jdwlRuanganId', '=', 'ruangans.ruanganId')
                ->join('haris','jdwlHari','=','haris.hariId')
                ->orderBy('jdwlHari')->orderBy('jdwlSesiMulai')->orderBy('mtks.mtkId')->orderBy('kelas.klsNama')->where('semIsAktif',1)->get();

            $user = DB::table('pegawais')
                ->join('prodis', 'pegProdiKode', '=', 'prodis.prodiKode')
                ->join('fakultas', 'prodis.prodiKodeFakultas', '=', 'fakultas.id')
                ->where('pegawais.pegId', auth()->user()->nip)
                ->first();
            return view('admin.jadwal.index', ['user' => $user, 'jadwals' => $jadwals]);

        } elseif (auth()->user()->user_level == '1') {

            $jadwals = DB::table('jadwals')
                ->join('kelas', 'jdwlKlsId', '=', 'kelas.klsId')
                ->join('dosens', 'kelas.klsDsnNip', '=', 'dosens.dsnNip')
                ->join('semesters', 'kelas.klsSemId', '=', 'semesters.semId')
                ->join('mtks', 'kelas.klsMtkId', '=', 'mtks.mtkId')
                ->join('ruangans', '.jdwlRuanganId', '=', 'ruangans.ruanganId')
                ->join('haris','jdwlHari','=','haris.hariId')
                ->orderBy('jdwlHari')->orderBy('jdwlSesiMulai')->where('semIsAktif',1)->where('klsDsnNip',auth()->user()->nip)->get();

            $user = DB::table('dosens')
                ->join('prodis','dsnProdiKode','=','prodis.prodiKode')
                ->join('fakultas','prodis.prodiKodeFakultas','=','fakultas.id')
                ->where('dsnNip',auth()->user()->nip)
                ->first();
            return view('dosen.jadwal.index',['user'=>$user, 'jadwals' => $jadwals]);
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
            $haris = Hari::pluck('hariNama','hariId');
            $ruangans = Ruangan::pluck('ruanganKode','ruanganId');

            $kelas= DB::table('kelas')
                ->join('semesters', 'klsSemId', '=', 'semesters.semId')
                ->join('mtks','klsMtkId','=','mtks.mtkId')
                ->where('semIsAktif',1)->pluck('mtkNama','klsId')
                ->sortBy('mtks.mtkNama')->sortBy('kelas.klsNama');

            $user = DB::table('pegawais')
                ->join('prodis', 'pegProdiKode', '=', 'prodis.prodiKode')
                ->join('fakultas', 'prodis.prodiKodeFakultas', '=', 'fakultas.id')
                ->where('pegawais.pegId', auth()->user()->nip)
                ->first();
            return view('admin.jadwal.create', ['user' => $user, 'haris' => $haris,'ruangans'=>$ruangans,'kelas'=>$kelas]);
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
//            'jdwlKlsId'=>'required',
//            'jdwlSesiMulai'=>'required',
//            'jdwlSesiSelesai'=>'required',
//            'jdwlHari'=>'required',
//            'jdwlRuanganId'=>'required',
//        ]);

        $semAktif = Semester::all()->where('semIsAktif',1)->first();

        $jadwal = new Jadwal;
        $jadwal->jdwlKlsId = $request->input('klsId');
        $jadwal->jdwlRuanganId = $request->input('ruanganId');
        $jadwal->jdwlHari = $request->input('hariId');
        $jadwal->jdwlSesiMulai = $request->input('sesiMulai');
        $jadwal->jdwlSesiSelesai =$request->input('sesiSelesai');
        $jadwal->jdwlSemId = $semAktif->semId;
        $jadwal->save();

        return redirect('/jadwal');
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
        if (auth()->user()->user_level == '2') {
            $haris = Hari::pluck('hariNama', 'hariId');
            $ruangans = Ruangan::pluck('ruanganKode', 'ruanganId');
            $kelas = DB::table('kelas')
                ->join('mtks', 'klsMtkId', '=', 'mtks.mtkId')
                ->pluck('mtkNama', 'klsId')->sortBy('mtks.mtkNama')->sortBy('kelas.klsNama');

            $jadwal = DB::table('jadwals')
                ->join('kelas', 'jdwlKlsId', '=', 'kelas.klsId')
                ->join('dosens', 'kelas.klsDsnNip', '=', 'dosens.dsnNip')
                ->join('semesters', 'kelas.klsSemId', '=', 'semesters.semId')
                ->join('mtks', 'kelas.klsMtkId', '=', 'mtks.mtkId')
                ->join('ruangans', '.jdwlRuanganId', '=', 'ruangans.ruanganId')
                ->join('haris', 'jdwlHari', '=', 'haris.hariId')->where('jadwals.jdwlId', $id)->first();


            $user = DB::table('pegawais')
                ->join('prodis', 'pegProdiKode', '=', 'prodis.prodiKode')
                ->join('fakultas', 'prodis.prodiKodeFakultas', '=', 'fakultas.id')
                ->where('pegawais.pegId', auth()->user()->nip)
                ->first();
            return view('admin.jadwal.edit', ['user' => $user, 'haris' => $haris, 'ruangans' => $ruangans, 'kelas' => $kelas, 'jadwal' => $jadwal]);
        } else {
            if (auth()->user()->user_level == '1') {
                $haris = Hari::pluck('hariNama', 'hariId');
                $ruangans = Ruangan::pluck('ruanganKode', 'ruanganId');
                $kelas = DB::table('kelas')
                    ->join('mtks', 'klsMtkId', '=', 'mtks.mtkId')
                    ->pluck('mtkNama', 'klsId')->sortBy('mtks.mtkNama')->sortBy('kelas.klsNama');

                $jadwal = DB::table('jadwals')
                    ->join('kelas', 'jdwlKlsId', '=', 'kelas.klsId')
                    ->join('dosens', 'kelas.klsDsnNip', '=', 'dosens.dsnNip')
                    ->join('semesters', 'kelas.klsSemId', '=', 'semesters.semId')
                    ->join('mtks', 'kelas.klsMtkId', '=', 'mtks.mtkId')
                    ->join('ruangans', '.jdwlRuanganId', '=', 'ruangans.ruanganId')
                    ->join('haris', 'jdwlHari', '=', 'haris.hariId')->where('jadwals.jdwlId', $id)->first();


                $user = DB::table('dosens')
                    ->join('prodis','dsnProdiKode','=','prodis.prodiKode')
                    ->join('fakultas','prodis.prodiKodeFakultas','=','fakultas.id')
                    ->where('dsnNip',auth()->user()->nip)
                    ->first();
                return view('dosen.jadwal.edit', ['user' => $user, 'haris' => $haris, 'ruangans' => $ruangans, 'kelas' => $kelas, 'jadwal' => $jadwal]);

            }
        }
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
        if (auth()->user()->user_level == '2' || auth()->user()->user_level == '1'){
            $jadwal = Jadwal::find($id);
            $jadwal->jdwlRuanganId = $request->input('ruanganId');
            $jadwal->jdwlHari = $request->input('hariId');
            $jadwal->jdwlSesiMulai = $request->input('sesiMulai');
            $jadwal->jdwlSesiSelesai =$request->input('sesiSelesai');
            $jadwal->save();
            return redirect('/jadwal');
        }
        else{
            return redirect('/home');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (auth()->user()->user_level == '2') {
            $jadwal = Jadwal::find($id);
            $jadwal->delete();

            return redirect('/jadwal');

        } else {

            return redirect('/home');
        }

    }

    public function cetak(){
        ini_set('max_execution_time', 300);

        if (auth()->user()->user_level == '2') {

            $semNow = DB::table('semesters')->where('semIsAktif',1)->first();
            $jadwals = DB::table('jadwals')
                ->join('kelas', 'jdwlKlsId', '=', 'kelas.klsId')
                ->join('dosens', 'kelas.klsDsnNip', '=', 'dosens.dsnNip')
                ->join('semesters', 'kelas.klsSemId', '=', 'semesters.semId')
                ->join('mtks', 'kelas.klsMtkId', '=', 'mtks.mtkId')
                ->join('ruangans', '.jdwlRuanganId', '=', 'ruangans.ruanganId')
                ->join('haris','jdwlHari','=','haris.hariId')
                ->orderBy('jdwlHari')->orderBy('jdwlSesiMulai')->orderBy('mtks.mtkId')->orderBy('kelas.klsNama')->where('semIsAktif',1)->get();

            $user = DB::table('pegawais')
                ->join('prodis', 'pegProdiKode', '=', 'prodis.prodiKode')
                ->join('fakultas', 'prodis.prodiKodeFakultas', '=', 'fakultas.id')
                ->where('pegawais.pegId', auth()->user()->nip)
                ->first();

            $pdf = PDF::loadView('admin.jadwal.print',['user' => $user, 'jadwals' => $jadwals,'sem'=>$semNow])->setPaper('a4', 'landscape');
            return $pdf->stream('jadwal kuliah.pdf');

        } elseif (auth()->user()->user_level == '1') {
            $semNow = DB::table('semesters')->where('semIsAktif',1)->first();
            $dsn = DB::table('dosens')->where('dsnNip',auth()->user()->nip)->first();
            $jadwals = DB::table('jadwals')
                ->join('kelas', 'jdwlKlsId', '=', 'kelas.klsId')
                ->join('dosens', 'kelas.klsDsnNip', '=', 'dosens.dsnNip')
                ->join('semesters', 'kelas.klsSemId', '=', 'semesters.semId')
                ->join('mtks', 'kelas.klsMtkId', '=', 'mtks.mtkId')
                ->join('ruangans', '.jdwlRuanganId', '=', 'ruangans.ruanganId')
                ->join('haris','jdwlHari','=','haris.hariId')
                ->orderBy('jdwlHari')->orderBy('jdwlSesiMulai')->where('semIsAktif',1)->where('klsDsnNip',auth()->user()->nip)->get();

            $user = DB::table('dosens')
                ->join('prodis','dsnProdiKode','=','prodis.prodiKode')
                ->join('fakultas','prodis.prodiKodeFakultas','=','fakultas.id')
                ->where('dsnNip',auth()->user()->nip)
                ->first();
            $pdf = PDF::loadView('dosen.jadwal.print',['user' => $user, 'jadwals' => $jadwals,'sem'=>$semNow,'dsn'=>$dsn])->setPaper('a4', 'landscape');
            return $pdf->stream('jadwal kuliah.pdf');
        }
    }
}
