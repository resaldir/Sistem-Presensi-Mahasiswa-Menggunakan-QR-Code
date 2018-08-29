@extends('layouts.master')

@section('title')
    Izin Presensi Mahasiswa
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

                <li>
                    <a href="/qrcode">
                        <i class="fa fa-qrcode"></i> <span>Qr Code</span>
                    </a>
                </li>

                <li class="active">
                    <a href="/presensi/search">
                        <i class="fa fa-edit"></i> <span>Presensi</span>
                    </a>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="glyphicon glyphicon-book"></i> <span>Direktori</span>
                        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="/dosen"><i class="fa fa-circle-o"></i> Dosen</a></li>
                        <li><a href="/mahasiswa"><i class="fa fa-circle-o"></i> Mahasiswa</a></li>
                        <li><a href="mahasiswaaktif"><i class="fa fa-circle-o"></i> Mahasiswa Aktif</a></li>
                        <li><a href="/matakuliah"><i class="fa fa-circle-o"></i> Mata Kuliah</a></li>
                        <li><a href="/semester"><i class="fa fa-circle-o"></i> Semester</a></li>
                        <li><a href="/kelas"><i class="fa fa-circle-o"></i> Kelas</a></li>
                        <li><a href="/ruangan"><i class="fa fa-circle-o"></i> Ruangan</a></li>
                    </ul>
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
                <a href="/presensi/{{$izin->klsId}}" class="btn btn-primary btn-sm" alt="tambah" style="color: #a9fd00;background-color: #0a0a0a"><i class="glyphicon glyphicon-chevron-left" ></i></a> Izin Presensi Mahasiswa
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Izin Presensi</li>
            </ol>
        </section>

        <!-- Main content -->
        <div class="row">
            <div class="row">
                <section class=" col-lg-offset-1 col-lg-10 ">
                    <!-- Calendar -->
                    <div class="box">
                        <h4  style="text-align: center">
                            {!! $izin->mhsId !!} / {!! $izin->mhsNama !!} <br>
                            {!! $izin->mtkNama !!} / Pertemuan ke-{!! $izin->qrcodePertemuan !!}
                        </h4>
                        <div class="box-body">
                            <section class="col-lg-12 text-center ">

                                <div class="row text-center">
                                    <img style="width:300px ;height: 400px;" src="/storage/izin/{{$izin->izinFileName}}">
                                    <br> <p>(<strong>Click Kanan - Open Image in new Tab</strong> untuk melihat surat secara penuh)</p>
                                </div>
                                <div class="row">
                                    <div class="text-center">
                                        <a href="/izin/{{$izin->presensiId}}/yes" methods="PUT" class="col-sm-offset-3 btn btn-md col-sm-2 " style="background-color: black;color: #a9fd00">Terima</a>
                                        <a href="/izin/{{$izin->presensiId}}/no"  methods="PUT" class="col-sm-offset-2 btn btn-md col-sm-2" style="background-color: black;color: #a9fd00">Tolak</a>
                                    </div>

                                </div>

                            </section>

                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <!-- /.content-wrapper -->
@endsection
