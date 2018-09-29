<?php

namespace App\Http\Controllers;

use App\Dosen;
use App\Izin;
use App\Pegawai;
use App\Presensi;
use App\Qrcode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Storage;

class PresensiController extends Controller
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
    public function index(request $request)
    {
        if (auth()->user()->user_level == '1'){
            $kelas = DB::table('kelas')
                ->join('mtks','klsMtkId','=','mtkId')
                ->join('dosens','kelas.klsDsnNip','=','dsnNip')
                ->join('semesters','kelas.klsSemId','=','semId')
                ->where('klsId',$request->input('klsId'))->first();

            $krs = DB::table('krs')
                ->join('kelas', 'krsKlsId', '=', 'kelas.klsId')
                ->join('mhs_aktifs', 'krsMhsAktifId', '=', 'mhs_aktifs.mhsAktifId')
                ->join('mahasiswas', 'mhs_aktifs.mhsAktifMhsId', '=', 'mahasiswas.mhsId')
                ->orderBy('mahasiswas.mhsAngkatan')
                ->orderBy('mhsId')->where('krsKlsId',$request->input('klsId'))->get();

            $code = Qrcode::all()->where('qrcodeKlsId',$request->input('klsId'))->sortBy('qrcodePertemuan');
            $col = $code->count();

            $presensi = DB::table('presensis')
                ->join('kelas','presensiKlsId','=','kelas.klsId')
                ->rightJoin('krs','presensis.presensiKrsId','=','krsId')
                ->join('mhs_aktifs','krs.krsMhsAktifId','=','mhsAktifId')
                ->join('mahasiswas','mhs_aktifs.mhsAktifMhsId','=','mhsId')
                ->join('qrcodes','presensis.presensiQrcodeKode','=','qrcodeKode')
                ->where('presensiKlsId',$request->input('klsId'))->orderBy('qrcodePertemuan')
                ->orderBy('mahasiswas.mhsAngkatan')->orderBy('mahasiswas.mhsId')->get();


            $dosen = DB::table('dosens')
                ->join('prodis','dsnProdiKode','=','prodis.prodiKode')
                ->join('fakultas','prodis.prodiKodeFakultas','=','fakultas.id')
                ->where('dsnNip',auth()->user()->nip)
                ->first();
            return view('dosen.presensi.index',['user'=>$dosen,'presensi'=>$presensi,'col'=>$col,'kelas'=>$kelas,'krss'=>$krs,'code'=>$code]);
        }

        elseif (auth()->user()->user_level =='2'){

            $kelas = DB::table('kelas')
                ->join('mtks','klsMtkId','=','mtkId')
                ->join('dosens','kelas.klsDsnNip','=','dsnNip')
                ->join('semesters','kelas.klsSemId','=','semId')
                ->where('klsId',$request->input('klsId'))->first();

            $krs = DB::table('krs')
                ->join('kelas', 'krsKlsId', '=', 'kelas.klsId')
                ->join('mhs_aktifs', 'krsMhsAktifId', '=', 'mhs_aktifs.mhsAktifId')
                ->join('mahasiswas', 'mhs_aktifs.mhsAktifMhsId', '=', 'mahasiswas.mhsId')
                ->orderBy('mahasiswas.mhsAngkatan')
                ->orderBy('mhsId')->where('krsKlsId',$request->input('klsId'))->get();

            $code = Qrcode::all()->where('qrcodeKlsId',$request->input('klsId'))->sortBy('qrcodePertemuan');
            $col = $code->count();

            $presensi = DB::table('presensis')
                ->join('kelas','presensiKlsId','=','kelas.klsId')
                ->rightJoin('krs','presensis.presensiKrsId','=','krsId')
                ->join('mhs_aktifs','krs.krsMhsAktifId','=','mhsAktifId')
                ->join('mahasiswas','mhs_aktifs.mhsAktifMhsId','=','mhsId')
                ->join('qrcodes','presensis.presensiQrcodeKode','=','qrcodeKode')
                ->where('presensiKlsId',$request->input('klsId'))->orderBy('qrcodePertemuan')
                ->orderBy('mahasiswas.mhsAngkatan')->orderBy('mahasiswas.mhsId')->get();



            $pegawai = DB::table('pegawais')
                ->join('prodis','pegProdiKode','=','prodis.prodiKode')
                ->join('fakultas','prodis.prodiKodeFakultas','=','fakultas.id')
                ->where('pegawais.pegId',auth()->user()->nip)
                ->first();
            return view('admin.presensi.index',['user'=>$pegawai,'presensi'=>$presensi,'col'=>$col,'kelas'=>$kelas,'krss'=>$krs,'code'=>$code]);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function izin($kelas, $pertemuan, $token)
    {
        return view('izin-form',['kelas'=>$kelas,'pertemuan'=>$pertemuan,'token'=>$token]);

    }

    public function pesan($pesan)
    {
        return view('pesan',['pesan'=>$pesan]);

    }


    public function show($id)
    {
        if (auth()->user()->user_level == '1'){
            $kelas = DB::table('kelas')
                ->join('mtks','klsMtkId','=','mtkId')
                ->join('dosens','kelas.klsDsnNip','=','dsnNip')
                ->join('semesters','kelas.klsSemId','=','semId')
                ->where('klsId',$id)->first();

            $krs = DB::table('krs')
                ->join('kelas', 'krsKlsId', '=', 'kelas.klsId')
                ->join('mhs_aktifs', 'krsMhsAktifId', '=', 'mhs_aktifs.mhsAktifId')
                ->join('mahasiswas', 'mhs_aktifs.mhsAktifMhsId', '=', 'mahasiswas.mhsId')
                ->orderBy('mahasiswas.mhsAngkatan')
                ->orderBy('mhsId')->where('krsKlsId',$id)->get();

            $code = Qrcode::all()->where('qrcodeKlsId',$id)->sortBy('qrcodePertemuan');
            $col = $code->count();

            $presensi = DB::table('presensis')
                ->join('kelas','presensiKlsId','=','kelas.klsId')
                ->rightJoin('krs','presensis.presensiKrsId','=','krsId')
                ->join('mhs_aktifs','krs.krsMhsAktifId','=','mhsAktifId')
                ->join('mahasiswas','mhs_aktifs.mhsAktifMhsId','=','mhsId')
                ->join('qrcodes','presensis.presensiQrcodeKode','=','qrcodeKode')
                ->where('presensiKlsId',$id)->orderBy('qrcodePertemuan')
                ->orderBy('mahasiswas.mhsAngkatan')->orderBy('mahasiswas.mhsId')->get();

            $dosen = DB::table('dosens')
                ->join('prodis','dsnProdiKode','=','prodis.prodiKode')
                ->join('fakultas','prodis.prodiKodeFakultas','=','fakultas.id')
                ->where('dsnNip',auth()->user()->nip)
                ->first();
            return view('dosen.presensi.index',['user'=>$dosen,'presensi'=>$presensi,'col'=>$col,'kelas'=>$kelas,'krss'=>$krs,'code'=>$code]);
        }

        elseif (auth()->user()->user_level =='2'){

            $kelas = DB::table('kelas')
                ->join('mtks','klsMtkId','=','mtkId')
                ->join('dosens','kelas.klsDsnNip','=','dsnNip')
                ->join('semesters','kelas.klsSemId','=','semId')
                ->where('klsId',$id)->first();

            $krs = DB::table('krs')
                ->join('kelas', 'krsKlsId', '=', 'kelas.klsId')
                ->join('mhs_aktifs', 'krsMhsAktifId', '=', 'mhs_aktifs.mhsAktifId')
                ->join('mahasiswas', 'mhs_aktifs.mhsAktifMhsId', '=', 'mahasiswas.mhsId')
                ->orderBy('mahasiswas.mhsAngkatan')
                ->orderBy('mhsId')->where('krsKlsId',$id)->get();

            $code = Qrcode::all()->where('qrcodeKlsId',$id)->sortBy('qrcodePertemuan');
            $col = $code->count();

            $presensi = DB::table('presensis')
                ->join('kelas','presensiKlsId','=','kelas.klsId')
                ->rightJoin('krs','presensis.presensiKrsId','=','krsId')
                ->join('mhs_aktifs','krs.krsMhsAktifId','=','mhsAktifId')
                ->join('mahasiswas','mhs_aktifs.mhsAktifMhsId','=','mhsId')
                ->join('qrcodes','presensis.presensiQrcodeKode','=','qrcodeKode')
                ->where('presensiKlsId',$id)->orderBy('qrcodePertemuan')
                ->orderBy('mahasiswas.mhsAngkatan')->orderBy('mahasiswas.mhsId')->get();



            $pegawai = DB::table('pegawais')
                ->join('prodis','pegProdiKode','=','prodis.prodiKode')
                ->join('fakultas','prodis.prodiKodeFakultas','=','fakultas.id')
                ->where('pegawais.pegId',auth()->user()->nip)
                ->first();
            return view('admin.presensi.index',['user'=>$pegawai,'presensi'=>$presensi,'col'=>$col,'kelas'=>$kelas,'krss'=>$krs,'code'=>$code]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function izinShow($id)
    {
        if (auth()->user()->user_level =='2'){
            $izin = DB::table('izins')
                ->join('presensis','izinPresensiId','=','presensiId')
                ->join('kelas','presensiKlsId','=','kelas.klsId')
                ->join('mtks','klsMtkId','=','mtkId')
                ->rightJoin('krs','presensis.presensiKrsId','=','krsId')
                ->join('mhs_aktifs','krs.krsMhsAktifId','=','mhsAktifId')
                ->join('mahasiswas','mhs_aktifs.mhsAktifMhsId','=','mhsId')
                ->join('qrcodes','presensis.presensiQrcodeKode','=','qrcodeKode')
                ->where('izinPresensiId',$id)->first();

            $pegawai = DB::table('pegawais')
                ->join('prodis','pegProdiKode','=','prodis.prodiKode')
                ->join('fakultas','prodis.prodiKodeFakultas','=','fakultas.id')
                ->where('pegawais.pegId',auth()->user()->nip)
                ->first();
            return view('admin.presensi.edit',['user'=>$pegawai,'izin'=>$izin]);
        } else{
            return redirect('/home');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateIzinY(Request $request, $id)
    {
        if (auth()->user()->user_level == '2') {
            $kelas = DB::table('izins')
                ->join('presensis','izinPresensiId','=','presensiId')
                ->where('izinPresensiId',$id)->first();

            $presensi = Presensi::find($id);
            $presensi->presensiStatus = 1;
            $presensi->save();

            $izin = Izin::find($kelas->izinId);
            $izinName = $izin->izinFileName;;

            unlink(storage_path('app/public/izin/'.$izinName));

            $izin->delete();

            return redirect('/presensi/'.$kelas->presensiKlsId);
        } else {
            return redirect('/home');
        }
    }

    public function updateIzinN(Request $request, $id)
    {
        if (auth()->user()->user_level == '2') {
            $kelas = DB::table('izins')
                ->join('presensis','izinPresensiId','=','presensiId')
                ->where('izinPresensiId',$id)->first();

            $presensi = Presensi::find($id);
            $presensi->presensiStatus = 0;
            $presensi->save();

            $izin = Izin::find($kelas->izinId);
            $izinName = $izin->izinFileName;;

            unlink(storage_path('app/public/izin/'.$izinName));

            $izin->delete();

            return redirect('/presensi/'.$kelas->presensiKlsId);
        } else {
            return redirect('/home');
        }
    }


    public function search(){
        if (auth()->user()->user_level == '1'){
            $kelas= DB::table('kelas')
                ->join('semesters', 'klsSemId', '=', 'semesters.semId')
                ->join('mtks','klsMtkId','=','mtks.mtkId')->where('semIsAktif',1)
                ->where('klsDsnNip',auth()->user()->nip)
                ->pluck('mtkNama','klsId')->sortBy('mtks.mtkNama')->sortBy('kelas.klsNama');

            $dosen = DB::table('dosens')
                ->join('prodis','dsnProdiKode','=','prodis.prodiKode')
                ->join('fakultas','prodis.prodiKodeFakultas','=','fakultas.id')
                ->where('dsnNip',auth()->user()->nip)
                ->first();

            return view('dosen.presensi.search',['user'=>$dosen,'kelas'=>$kelas]);
        }

        elseif (auth()->user()->user_level =='2'){
            $kelas= DB::table('kelas')
                ->join('semesters', 'klsSemId', '=', 'semesters.semId')
                ->join('mtks','klsMtkId','=','mtks.mtkId')->where('semIsAktif',1)
                ->pluck('mtkNama','klsId')->sortBy('mtks.mtkNama')->sortBy('kelas.klsNama');

            $pegawai = DB::table('pegawais')
                ->join('prodis','pegProdiKode','=','prodis.prodiKode')
                ->join('fakultas','prodis.prodiKodeFakultas','=','fakultas.id')
                ->where('pegawais.pegId',auth()->user()->nip)
                ->first();
            return view('admin.presensi.search',['user'=>$pegawai,'kelas'=>$kelas]);
        }
    }

    public function cetak($id){

        ini_set('max_execution_time', 300);

        if (auth()->user()->user_level == '1'){
            $kelas = DB::table('kelas')
                ->join('mtks','klsMtkId','=','mtkId')
                ->join('dosens','kelas.klsDsnNip','=','dsnNip')
                ->join('semesters','kelas.klsSemId','=','semId')
                ->where('klsId',$id)->first();

            $krs = DB::table('krs')
                ->join('kelas', 'krsKlsId', '=', 'kelas.klsId')
                ->join('mhs_aktifs', 'krsMhsAktifId', '=', 'mhs_aktifs.mhsAktifId')
                ->join('mahasiswas', 'mhs_aktifs.mhsAktifMhsId', '=', 'mahasiswas.mhsId')
                ->orderBy('mahasiswas.mhsAngkatan')
                ->orderBy('mhsId')->where('krsKlsId',$id)->get();

            $code = Qrcode::all()->where('qrcodeKlsId',$id)->sortBy('qrcodePertemuan');
            $col = $code->count();

            $presensi = DB::table('presensis')
                ->join('kelas','presensiKlsId','=','kelas.klsId')
                ->rightJoin('krs','presensis.presensiKrsId','=','krsId')
                ->join('mhs_aktifs','krs.krsMhsAktifId','=','mhsAktifId')
                ->join('mahasiswas','mhs_aktifs.mhsAktifMhsId','=','mhsId')
                ->join('qrcodes','presensis.presensiQrcodeKode','=','qrcodeKode')
                ->where('presensiKlsId',$id)->orderBy('qrcodePertemuan')
                ->orderBy('mahasiswas.mhsAngkatan')->orderBy('mahasiswas.mhsId')->get();




            $pdf = PDF::loadView('dosen.presensi.print',['presensi'=>$presensi,'col'=>$col,'kelas'=>$kelas,'krss'=>$krs,'code'=>$code])->setPaper('a4', 'landscape');
            return $pdf->stream('daftar presensi mahasiswa'.$kelas->mtkNama.'.pdf');
        }

        elseif (auth()->user()->user_level =='2'){
            $kelas = DB::table('kelas')
                ->join('mtks','klsMtkId','=','mtkId')
                ->join('dosens','kelas.klsDsnNip','=','dsnNip')
                ->join('semesters','kelas.klsSemId','=','semId')
                ->where('klsId',$id)->first();

            $krs = DB::table('krs')
                ->join('kelas', 'krsKlsId', '=', 'kelas.klsId')
                ->join('mhs_aktifs', 'krsMhsAktifId', '=', 'mhs_aktifs.mhsAktifId')
                ->join('mahasiswas', 'mhs_aktifs.mhsAktifMhsId', '=', 'mahasiswas.mhsId')
                ->orderBy('mahasiswas.mhsAngkatan')
                ->orderBy('mhsId')->where('krsKlsId',$id)->get();

            $code = Qrcode::all()->where('qrcodeKlsId',$id)->sortBy('qrcodePertemuan');
            $col = $code->count();

            $presensi = DB::table('presensis')
                ->join('kelas','presensiKlsId','=','kelas.klsId')
                ->rightJoin('krs','presensis.presensiKrsId','=','krsId')
                ->join('mhs_aktifs','krs.krsMhsAktifId','=','mhsAktifId')
                ->join('mahasiswas','mhs_aktifs.mhsAktifMhsId','=','mhsId')
                ->join('qrcodes','presensis.presensiQrcodeKode','=','qrcodeKode')
                ->where('presensiKlsId',$id)->orderBy('qrcodePertemuan')
                ->orderBy('mahasiswas.mhsAngkatan')->orderBy('mahasiswas.mhsId')->get();


            $pdf = PDF::loadView('admin.presensi.print',['presensi'=>$presensi,'col'=>$col,'kelas'=>$kelas,'krss'=>$krs,'code'=>$code])->setPaper('a4', 'landscape');
            return $pdf->stream('daftar presensi mahasiswa'.$kelas->mtkNama.'.pdf');
        }

    }
}
