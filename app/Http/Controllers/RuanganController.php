<?php

namespace App\Http\Controllers;

use App\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RuanganController extends Controller
{
    public function __construct()
{
    $this->middleware('auth');
}

    public function index()
    {

        if (auth()->user()->user_level == '2') {
            $ruangans = DB::table('ruangans')
                ->join('prodis', 'ruanganProdiKode', '=', 'prodis.prodiKode')
                ->join('fakultas', 'prodis.prodiKodeFakultas', '=', 'fakultas.id')
                ->orderBy('ruangans.created_at')->paginate(10);

            $user = DB::table('pegawais')
                ->join('prodis', 'pegProdiKode', '=', 'prodis.prodiKode')
                ->join('fakultas', 'prodis.prodiKodeFakultas', '=', 'fakultas.id')
                ->where('pegawais.pegId', auth()->user()->nip)
                ->first();
            return view('admin.direktori.ruangan.index', ['user' => $user, 'ruangans' => $ruangans]);
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
        if (auth()->user()->user_level == '2'){

        $user = DB::table('pegawais')
            ->join('prodis','pegProdiKode','=','prodis.prodiKode')
            ->join('fakultas','prodis.prodiKodeFakultas','=','fakultas.id')
            ->where('pegawais.pegId',auth()->user()->nip)
            ->first();
        return view('admin.direktori.ruangan.create',['user'=>$user]);
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
            'ruanganKode'=>'required',
            'ruanganKapasitas'=>'required'
        ]);

        $ruanganProdiKode = $user->prodiKode;

        $ruangan = new Ruangan;
        $ruangan->ruanganProdiKode = $ruanganProdiKode;
        $ruangan->ruanganKode = $request->input('ruanganKode');
        $ruangan->ruanganKapasitas = $request->input('ruanganKapasitas');
        $ruangan->save();

        return redirect('/ruangan');
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
        if (auth()->user()->user_level == '2'){

            $ruangan = Ruangan::find($id);

            $user = DB::table('pegawais')
                ->join('prodis','pegProdiKode','=','prodis.prodiKode')
                ->join('fakultas','prodis.prodiKodeFakultas','=','fakultas.id')
                ->where('pegawais.pegId',auth()->user()->nip)
                ->first();
            return view('admin.direktori.ruangan.edit',['user'=>$user,'ruangan'=>$ruangan]);
        }

        else{
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
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'ruanganKode'=>'required',
            'ruanganKapasitas'=>'required'
        ]);

        $ruangan = Ruangan::find($id);
        $ruangan->ruanganKode = $request->input('ruanganKode');
        $ruangan->ruanganKapasitas = $request->input('ruanganKapasitas');
        $ruangan->save();

        return redirect('/ruangan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ruangan =Ruangan::find($id);
        $ruangan->delete();

        return redirect('/ruangan');
    }
}
