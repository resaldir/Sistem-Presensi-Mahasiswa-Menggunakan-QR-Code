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
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>
@endsection

@section('content')
    <style>
        #overlay {
            position: fixed;
            display: none;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0,0,0,0.9);
            z-index: 2;
            cursor: pointer;
        }

        #text{
            position: absolute;
            top: 50%;
            left: 50%;
            font-size: 50px;
            color: white;
            transform: translate(-50%,-50%);
            -ms-transform: translate(-50%,-50%);
        }
    </style>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <a href="/qrcode" class="btn btn-primary btn-sm" alt="tambah" style="color: #a9fd00;background-color: #0a0a0a"><i class="glyphicon glyphicon-chevron-left" ></i></a> New Qr Code
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Qr Code</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="col-lg-offset-1 col-lg-10 ">
            <!-- Calendar -->
            <div class="box">
                <h4 style="text-align: center">
                    {!! $qr->mtkId !!} / {!! $qr->mtkNama !!}
                        @switch($qr->klsNama)
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
                    Pertemuan : {!! $qr->qrcodePertemuan !!}/{!! $qr->klsJumlahPer !!}
                </h5>


                <div class="box-body">
                    <section class="col-lg-offset-1 col-lg-10 ">
                        <div class="row text-center">
                            <a href="#" onclick="on()" class="btn btn-sm"  style="color: #a9fd00;background-color: #0a0a0a;"><i class="glyphicon glyphicon-resize-full"></i> Fullscreen</a>
                            <a href="/qrcode/{!! $qr->qrcodeId !!}/cetak" target="_blank" class="btn btn-sm" style="color: #a9fd00;background-color: #0a0a0a;"><i class="glyphicon glyphicon-print"></i> Cetak</a>
                            <a href="/presensi/{{$qr->klsId}}" class="btn btn-sm" style="background-color: black;color: #a9fd00"><i class="glyphicon glyphicon-align-justify"></i> Daftar Presensi</a>
                        </div>
                        <div class="row">
                            <div class="text-center">
                                <img src="https://chart.googleapis.com/chart?chs=250x250&cht=qr&chl={!! $qr->qrcodeKode !!}}" alt="">
                            </div>
                        </div>
                        <div class="row ">
                            <h5 style="text-align: center"><strong>Expired At : </strong>{!! $qrcode->qrcodeWaktuAkhir->format('H:m:s | d-m-Y') !!}</h5>
                        </div>

                    </section>

                </div>
            </div>
        </section>
        <!-- /.Left col -->
    </div>
    <!-- /.content-wrapper -->
    <div id="overlay" onclick="off()">
        <img id="text" src="https://chart.googleapis.com/chart?chs=500x500&cht=qr&chl={!! $qr->qrcodeKode !!}}" alt="">
    </div>
    <script>
        function on() {
            document.getElementById("overlay").style.display = "block";
        }

        function off() {
            document.getElementById("overlay").style.display = "none";
        }
    </script>
@endsection
