@extends('layouts.master')

@section('title')
    Dashboard Pegawai
@endsection

@section('sidebar')
    <aside class="main-sidebar" style="background-color: #0a0a0a">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header" style="text-align: center;color: white">MAIN NAVIGATION</li>

                <li class="active treeview">
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

                <li>
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
                        <li><a href="/mahasiswaaktif"><i class="fa fa-circle-o"></i> Mahasiswa Aktif</a></li>
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
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Dashboard
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Dashboard</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="box">
                <div class="box-body">

                    <!-- /.Left col -->
                    <!-- right col (We are only adding the ID to make the widgets sortable)-->
                    <section class="col-lg-12 connectedSortable"    >
                        <!-- Small boxes (Stat box) -->
                        <div class="row">

                            <div class="col-lg-8 col-xs-12">

                                <!-- /.box-header -->
                                <div class="box-body no-padding">
                                    <!--The calendar -->
                                    <div id="calendarId" style="width: 100%"></div>
                                </div>
                                <!-- /.box-body -->
                            </div>

                            @foreach($kelas as $kls)
                                <div class="col-lg-4 col-xs-12" >
                                    <!-- small box -->
                                    <a href="/presensi/{{$kls->klsId}}" style="color: white">
                                        <div class="small-box text-center" style="background-color:  dimgrey">
                                            <div class="inner">
                                                <h3 style="color: #a9fd00">{{($kls->totCodeCreated/$kls->klsJumlahPer)*100}}<sup style="font-size: 20px">%</sup></h3>

                                                <p style="font-weight: bold;color: white; font-size: 14px">{{$kls->mtkNama}}
                                                    @switch($kls->klsNama)
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

                                                    @endswitch</p>
                                                <h6 style="font-size: 10px">{{$kls->dsnNama}}</h6>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                        @endforeach
                        <!-- ./col -->

                        </div>
                        <!-- /.row -->
                        {{--<div class="row text-center">--}}
                            {{--<div class="col-sm-offset-4 col-sm-4">{{ $kelas->links() }}</div>--}}
                        {{--</div>--}}
                    </section>
                    <!-- right col -->
                </div>
            </div>

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
