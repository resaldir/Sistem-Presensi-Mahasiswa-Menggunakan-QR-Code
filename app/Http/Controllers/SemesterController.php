<?php

namespace App\Http\Controllers;

use App\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class SemesterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

        if (auth()->user()->user_level == '2'){
            $semesters = DB::table('semesters')
                ->join('prodis','semProdiKode','=','prodis.prodiKode')
                ->join('fakultas','prodis.prodiKodeFakultas','=','fakultas.id')
                ->orderBy('semId')->paginate(6);

            $user = DB::table('pegawais')
                ->join('prodis','pegProdiKode','=','prodis.prodiKode')
                ->join('fakultas','prodis.prodiKodeFakultas','=','fakultas.id')
                ->where('pegawais.pegId',auth()->user()->nip)
                ->first();
            return view('admin.direktori.semester.index',['user'=>$user,'semesters'=>$semesters]);
        }

        else{
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
        if (auth()->user()->user_level == '2'){

            $user = DB::table('pegawais')
                ->join('prodis','pegProdiKode','=','prodis.prodiKode')
                ->join('fakultas','prodis.prodiKodeFakultas','=','fakultas.id')
                ->where('pegawais.pegId',auth()->user()->nip)
                ->first();
            return view('admin.direktori.semester.create',['user'=>$user]);
        }

        else{
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

        $user = DB::table('pegawais')
            ->join('prodis','pegProdiKode','=','prodis.prodiKode')
            ->join('fakultas','prodis.prodiKodeFakultas','=','fakultas.id')
            ->where('pegawais.pegId',auth()->user()->nip)
            ->first();


        $this->validate($request,[
            'semTahun'=>'required',
            'semTipe'=>'required',
            'semTglMulai'=>'required',
            'semTglSelesai'=>'required',
        ]);

        $semTahun = $request->input('semTahun');
        $semTipe = $request->input('semTipe');
        $semId = $semTahun.$semTipe;
        $semProdiKode = $user->prodiKode;

        $semester = new Semester;
        $semester->semId = $semId;
        $semester->semTglMulai = $request->input('semTglMulai');
        $semester->semTglSelesai = $request->input('semTglSelesai');
        $semester->semTahun = $semTahun;
        $semester->semProdiKode = $semProdiKode;
        $semester->semTipe = $semTipe;
        $semester->semIsAktif = '0';
        $semester->save();

        return redirect('/semester');
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
    public function destroy($semId)
    {
        $semester = Semester::find($semId);
        $semester->delete();

        return redirect('/semester');
    }

    public function aktif(request $request,$id){
        if (Semester::findOrFail($id)){
            DB::table('semesters')->update(['semIsAktif'=>0]);
            $editsemester = Semester::find($id);
            $editsemester->semIsAktif = 1;
            if (! $editsemester->save())
                App::abort(500);
        }
        return redirect('semester');
    }
}
