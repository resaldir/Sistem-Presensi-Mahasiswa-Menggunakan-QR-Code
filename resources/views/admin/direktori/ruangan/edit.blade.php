@extends('layouts.master')

@section('title')
    Direktori Ruangan-Edit
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
                <li class=" active treeview">
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

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <a href="/ruangan" class="btn btn-primary btn-sm" alt="tambah" style="color: #a9fd00;background-color: #0a0a0a"><i class="glyphicon glyphicon-chevron-left" ></i></a> Edit Ruangan
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Direktori</li>
                <li class="active">Ruangan</li>

            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <section class="col-lg-12">

                    {!! Form::open(['class'=>'form-horizontal','action'=>['RuanganController@update',$ruangan->ruanganId],'method'=>'POST']) !!}

                    <div class="form-group">
                        {!! Form::label('ruanganKode','Kode Ruangan',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-8">
                            {!! Form::text('ruanganKode',$ruangan->ruanganKode,['placeholder'=>'Kode Ruangan','class'=>'form-control']) !!}
                        </div>
                    </div>


                    <div class="form-group">
                        {!! Form::label('kapasitas','Kapasitas',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-8">
                            {!! Form::number('ruanganKapasitas',$ruangan->ruanganKapasitas) !!}
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
    </div>
    <!-- /.content-wrapper -->
@endsection
