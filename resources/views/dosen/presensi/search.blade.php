@extends('layouts.master')

@section('title')
    Presensi Mahasiswa
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
                    <a href="#">
                        <i class="fa fa-edit"></i> <span>Presensi</span>
                    </a>
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
                Presensi Mahasiswa
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Presensi</li>
            </ol>
        </section>

        <!-- Main content -->
        <div class="row">
            <div class="row">
                <section class=" col-lg-offset-1 col-lg-10 ">
                    <!-- Calendar -->
                    <div class="box">
                        <div class="box-body">
                            <section class="col-lg-12 text-center ">

                                {!! Form::open(['class'=>'form-vertical','action'=>'PresensiController@index','method'=>'POST','style'=>'margin-top:2%']) !!}
                                <div class="form-group col-sm-6">
                                    {!! Form::label('kelas','Kelas',['class'=>'col-sm-2 control-label', 'style'=>'margin-top:2%']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::select('klsId',$kelas ,null,['class'=>'form-control','placeholder'=>'Pilih Kelas']); !!}
                                    </div>
                                </div>



                                {!! Form::submit('Search', ['class'=>'btn btn-default col-sm-2','style'=>'background-color: #0a0a0a;color: #a9fd00']) !!}
                                {!! Form::close() !!}

                            </section>

                        </div>
                    </div>
                </section>
            </div>
        </div>

    </div>
    <!-- /.content-wrapper -->
@endsection
