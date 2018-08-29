@extends('layouts.master')

@section('title')
    Jadwal Dosen
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

                <li class="active">
                    <a href="#">
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
                Jadwal Perkuliahan
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Jadwal</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <section class="col-lg-12">
                    <div class="box">
                        <div class="box-body">
                            <a href="/cetak" target="_blank" class="btn btn-primary btn-sm" alt="print" style="color: #a9fd00;background-color: #0a0a0a"><i class="glyphicon glyphicon-print" ></i> Print</a>
                            <table class="table table-bordered table-hover">
                                <thead class="thead">
                                <tr>
                                    <th scope="col"  class="text-center align-middle">Hari</th>
                                    <th scope="col"  class="text-center">Jam</th>
                                    <th scope="col"  class="text-center">Kode</th>
                                    <th scope="col"  class="text-center">Nama Mata Kuliah</th>
                                    <th scope="col"  class="text-center">SKS</th>
                                    <th scope="col"  class="text-center">Semester</th>
                                    <th scope="col"  class="text-center">Kelas</th>
                                    <th scope="col"  class="text-center">Ruangan</th>
                                    <th scope="col"  class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($jadwals)>0)
                                    @foreach($jadwals as $jadwal)
                                        {{--<th class="align-middle" scope="row"><img style="width:60px ;height: 75px;" src="/storage/avatars/{{$dosen->foto}}"></th>--}}
                                        <tr>
                                            <td class=" text-uppercase align-middle" style="text-align: center">{!! $jadwal->hariNama !!}</td>
                                            <td class="text-center align-middle">{!! $jadwal->jdwlSesiMulai !!} - {!! $jadwal->jdwlSesiSelesai !!}</td>
                                            <td class="text-center align-middle">{!! $jadwal->mtkId !!}</td>
                                            <td class="align-middle">{!! $jadwal->mtkNama !!}</td>
                                            <td class="text-center align-middle">{!! $jadwal->mtkTotalSks !!}</td>
                                            <td class="text-center align-middle">{!! $jadwal->mtkSemester !!}</td>
                                            <td class="text-center align-middle">
                                                @switch($jadwal->klsNama)
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
                                            <td class="align-middle">{!! $jadwal->ruanganKode !!}</td>
                                            <td class="text-center"><a href="/jadwal/{{$jadwal->jdwlId}}/edit" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-pencil"></i></a></td>

                                        </tr>
                                    @endforeach
                                @else
                                    No Post
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                </section>
            </div>
            <!-- /.row (main row) -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
