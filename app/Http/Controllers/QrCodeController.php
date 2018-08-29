<?php

namespace App\Http\Controllers;

use App\Dosen;
use App\Pegawai;
use App\Presensi;
use App\Qrcode;
use App\Totalqrcode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use function Sodium\increment;
use Barryvdh\DomPDF\Facade as PDF;

class QrCodeController extends Controller
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
            $klss = DB::table('kelas')
                ->join('totalqrcodes','klsId','=','totalqrcodes.totKlsId')
                ->join('dosens', 'klsDsnNip', '=', 'dosens.dsnNip')
                ->join('semesters', 'klsSemId', '=', 'semesters.semId')
                ->join('mtks', 'klsMtkId', '=', 'mtks.mtkId')
                ->join('kurikulums', 'mtks.mtkKurId', '=', 'kurikulums.kurId')
                ->orderBy('mtks.mtkId')->orderBy('kelas.klsNama')
                ->where('dsnNip',auth()->user()->nip)->where('semIsAktif',1)->get();

            $kelas= DB::table('kelas')
                ->join('semesters', 'klsSemId', '=', 'semesters.semId')
                ->join('mtks','klsMtkId','=','mtks.mtkId')->where('semIsAktif',1)->where('kelas.klsDsnNip',auth()->user()->nip)
                ->pluck('mtkNama','klsId')->sortBy('mtks.mtkNama')->sortBy('kelas.klsNama');

            $dosen = DB::table('dosens')
                ->join('prodis','dsnProdiKode','=','prodis.prodiKode')
                ->join('fakultas','prodis.prodiKodeFakultas','=','fakultas.id')
                ->where('dsnNip',auth()->user()->nip)
                ->first();
            return view('dosen.qrcode.index',['user'=>$dosen,'kelas'=>$kelas,'klss'=>$klss]);
        }

        elseif (auth()->user()->user_level =='2'){

            $klss = DB::table('kelas')
                ->join('totalqrcodes','klsId','=','totalqrcodes.totKlsId')
                ->join('dosens', 'klsDsnNip', '=', 'dosens.dsnNip')
                ->join('semesters', 'klsSemId', '=', 'semesters.semId')
                ->join('mtks', 'klsMtkId', '=', 'mtks.mtkId')
                ->join('kurikulums', 'mtks.mtkKurId', '=', 'kurikulums.kurId')
                ->orderBy('mtks.mtkId')->orderBy('kelas.klsNama')->where('semIsAktif',1)->get();

            $kelas= DB::table('kelas')
                ->join('semesters', 'klsSemId', '=', 'semesters.semId')
                ->join('mtks','klsMtkId','=','mtks.mtkId')->where('semIsAktif',1)
                ->pluck('mtkNama','klsId')->sortBy('mtks.mtkNama')->sortBy('kelas.klsNama');


            $pegawai = DB::table('pegawais')
                ->join('prodis','pegProdiKode','=','prodis.prodiKode')
                ->join('fakultas','prodis.prodiKodeFakultas','=','fakultas.id')
                ->where('pegawais.pegId',auth()->user()->nip)
                ->first();
            return view('admin.qrcode.index',['user'=>$pegawai,'kelas'=>$kelas,'klss'=>$klss]);
        }
    }

    public function store(Request $request)
    {
        //set pertemuan otomatis
        $perKls = DB::table('qrcodes')->where('qrcodeKlsId',$request->input('klsId'))->count();
        if ($perKls >0) {
            $perNow = $perKls +1;
        } else {
            $perNow = 1;
        }

        //set waktu akhir
        $dl = Carbon::now()->addMinutes($request->input('durasi'));
        //set Id qrcode
        $id = $request->input('klsId').$perNow;

        $qrcode = new Qrcode;
        $qrcode-> qrcodeId= $id;
        $qrcode->qrcodeKlsId = $request->input('klsId');
        $qrcode-> qrcodePertemuan= $perNow;
        $qrcode->qrcodeWaktuAkhir =$dl;
        $qrcode->qrcodeKode = Hash::make($request->input('klsId').$perNow.Carbon::now());
        $qrcode->save();


        //set penghitung pertemuan
        $kelas = DB::table('totalqrcodes')->where('totKlsId',$request->input('klsId'))->count();

        if ($kelas==0){
            $kls = new Totalqrcode;
            $kls->totKlsId = $request->input('klsId');
            $kls->totCodeCreated = 1;
            $kls->save();
        }else{
            Totalqrcode::where('totKlsId',$request->input('klsId'))->update(['totCodeCreated' => DB::raw('totCodeCreated+1')]);;
        }

        //make absen semua mhs dalam 1 pertemuan
        $krs = DB::table('krs')->where('krsKlsId',$request->input('klsId'))->get();
        foreach ($krs as $k){
            $presensi = new Presensi;
            $presensi->presensiKlsId = $request->input('klsId');
            $presensi->presensiKrsId = $k->krsId;
            $presensi->presensiQrcodeKode = $qrcode->qrcodeKode;
            $presensi->presensiStatus = 0;
            $presensi->long = 0;
            $presensi->lat = 0;
            $presensi->presensiDevId = 0;
            $presensi->save();
        }


        return redirect('/qrcode/'.$id.'/showme');
    }

    public function show($id)
    {
        if (auth()->user()->user_level == '1'){
            $klss = Qrcode::all()->where('qrcodeKlsId',$id)->sortBy('qrcodePertemuan');

            $kelas = DB::table('kelas')
                ->join('totalqrcodes','klsId','=','totalqrcodes.totKlsId')
                ->join('mtks','klsMtkId','=','mtks.mtkId')

                ->join('dosens','klsDsnNip','=','dosens.dsnNip')
                ->where('kelas.klsId',$id)->first();

            $dosen = DB::table('dosens')
                ->join('prodis','dsnProdiKode','=','prodis.prodiKode')
                ->join('fakultas','prodis.prodiKodeFakultas','=','fakultas.id')
                ->where('dsnNip',auth()->user()->nip)
                ->first();
            return view('dosen.qrcode.show',['user'=>$dosen,'kelas'=>$kelas,'klss'=>$klss]);
        }

        elseif (auth()->user()->user_level =='2'){

            $klss = Qrcode::all()->where('qrcodeKlsId',$id)->sortBy('qrcodePertemuan');

            $kelas = DB::table('kelas')
                ->join('totalqrcodes','klsId','=','totalqrcodes.totKlsId')
                ->join('mtks','klsMtkId','=','mtks.mtkId')
                ->join('dosens','klsDsnNip','=','dosens.dsnNip')->where('kelas.klsId',$id)->first();

            $pegawai = DB::table('pegawais')
                ->join('prodis','pegProdiKode','=','prodis.prodiKode')
                ->join('fakultas','prodis.prodiKodeFakultas','=','fakultas.id')
                ->where('pegawais.pegId',auth()->user()->nip)
                ->first();
            return view('admin.qrcode.show',['user'=>$pegawai,'klss'=>$klss,'kelas'=>$kelas]);
        }
    }

    public function showme(request $request , $id)
    {
        if (auth()->user()->user_level == '1'){
            $qr = DB::table('qrcodes')
                ->join('kelas','qrcodeKlsId','=','klsId')
                ->join('mtks','kelas.klsMtkId','=','mtks.mtkId')
                ->join('dosens','kelas.klsDsnNip','=','dosens.dsnNip')
                ->where('qrcodes.qrcodeId',$id)->first();

            $qrcode = Qrcode::all()->where('qrcodeId',$id)->first();

            $dosen = DB::table('dosens')
                ->join('prodis','dsnProdiKode','=','prodis.prodiKode')
                ->join('fakultas','prodis.prodiKodeFakultas','=','fakultas.id')
                ->where('dsnNip',auth()->user()->nip)
                ->first();
            return view('dosen.qrcode.new',['user'=>$dosen,'qr'=>$qr,'qrcode'=>$qrcode]);
        }

        elseif (auth()->user()->user_level =='2'){

            $qr = DB::table('qrcodes')
                ->join('kelas','qrcodeKlsId','=','klsId')
                ->join('mtks','kelas.klsMtkId','=','mtks.mtkId')
                ->join('dosens','kelas.klsDsnNip','=','dosens.dsnNip')
                ->where('qrcodes.qrcodeId',$id)->first();

            $qrcode = Qrcode::all()->where('qrcodeId',$id)->first();

            $pegawai = DB::table('pegawais')
                ->join('prodis','pegProdiKode','=','prodis.prodiKode')
                ->join('fakultas','prodis.prodiKodeFakultas','=','fakultas.id')
                ->where('pegawais.pegId',auth()->user()->nip)
                ->first();
            return view('admin.qrcode.new',['user'=>$pegawai,'qr'=>$qr,'qrcode'=>$qrcode]);
        }

    }

    public function cetak($id){
        ini_set('max_execution_time', 300);

        if (auth()->user()->user_level == '2') {

            $qr = DB::table('qrcodes')
                ->join('kelas','qrcodeKlsId','=','klsId')
                ->join('mtks','kelas.klsMtkId','=','mtks.mtkId')
                ->join('dosens','kelas.klsDsnNip','=','dosens.dsnNip')
                ->where('qrcodes.qrcodeId',$id)->first();


            $qrcode = Qrcode::all()->where('qrcodeId',$id)->first();

            $user = DB::table('pegawais')
                ->join('prodis','pegProdiKode','=','prodis.prodiKode')
                ->join('fakultas','prodis.prodiKodeFakultas','=','fakultas.id')
                ->where('pegawais.pegId',auth()->user()->nip)
                ->first();

            $pdf = PDF::loadView('admin.qrcode.print',['qr'=>$qr,'user' => $user,'qrcode'=>$qrcode])->setPaper('a4', 'potrait');
            return $pdf->stream('Qr Code Presensi.pdf');

        } elseif (auth()->user()->user_level == '1') {
            $qr = DB::table('qrcodes')
                ->join('kelas','qrcodeKlsId','=','klsId')
                ->join('mtks','kelas.klsMtkId','=','mtks.mtkId')
                ->join('dosens','kelas.klsDsnNip','=','dosens.dsnNip')
                ->where('qrcodes.qrcodeId',$id)->first();

            $qrcode = Qrcode::all()->where('qrcodeId',$id)->first();

            $user = DB::table('dosens')
                ->join('prodis','dsnProdiKode','=','prodis.prodiKode')
                ->join('fakultas','prodis.prodiKodeFakultas','=','fakultas.id')
                ->where('dsnNip',auth()->user()->nip)
                ->first();
            $pdf = PDF::loadView('dosen.qrcode.print',['user' => $user, 'qr'=>$qr,'qrcode'=>$qrcode])->setPaper('a4', 'potrait');
            return $pdf->stream('jadwal kuliah.pdf');
        }
    }


}
