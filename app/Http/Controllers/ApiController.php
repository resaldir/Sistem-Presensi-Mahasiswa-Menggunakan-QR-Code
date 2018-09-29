<?php

namespace App\Http\Controllers;

use App\Http\Resources\Error;
use App\Http\Resources\IzinFalse;
use App\Http\Resources\IzinFalse1;
use App\Http\Resources\IzinFalse2;
use App\Http\Resources\IzinFalse3;
use App\Http\Resources\IzinFalse4;
use App\Http\Resources\IzinTrue;
use App\Http\Resources\Jadwal as JadwalResource;
use App\Http\Resources\jadwalSukses;
use App\Http\Resources\KelasDetailSukses;
use App\Http\Resources\kelasListFail;
use App\Http\Resources\KelasListFalse;
use App\Http\Resources\KelasListSukses;
use App\Http\Resources\Krs;
use App\Http\Resources\lihatPresensiBerhasil;
use App\Http\Resources\LoginBerhasil;
use App\Http\Resources\LoginWrongEmail;
use App\Http\Resources\LoginWrongPass;
use App\Http\Resources\Mhs;
use App\Http\Resources\NoAkses;
use App\Http\Resources\PresensiFalse;
use App\Http\Resources\PresensiFalse1;
use App\Http\Resources\PresensiFalse2;
use App\Http\Resources\PresensiFalse3;
use App\Http\Resources\PresensiFalse4;
use App\Http\Resources\presensiTrue;
use App\Http\Resources\ProfileFalse;
use App\Http\Resources\ProfileTrue;
use App\Http\Resources\RegistrasiFail1;
use App\Http\Resources\RegistrasiFail2;
use App\Http\Resources\RegistrasiSukses;
use App\Http\Resources\SameDevice;
use App\Http\Resources\SemesterJadwals;
use App\Http\Resources\SemesterMhs;
use App\Http\Resources\UserError;
use App\Http\Resources\UserError2;
use App\Http\Resources\WrongPassword;
use App\Izin;
use App\Jadwal;
use App\Kelas;
use App\Mahasiswa;
use App\MhsAktif;
use App\Presensi;
use App\Qrcode;
use App\Semester;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use function PHPSTORM_META\elementType;

class ApiController extends Controller
{

    public function registration( request $request){
        $this->validate($request,[
            'nim'=>'required',
            'email'=>'required',
            'password'=>'required',
        ]);

        $nim = $request->input('nim');
        $email = $request->input('email');
        $pass = $request->input('password');

        $mahs = Mahasiswa::all()->where('mhsId',$nim)->first();

        if ($mahs!== null){ //cek nim valid
            $user = User::all()->where('nip', $nim)->first();
            if ($user == null){//cek user belum ada

                $unq = Carbon::now();
                //save account user
                $newUser = new User();
                $newUser->nip = $nim;
                $newUser->email = strtolower($email);
                $newUser->password = Hash::make($pass);
                $newUser->user_level = 3;
                $newUser->remember_token = Hash::make($unq);
                $newUser->save();

                RegistrasiSukses::withoutWrapping();
                return new RegistrasiSukses($newUser);

            }else{ //user sudah ada
                RegistrasiFail1::withoutWrapping();
                return new RegistrasiFail1($user);
            }
        }else{ //nim tidak terdaftar
            RegistrasiFail2::withoutWrapping();
            return new RegistrasiFail2($nim);
        }
    }

    public function login(request $request){

        $this->validate($request,[
            'email'=>'required',
            'password'=>'required'
        ]);

        $email = strtolower($request->input('email'));
        $pass = $request->input('password');

        $user = User::all()->where('email',$email)->first();

        if ($user!==null) { //cek akun ada

            if (password_verify($pass, $user->password)) { //cek password benar

                LoginBerhasil::withoutWrapping();
                return new LoginBerhasil($user);

            }else{

                LoginWrongPass::withoutWrapping();
                return new LoginWrongPass($email);
            }
        } else {
                LoginWrongEmail::withoutWrapping();
                return new LoginWrongEmail($email);
        }
    }

    public function profile(request $request){
        $this->validate($request,[
            'token'=>'required',
        ]);

        $token = $request->input('token');

        $user = User::all()->where('remember_token', $token)->first();
        if ($user !== null){
            $mhs = Mahasiswa::all()->where('mhsId', $user->nip)->first();
            ProfileTrue::withoutWrapping();
            return new ProfileTrue($mhs);
        }else {
            ProfileFalse::withoutWrapping();
            return new ProfileFalse($user);
        }
    }

    public function kelasList (request $request) {
        $this->validate($request,[
            'token'=>'required',
        ]);

        $token = $request->input('token');

        $user = User::all()->where('remember_token', $token)->first();
        if ($user !== null){
            $semAktif = Semester::all()->where('semIsAktif', 1)->first();
            $mhsAktif = MhsAktif::all()->where('mhsAktifMhsId', $user->nip)->where('mhsAktifSemId', $semAktif->semId)->first();
            if($mhsAktif!== null){
                KelasListSukses::withoutWrapping();
                return new KelasListSukses($mhsAktif);
            }else{
                kelasListFail::withoutWrapping();
                return new kelasListFail($user);
            }
        }else {
            ProfileFalse::withoutWrapping();
            return new KelasListFalse($user);
        }

    }

    public function kelasDetail(request $request){
        $kelas = Kelas::all()->where('klsId',$request->input('klsId'))->first();
        KelasDetailSukses::withoutWrapping();
        return new KelasDetailSukses($kelas);
    }

    public function lihatPresensi(request $request){
        $token = $request->input('token');
        $kelas = Kelas::all()->where('klsId',$request->input('klsId'))->first();
        $user = User::all()->where('remember_token', $token)->first();
        $semAktif = Semester::all()->where('semIsAktif', 1)->first();
        $mhsAktif = MhsAktif::all()->where('mhsAktifMhsId', $user->nip)->where('mhsAktifSemId', $semAktif->semId)->first();
        $krs = \App\Krs::all()->where('krsMhsAktifId', $mhsAktif->mhsAktifId)->where('krsKlsId', $kelas->klsId)->first();
        $totalPresensi = Presensi::all()->where('presensiKrsId', $krs->krsId)->where('presensiKlsId', $kelas->klsId);
        $totalHadir = Presensi::all()->where('presensiKrsId', $krs->krsId)->where('presensiKlsId', $kelas->klsId)->where('presensiStatus', 0)->count();
        lihatPresensiBerhasil::withoutWrapping();
        return new lihatPresensiBerhasil($totalPresensi);
    }

    public function lihatPresensiHadir(request $request) {

        $token = $request->input('token');
        $kelas = Kelas::all()->where('klsId',$request->input('klsId'))->first();
        $user = User::all()->where('remember_token', $token)->first();
        $semAktif = Semester::all()->where('semIsAktif', 1)->first();
        $mhsAktif = MhsAktif::all()->where('mhsAktifMhsId', $user->nip)->where('mhsAktifSemId', $semAktif->semId)->first();
        $krs = \App\Krs::all()->where('krsMhsAktifId', $mhsAktif->mhsAktifId)->where('krsKlsId', $kelas->klsId)->first();
        $totalHadir = Presensi::all()->where('presensiKrsId', $krs->krsId)->where('presensiKlsId', $kelas->klsId)->where('presensiStatus', 1);
        lihatPresensiBerhasil::withoutWrapping();
        return new lihatPresensiBerhasil($totalHadir);
    }

    public function jadwal(request $request) {
        $kelas = Kelas::all()->where('klsId', $request->input('klsId'))->first();
        jadwalSukses::withoutWrapping();
        return new jadwalSukses($kelas);
    }

    public function izinMahasiswa(request $request){
    $this->validate($request,[
        'klsId'=>'required',
        'pertemuan'=>'required',
        'token'=>'required',
        'foto'=>'image|required'
    ]);

    $klsId = $request->input('klsId');
    $per = $request->input('pertemuan');
    $token=$request->input('token');

    $user = User::all()->where('remember_token', $token)->first();
    $semAktif = Semester::all()->where('semIsAktif', 1)->first();

    if ($user !== null){
        $mhsAktif = MhsAktif::all()->where('mhsAktifMhsId', 140402083)->where('mhsAktifSemId', $semAktif->semId)->first();
        $krs = \App\Krs::all()->where('krsMhsAktifId', $mhsAktif->mhsAktifId)->where('krsKlsId', $klsId)->first();

        if ($request->hasFile('foto')){
            $fileNameWithExt = $request->file('foto')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_BASENAME);
            $extention = $request->file('foto')->getClientOriginalExtension();
            $fileNameToStore = $fileName."_".time().'.'.$extention;

        }else{
            $fileNameToStore= 'noimage.jpg';
        }


        //get qecode
        $qrcode = Qrcode::all()->where('qrcodeKlsId',$klsId)->where('qrcodePertemuan',$per)->first();

        //check qrcode ada
        if (!$qrcode==null){
            $presensi = Presensi::all()->where('presensiKrsId',$krs->krsId)->where('presensiQrcodeKode',$qrcode->qrcodeKode)->first();

            //check mahasiswa ada
            if (!$presensi==null){
                $presensiId = $presensi->presensiId;

                if ($presensi->presensiStatus != 1){
                    //save foto izin

                    $path = $request->file('foto')->storeAs('public/izin',$fileNameToStore);
                    $izin = new Izin;
                    $izin->izinPresensiId = $presensiId;
                    $izin->izinFileName = $fileNameToStore;
                    if ($izin->save()){
                        return redirect('api/updateizin/'.$presensiId);
                    }else{
                        IzinFalse::withoutWrapping();
                        return new IzinFalse($izin);
                    }
                }else{
                    IzinFalse4::withoutWrapping();
                    return new IzinFalse4($presensi);
                }

            }else{
                IzinFalse2::withoutWrapping();
                return new IzinFalse2($presensi);
            }
        }else{
            IzinFalse3::withoutWrapping();
            return new IzinFalse3($qrcode);
        }

    }else{
        NoAkses::withoutWrapping();
        return new NoAkses($user);
    }

}

    public function izin(request $request){
        $this->validate($request,[
            'klsId'=>'required',
            'pertemuan'=>'required',
            'token'=>'required',
            'foto'=>'image|required'
        ]);

        $klsId = $request->input('klsId');
        $per = $request->input('pertemuan');
        $token=$request->input('token');

        $user = User::all()->where('remember_token', $token)->first();
        $semAktif = Semester::all()->where('semIsAktif', 1)->first();

        if ($user !== null){
            $mhsAktif = MhsAktif::all()->where('mhsAktifMhsId', 140402083)->where('mhsAktifSemId', $semAktif->semId)->first();
            $krs = \App\Krs::all()->where('krsMhsAktifId', $mhsAktif->mhsAktifId)->where('krsKlsId', $klsId)->first();

            if ($request->hasFile('foto')){
                $fileNameWithExt = $request->file('foto')->getClientOriginalName();
                $fileName = pathinfo($fileNameWithExt, PATHINFO_BASENAME);
                $extention = $request->file('foto')->getClientOriginalExtension();
                $fileNameToStore = $fileName."_".time().'.'.$extention;

            }else{
                $fileNameToStore= 'noimage.jpg';
            }


            //get qecode
            $qrcode = Qrcode::all()->where('qrcodeKlsId',$klsId)->where('qrcodePertemuan',$per)->first();

            //check qrcode ada
            if (!$qrcode==null){
                $presensi = Presensi::all()->where('presensiKrsId',$krs->krsId)->where('presensiQrcodeKode',$qrcode->qrcodeKode)->first();

                //check mahasiswa ada
                if (!$presensi==null){
                    $presensiId = $presensi->presensiId;

                    if ($presensi->presensiStatus != 1){
                        //save foto izin

                        $path = $request->file('foto')->storeAs('public/izin',$fileNameToStore);
                        $izin = new Izin;
                        $izin->izinPresensiId = $presensiId;
                        $izin->izinFileName = $fileNameToStore;
                        if ($izin->save()){
                            return redirect('api/updateizinBaru/'.$presensiId);
                        }else{
                            return view('pesan',['pesan'=>'Gagal upload foto']);
                        }
                    }else{
                        return view('pesan',['pesan'=>'izin ditolah, anda sudah hadir']);
                    }

                }else{
                    return view('pesan',['pesan'=> 'Data mahasiswa tidak ditemukan']);
                }
            }else{
                return view('pesan',['pesan'=>'data pertemuan /dan kelas tidak ditemukan']);
            }

        }else{
            return view('pesan',['pesan'=> 'Anda tidak memiliki akses untuk layanan ini']);
        }

    }

    public function updateIzinBaru($id){
        //update status dalam presensi =2
        $pre = Presensi::find($id);
        $pre->presensiStatus = 2;
        if ($pre->save()){
            return view('pesan',['pesan'=>'Izin Berhasil']);
        }else{
            IzinFalse::withoutWrapping();
            return new IzinFalse1($pre);
        }
    }

    public function presensiMahasiswa(request $request){

        $qrcodeKode = $request->input('qrcode');
        $long = $request->input('long');
        $lat = $request->input('lat');
        $date = Carbon::now();
        $token = $request->input('token');
        $deviceId = $request->input('device');
        $user = User::all()->where('remember_token', $token)->first();
        $semAktif = Semester::all()->where('semIsAktif', 1)->first();
        $mhsAktif = MhsAktif::all()->where('mhsAktifMhsId', $user->nip)->where('mhsAktifSemId', $semAktif->semId)->first();
        $qrcode = Qrcode::all()->where('qrcodeKode',$qrcodeKode)->first();
        $krs = \App\Krs::all()->where('krsMhsAktifId', $mhsAktif->mhsAktifId)->where('krsKlsId', $qrcode->qrcodeKlsId)->first();


        if ($user->remember_token == $token){

            $radius = 6371 * acos (cos ( deg2rad(3.561677) )
                    * cos( deg2rad( $lat ) )
                    * cos( deg2rad( $long ) - deg2rad(98.654852) )
                    + sin ( deg2rad(3.561679) )
                    * sin( deg2rad( $lat ) ));

            //check qrcode ada
            $qrcode = Qrcode::all()->where('qrcodeKode',$qrcodeKode)->first();

            //check qrcode masih aktif / scan pada waktu yang ditentukan & location
            if ($qrcode!==null ){
                if (($date <= $qrcode->qrcodeWaktuAkhir)){
                    if ($radius < 9530.876){
                        //check scan dari perangkat yang sama

                        $dev = Presensi::all()->where('presensiQrcodeKode',$qrcodeKode)->where('presensiDevId',$deviceId)->first();

                        if ($dev == null){
                            //check mahasiswa
                            $presensi = Presensi::all()->where('presensiKrsId',$krs->krsId)->where('presensiQrcodeKode',$qrcodeKode)->first();

                            if ($presensi){
                                $pre = Presensi::findOrFail($presensi->presensiId);
                                $pre->presensiStatus = 1;
                                $pre->lat = $lat;
                                $pre->long =$long;
                                $pre->presensiDevId = $deviceId;

                                if ($pre->save()){
                                    presensiTrue::withoutWrapping();
                                    return new presensiTrue($pre);
                                }else{
                                    PresensiFalse::withoutWrapping();
                                    return new PresensiFalse($pre);
                                }
                            }else{
                                PresensiFalse1::withoutWrapping();
                                return new PresensiFalse1($presensi);
                            }
                        }else{
                            return new SameDevice($dev);
                        }
                    }else{
                        PresensiFalse4::withoutWrapping();
                        return new PresensiFalse4($qrcode);
                    }
                }else{PresensiFalse3::withoutWrapping();
                    return new PresensiFalse3($qrcode);
                }

            }else{
                PresensiFalse2::withoutWrapping();
                return new PresensiFalse2($qrcode);
            }

        }else{
            NoAkses::withoutWrapping();
            return new NoAkses($user);
        }

    }

    public function krs(request $request)
    {
        $this->validate($request,[
            'email'=>'required',
            'password'=>'required'
        ]);

        $email = $request->input('email');
        $pass = $request->input('password');

        $user = User::all()->where('email',$email)->first();

        if ($user!==null){ //cek akun ada atau tidak
            if (password_verify($pass ,$user->password)) { //cek password benar
                $nim = $user->nip;
                $mhs = Mahasiswa::all()->where('mhsId', $nim)->first();
                $semAktif = Semester::all()->where('semIsAktif', 1)->first();
                $mhsAktif = MhsAktif::all()->where('mhsAktifMhsId', $nim)->where('mhsAktifSemId', $semAktif->semId)->first();
                if ($mhsAktif !== null) {
                    Krs::withoutWrapping();
                    return new Krs($mhsAktif);
                } elseif ($mhs !== null) {
                    \App\Http\Resources\Mahasiswa::withoutWrapping();
                    return new \App\Http\Resources\Mahasiswa($mhs);
                } else {
                    Error::withoutWrapping();
                    return new Error($mhsAktif);
                }
            }else{
                WrongPassword::withoutWrapping();
                return new WrongPassword($user);
            }
        }else{
            UserError::withoutWrapping();
            return new UserError(($user));
        }


    }


    public function presensiUpdate(request $request){

        $krsId = $request->input('krsId');
        $qrcodeKode = $request->input('qrcode');
        $long = $request->input('long');
        $lat = $request->input('lat');
        $date = Carbon::now();
        $token = $request->input('token');


        $mhsAktifId = \App\Krs::all()->where('krsId',$krsId)->first();
        $mhsId = MhsAktif::all()->where('mhsAktifId',$mhsAktifId->krsMhsAktifId)->first();

        $user = User::all()->where('nip',$mhsId->mhsAktifMhsId)->first();
        $deviceId = Hash::make($user->email);
        if ($user->remember_token == $token){

            $radius = 6371 * acos (cos ( deg2rad(3.561677) )
                    * cos( deg2rad( $lat ) )
                    * cos( deg2rad( $long ) - deg2rad(98.654852) )
                    + sin ( deg2rad(3.561679) )
                    * sin( deg2rad( $lat ) ));

            //check qrcode ada
            $qrcode = Qrcode::all()->where('qrcodeKode',$qrcodeKode)->first();



            //check qrcode masih aktif / scan pada waktu yang ditentukan & location
            if ($qrcode!==null ){
                if (($date <= $qrcode->qrcodeWaktuAkhir)){
                    if ($radius < 9530.876){
                        //check scan dari perangkat yang sama

                        $dev = Presensi::all()->where('presensiQrcodeKode',$qrcodeKode)->where('presensiDevId',$deviceId)->first();

                        if ($dev == null){
                            //check mahasiswa
                            $presensi = Presensi::all()->where('presensiKrsId',$krsId)->where('presensiQrcodeKode',$qrcodeKode)->first();

                            if ($presensi){
                                $pre = Presensi::findOrFail($presensi->presensiId);
                                $pre->presensiStatus = 1;
                                $pre->lat = $lat;
                                $pre->long =$long;
                                $pre->presensiDevId = $deviceId;

                                if ($pre->save()){
                                    presensiTrue::withoutWrapping();
                                    return new presensiTrue($pre);
                                }else{
                                    PresensiFalse::withoutWrapping();
                                    return new PresensiFalse($pre);
                                }
                            }else{
                                PresensiFalse1::withoutWrapping();
                                return new PresensiFalse1($presensi);
                            }
                        }else{
                            return new SameDevice($dev);
                        }
                    }else{
                        PresensiFalse4::withoutWrapping();
                        return new PresensiFalse4($qrcode);
                    }
                }else{PresensiFalse3::withoutWrapping();
                    return new PresensiFalse3($qrcode);
                }

            }else{
                PresensiFalse2::withoutWrapping();
                return new PresensiFalse2($qrcode);
            }

        }else{
            NoAkses::withoutWrapping();
            return new NoAkses($user);
        }


    }

    public function getIzin(request $request){

        $this->validate($request,[
            'krsId'=>'required',
            'klsId'=>'required',
            'pertemuan'=>'required',
            'foto'=>'image|required',
            'token'=>'required'
        ]);

        $klsId = $request->input('klsId');
        $krsId = $request->input('krsId');
        $per = $request->input('pertemuan');
        $token=$request->input('token');

        $mhsAktifId = \App\Krs::all()->where('krsId',$krsId)->first();
        $mhsId = MhsAktif::all()->where('mhsAktifId',$mhsAktifId->krsMhsAktifId)->first();

        $user = User::all()->where('nip',$mhsId->mhsAktifMhsId)->first();

        if ($user->remember_token == $token){
            if ($request->hasFile('foto')){
                $fileNameWithExt = $request->file('foto')->getClientOriginalName();
                $fileName = pathinfo($fileNameWithExt, PATHINFO_BASENAME);
                $extention = $request->file('foto')->getClientOriginalExtension();
                $fileNameToStore = $fileName."_".time().'.'.$extention;

            }else{
                $fileNameToStore= 'noimage.jpg';
            }


            //get qecode
            $qrcode = Qrcode::all()->where('qrcodeKlsId',$klsId)->where('qrcodePertemuan',$per)->first();

            //check qrcode ada
            if (!$qrcode==null){
                $presensi = Presensi::all()->where('presensiKrsId',$krsId)->where('presensiQrcodeKode',$qrcode->qrcodeKode)->first();

                //check mahasiswa ada
                if (!$presensi==null){
                    $presensiId = $presensi->presensiId;

                    if ($presensi->presensiStatus != 1){
                        //save foto izin

                        $path = $request->file('foto')->storeAs('public/izin',$fileNameToStore);
                        $izin = new Izin;
                        $izin->izinPresensiId = $presensiId;
                        $izin->izinFileName = $fileNameToStore;
                        if ($izin->save()){
                            return redirect('api/updateizin/'.$presensiId);
                        }else{
                            IzinFalse::withoutWrapping();
                            return new IzinFalse($izin);
                        }
                    }else{
                        IzinFalse4::withoutWrapping();
                        return new IzinFalse4($presensi);
                    }

                }else{
                    IzinFalse2::withoutWrapping();
                    return new IzinFalse2($presensi);
                }
            }else{
                IzinFalse3::withoutWrapping();
                return new IzinFalse3($qrcode);
            }

        }else{
            NoAkses::withoutWrapping();
            return new NoAkses($user);
        }



    }

    public function updateIzin($id){
        //update status dalam presensi =2
        $pre = Presensi::find($id);
        $pre->presensiStatus = 2;
        if ($pre->save()){
            IzinTrue::withoutWrapping();
            return new IzinTrue($pre);
        }else{
            IzinFalse::withoutWrapping();
            return new IzinFalse1($pre);
        }
    }





}