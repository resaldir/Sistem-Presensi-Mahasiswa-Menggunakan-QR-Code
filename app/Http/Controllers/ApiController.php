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
use App\Http\Resources\Krs;
use App\Http\Resources\Mhs;
use App\Http\Resources\NoAkses;
use App\Http\Resources\PresensiFalse;
use App\Http\Resources\PresensiFalse1;
use App\Http\Resources\PresensiFalse2;
use App\Http\Resources\PresensiFalse3;
use App\Http\Resources\PresensiFalse4;
use App\Http\Resources\presensiTrue;
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

class ApiController extends Controller
{

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
//            $dev = Presensi::all()->where('presensiQrcodeKode',$qrcodeKode)->where('presensiDevId',$dev)->first();

                        //check mahasiswa
                        $presensi = Presensi::all()->where('presensiKrsId',$krsId)->where('presensiQrcodeKode',$qrcodeKode)->first();

                        if ($presensi){
                            $pre = Presensi::findOrFail($presensi->presensiId);
                            $pre->presensiStatus = 1;
                            $pre->lat = $lat;
                            $pre->long =$long;

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