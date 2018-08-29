@extends('layouts.master')

@section('title')
    QR Code Presensi
@endsection

@section('sidebar')
    <aside class="main-sidebar" style="background-color: #0a0a0a">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header" style="text-align: center;color: white">MAIN NAVIGATION</li>

                <li>
                    <a href="/home">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="/jadwal">
                        <i class="fa fa-table"></i> <span>Jadwal Kuliah</span>
                    </a>
                <li>

                <li class="active">
                    <a href="/qrcode">
                        <i class="fa fa-qrcode"></i> <span>Qr Code</span>
                    </a>
                </li>

                <li>
                    <a href="/presensi/search">
                        <i class="fa fa-edit"></i> <span>Presensi</span>
                    </a>
                </li>
        </section>
        <!-- /.sidebar -->
    </aside>
@endsection

@section('content')
    <style>
        .thead{
            background-color: #0a0a0a;
            color: white;
            font-weight: normal;
        }

    </style>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <a href="/qrcode" class="btn btn-primary btn-sm" alt="tambah" style="color: #a9fd00;background-color: #0a0a0a"><i class="glyphicon glyphicon-chevron-left" ></i></a> Detail Qr Code
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Qr Code</li>
            </ol>
        </section>

        <!-- Main content -->
        <div class="row">
            <section class="col-lg-offset-1 col-lg-10 ">
                <!-- Calendar -->
                <div class="box">
                    <h4 style="text-align: center">
                        {!! $kelas->mtkId !!} / {!! $kelas->mtkNama !!} @switch($kelas->klsNama)
                            @case(1)
                            A
                            @break
                            @case(2)
                            B
                            @break
                            @case (3)
                            C
                            @break
                            @case (4)
                            D
                            @break
                            @default

                        @endswitch
                    </h4>
                    <h5 style="text-align: center">
                        Total Pertemuan : {!! $kelas->totCodeCreated !!}/{!! $kelas->klsJumlahPer !!} Pertemuan
                    </h5>
                    <div class="row text-center">
                        <a href="/presensi/{{$kelas->klsId}}" class="btn btn-sm" style="background-color: black;color: #a9fd00"><i class="glyphicon glyphicon-align-justify"></i> Daftar Presensi</a>
                    </div>
                    <div class="box-body">
                        <section class="col-lg-offset-1 col-lg-10 ">
                            <table class="table table-bordered table-hover">
                                <thead class="thead">
                                <tr>
                                    <th scope="col"  class="text-center">Pertemuan</th>
                                    <th scope="col"  class="text-center">Expired at</th>
                                    <th scope="col"  class="text-center">Action Qr Code</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($klss)>0)
                                    @foreach($klss as $kls)
                                        {{--<th class="align-middle" scope="row"><img style="width:60px ;height: 75px;" src="/storage/avatars/{{$dosen->foto}}"></th>--}}
                                        <tr>
                                            <td class="text-center align-middle">{!! $kls->qrcodePertemuan !!}</td>
                                            <td class="text-center">{!! $kls-> qrcodeWaktuAkhir->format('H:m:s | d-m-Y')!!}</td>
                                            <td class="text-center"><a href="/qrcode/{{$kls->qrcodeKlsId.$kls->qrcodePertemuan}}/showme" class="btn btn-xs" style="color: #a9fd00;background-color: #0a0a0a;"><i class="glyphicon glyphicon-qrcode"></i> Lihat</a> |
                                                <a href="/qrcode/{!! $kls->qrcodeKlsId.$kls->qrcodePertemuan !!}/cetak" target="_blank" class="btn btn-xs" style="color: #a9fd00;background-color: #0a0a0a;"><i class="glyphicon glyphicon-print"></i> Cetak</a>
                                        </tr>
                                    @endforeach
                                @else
                                    No Post
                                @endif
                                </tbody>
                            </table>

                        </section>

                    </div>
                </div>
            </section>

        </div><!-- /.Left col -->
    </div>
    <!-- /.content-wrapper -->
@endsection
