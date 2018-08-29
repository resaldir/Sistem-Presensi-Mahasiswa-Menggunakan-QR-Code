@extends('layouts.master')

@section('title')
    QR Code Dosen
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
                    <a href="#">
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
                QR Code Presensi
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">QR Code</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <section class=" col-lg-offset-1 col-lg-10 ">
                    <!-- Calendar -->
                    <div class="box">
                        <div class="box-body">
                            <section class="col-lg-12 ">

                                {!! Form::open(['class'=>'form-vertical','action'=>'QrCodeController@store','method'=>'POST','style'=>'margin-top:2%']) !!}
                                <div class="form-group col-sm-6">
                                    {!! Form::label('kelas','Kelas',['class'=>'col-sm-2 control-label', 'style'=>'margin-top:2%']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::select('klsId',$kelas ,null,['class'=>'form-control','placeholder'=>'Pilih Kelas']); !!}
                                    </div>
                                </div>


                                <div class="form-group col-sm-4">
                                    {!! Form::label('durasi','Durasi',['class'=>'col-sm-4 control-label', 'style'=>'margin-top:2%']) !!}
                                    <div class="col-sm-8">
                                        {!! Form::select('durasi',['15'=> '15 Menit','30'=> '30 Menit','60'=> '60 Menit','90'=> '90 Menit','1440'=> '24 Jam'],null,['class'=>'form-control']);!!}
                                    </div>
                                </div>

                                {!! Form::submit('Generate', ['class'=>'btn btn-default col-sm-2','style'=>'background-color: #0a0a0a;color: #a9fd00']) !!}
                                {!! Form::close() !!}

                            </section>

                        </div>
                    </div>
                </section>
                <section class=" col-lg-12 ">
                    <!-- Calendar -->
                    <div class="box">
                        <div class="box-body">
                            <section class="col-lg-12 ">
                                <table class="table table-bordered table-hover">
                                    <thead class="thead">
                                    <tr>
                                        <th scope="col"  class="text-center">Kode Matkul</th>
                                        <th scope="col"  class="text-center">Nama Mata Kuliah</th>
                                        <th scope="col"  class="text-center">Kelas</th>
                                        <th scope="col"  class="text-center">Total Qr Code</th>
                                        <th scope="col"  class="text-center">Total Pertemuan</th>
                                        <th scope="col"  class="text-center">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($klss)>0)
                                        @foreach($klss as $kls)
                                            {{--<th class="align-middle" scope="row"><img style="width:60px ;height: 75px;" src="/storage/avatars/{{$dosen->foto}}"></th>--}}
                                            <tr>
                                                <td class="text-center align-middle">{!! $kls->mtkId !!}</td>
                                                <td class="align-middle">{!! $kls->mtkNama !!}</td>
                                                <td class="text-center align-middle">
                                                    @switch($kls->klsNama)
                                                        @case(1)
                                                        <a class="btn btn-xs btn-default">A</a>
                                                        @break
                                                        @case(2)
                                                        <a class="btn btn-xs btn-default">B</a>
                                                        @break
                                                        @case (3)
                                                        <a class="btn btn-xs btn-default">C</a>
                                                        @break
                                                        @case (4)
                                                        <a class="btn btn-xs btn-default">D</a>
                                                        @break
                                                        @default
                                                        <a class="btn btn-xs btn-default">-</a>
                                                    @endswitch
                                                </td>
                                                <td class="text-center align-middle">{!! $kls->totCodeCreated !!}</td>
                                                <td class="text-center align-middle">{!! $kls->klsJumlahPer !!}</td>
                                                <td class="text-center"><a href="/qrcode/{{$kls->klsId}}" class="btn btn-xs" style="color: #a9fd00;background-color: #0a0a0a"cd><i class="glyphicon glyphicon-align-justify"></i> Detail</a></td>

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
                <!-- /.Left col -->

            </div>
            <!-- /.row (main row) -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
