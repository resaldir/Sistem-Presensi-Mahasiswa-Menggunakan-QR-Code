@extends('layouts.master')

@section('title')
    Ubah Password Dosen
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
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <a href="/home" class="btn btn-primary btn-sm" alt="tambah" style="color: #a9fd00;background-color: #0a0a0a"><i class="glyphicon glyphicon-chevron-left" ></i></a> Ubah Password
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Ubah Password</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="row">
                <!-- Left col -->
                <section class="col-lg-12">

                    {!! Form::open(['class'=>'form-horizontal','action'=>['UbahPasswordController@update',auth()->user()->id],'method'=>'POST','enctype'=>'multipart/form-data']) !!}

                    <div class="form-group">
                        {!! Form::label('email','Email',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-8">
                            {!! Form::text('email',auth()->user()->email,['class'=>'form-control','disabled']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('password','Password Baru',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-8">
                            {!! Form::password('password',['class'=>'form-control']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('password_comfirmation','Kofirmasi Password',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-8">
                            {!! Form::password('password_confirmation',['class'=>'form-control']) !!}
                        </div>
                    </div>
                    {!! Form::hidden('_method','PUT')!!}
                    {!! Form::submit('Update', ['class'=>'btn btn-default col-sm-offset-2 col-sm-8','style'=>'background-color: #0a0a0a;color: #a9fd00']) !!}
                    {!! Form::close() !!}

                </section>
                <!-- /.Left col -->
            </div>
            <!-- /.row (main row) -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
