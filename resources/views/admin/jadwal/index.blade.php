@extends('layouts.master')

@section('title')
    Jadwal Kuliah
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

                <li class="active treeview">
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
        .thead {
            background-color: #0a0a0a;
            color: white;
            font-weight: normal;
        }

        .table-hover tbody tr:hover td, .table-hover tbody tr:hover th {
            background-color: grey;
            color: white;
        }

    </style>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Jadwal Kuliah Semester Aktif
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Jadwal</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">


            </div>
            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <section class="col-sm-12">
                    <div class="box">
                        <div class="box-body">
                                <a href="jadwal/create" class="btn btn-primary btn-sm" alt="tambah" style="color: #a9fd00;background-color: #0a0a0a"><i class="glyphicon glyphicon-plus" ></i> Tambah</a>
                                <a href="/cetak" target="_blank" class="btn btn-primary btn-sm" alt="print" style="color: #a9fd00;background-color: #0a0a0a"><i class="glyphicon glyphicon-print" ></i> Print</a>
                            <table class="table table-bordered table-hover table-responsive">
                                <thead class="thead">
                                <tr>
                                    <th scope="col"  class="text-center align-middle" style="vertical-align: middle">Hari</th>
                                    <th scope="col"  class="text-center" style="vertical-align: middle">Jam</th>
                                    <th scope="col"  class="text-center" style="vertical-align: middle">Kode Mata Kuliah</th>
                                    <th scope="col"  class="text-center" style="vertical-align: middle">Nama Mata Kuliah</th>
                                    <th scope="col"  class="text-center" style="vertical-align: middle">SKS</th>
                                    <th scope="col"  class="text-center" style="vertical-align: middle">Sem</th>
                                    <th scope="col"  class="text-center" style="vertical-align: middle">Kelas</th>
                                    <th scope="col"  class="text-center" style="vertical-align: middle">Dosen</th>
                                    <th scope="col"  class="text-center" style="vertical-align: middle">Ruangan</th>
                                    <th scope="col"  class="text-center" style="vertical-align: middle" colspan="2">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($jadwals)>0)
                                    @foreach($jadwals as $jadwal)
                                        {{--<th class="align-middle" scope="row"><img style="width:60px ;height: 75px;" src="/storage/avatars/{{$dosen->foto}}"></th>--}}
                                        <tr>
                                            <td class=" text-uppercase" style="vertical-align: middle">{!! $jadwal->hariNama !!}</td>
                                            <td class="text-center align-middle" style="vertical-align: middle">{!! $jadwal->jdwlSesiMulai !!} - {!! $jadwal->jdwlSesiSelesai !!}</td>
                                            <td class="text-center align-middle" style="vertical-align: middle" >{!! $jadwal->mtkId !!}</td>
                                            <td class="align-middle" style="vertical-align: middle">{!! $jadwal->mtkNama !!}</td>
                                            <td class="text-center align-middle" style="vertical-align: middle">{!! $jadwal->mtkTotalSks !!}</td>
                                            <td class="text-center align-middle" style="vertical-align: middle">{!! $jadwal->mtkSemester !!}</td>
                                            <td class="text-center align-middle" style="vertical-align: middle">
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
                                            <td class="align-middle" style="vertical-align: middle">{!! $jadwal->dsnNama !!}</td>
                                            <td class="align-middle" style="vertical-align: middle">{!! $jadwal->ruanganKode !!}</td>
                                            <td class="text-center" style="vertical-align: middle"><a href="/jadwal/{{$jadwal->jdwlId}}/edit" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-pencil"></i></a></td>
                                            <td class="text-center" style="vertical-align: middle"><a>{!!Form::open(['action' => ['JadwalController@destroy', $jadwal->jdwlId], 'method' => 'POST'])!!}
                                                    {{Form::hidden('_method', 'DELETE')}}
                                                    {{Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type'=>'summit','class' => 'btn btn-xs btn-danger'])}}
                                                    {!!Form::close()!!}
                                                </a></td>

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
                <!-- /.Left col -->
            </div>
            <!-- /.row (main row) -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
