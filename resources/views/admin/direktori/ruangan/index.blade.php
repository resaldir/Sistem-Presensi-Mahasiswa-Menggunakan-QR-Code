@extends('layouts.master')

@section('title')
    Direktori Ruangan
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
                        <li><a href="#"><i class="fa fa-circle-o"></i> Ruangan</a></li>
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
                Direktori Ruangan
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
                <section class="col-lg-6">

                    <div class="box">
                        <div class="box-body">
                            <a href="ruangan/create" class="btn btn-primary btn-sm" alt="tambah" style="color: #a9fd00;background-color: #0a0a0a"><i class="glyphicon glyphicon-plus" ></i> Tambah</a>
                            <table class="table table-bordered table-hover table-responsive">
                                <thead class="thead">
                                <tr>
                                    <th scope="col"  class="text-center">Kode</th>
                                    <th scope="col"  class="text-center">Kapasitas</th>
                                    <th scope="col"  class="text-center">Program Studi</th>
                                    <th scope="col"  class="text-center" colspan="2">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($ruangans)>0)
                                    @foreach($ruangans as $ruangan)
                                        {{--<th class="align-middle" scope="row"><img style="width:60px ;height: 75px;" src="/storage/avatars/{{$dosen->foto}}"></th>--}}
                                        <tr>
                                            <td>{!! $ruangan->ruanganKode!!}</td>
                                            <td class="text-center align-middle">{!! $ruangan->ruanganKapasitas !!}</td>
                                            <td class="text-center align-middle">{!! $ruangan->prodiNama !!}</td>
                                            <td class="text-center"><a href="/ruangan/{{$ruangan->ruanganId}}/edit" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-pencil"></i> Edit</a></td>
                                            <td class="text-center"><a>{!!Form::open(['action' => ['RuanganController@destroy', $ruangan->ruanganId], 'method' => 'POST'])!!}
                                                    {{Form::hidden('_method', 'DELETE')}}
                                                    {{Form::button('<i class="glyphicon glyphicon-trash"></i> Hapus', ['type' => 'submit','class' => 'btn btn-xs btn-danger'])}}
                                                    {!!Form::close()!!}</a></td>

                                        </tr>
                                    @endforeach
                                @else
                                    No Post
                                @endif
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-sm-offset-4 col-sm-4">{{ $ruangans->links() }}</div>

                            </div>
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
