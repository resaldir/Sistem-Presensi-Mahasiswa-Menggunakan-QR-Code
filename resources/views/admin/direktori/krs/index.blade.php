@extends('layouts.master')

@section('title')
    Direktori KRS
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
    <style>
        .thead{
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
                Direktori Krs
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Direktori</li>
                <li class="active">Krs</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <div class="col-lg-12">
                    <div class="box">
                        <div class="box-body">
                            <a href="krs/create" class="btn btn-primary btn-sm" alt="tambah" style="color: #a9fd00;background-color: #0a0a0a"><i class="glyphicon glyphicon-plus" ></i> Tambah</a>
                            <table class="table table-bordered table-hover table-responsive" id="dataSemester">
                                <thead class="thead">
                                <tr>
                                    <th scope="col"  class="text-center">Tahun Semester</th>
                                    <th scope="col"  class="text-center">Mahasiswa</th>
                                    <th scope="col"  class="text-center">Mata Kuliah</th>
                                    <th scope="col"  class="text-center">Kelas</th>
                                    <th scope="col"  class="text-center">Aksi</th>
                                </tr>
                                </thead>
                                <tbody>

                                @if(count($krss)>0)
                                    @foreach($krss as $krs)
                                        {{--<th class="align-middle" scope="row"><img style="width:60px ;height: 75px;" src="/storage/avatars/{{$dosen->foto}}"></th>--}}
                                        <tr>
                                            <td class="text-center">{!! $krs->klsSemId !!}</td>
                                            <td class="text-uppercase">{!! $krs->mhsNama !!}</td>
                                            <td>{!! $krs->mtkNama !!}</td>
                                            <td class="text-center">
                                                @switch($krs->klsNama)
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
                                            <td class="text-center text-inline">
                                                <a>{!!Form::open(['action' => ['KrsController@destroy', $krs->krsId], 'method' => 'POST'])!!}
                                                    {{Form::hidden('_method', 'DELETE')}}
                                                    {{Form::button('<i class="glyphicon glyphicon-trash"></i> Hapus', ['type' => 'submit','class' => 'btn btn-xs btn-danger center-vertical'])}}
                                                    {!!Form::close()!!}</a>
                                            </td>

                                        </tr>
                                    @endforeach
                                @else
                                    no Post
                                @endif

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /.Left col -->
            </div>
            <!-- /.row (main row) -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
