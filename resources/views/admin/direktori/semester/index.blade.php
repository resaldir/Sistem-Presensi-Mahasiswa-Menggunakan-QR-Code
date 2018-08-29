@extends('layouts.master')

@section('title')
    Direktori Semester
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
                        <li><a href="#"><i class="fa fa-circle-o"></i> Semester</a></li>
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
                Direktori Semester
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Direktori</li>
                <li class="active">Semester</li>
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
                            <a href="semester/create" class="btn btn-primary btn-sm" alt="tambah" style="color: #a9fd00;background-color: #0a0a0a"><i class="glyphicon glyphicon-plus" ></i> Tambah</a>
                            <table class="table table-bordered table-hover table-responsive" id="dataSemester">
                                <thead class="thead">
                                <tr>
                                    <th scope="col"  class="text-center">Kode Semester</th>
                                    <th scope="col"  class="text-center">Tanggal Mulai</th>
                                    <th scope="col"  class="text-center">Tanggal Selesai</th>
                                    <th scope="col"  class="text-center">Tipe (Ganjil / Genap)</th>
                                    <th scope="col"  class="text-center">Tahun</th>
                                    <th scope="col"  class="text-center">Program Studi</th>
                                    <th scope="col"  class="text-center">Fakultas</th>
                                    <th scope="col"  class="text-center">Status</th>
                                    <th scope="col"  class="text-center" colspan="2">Aksi</th>
                                </tr>
                                </thead>
                                <tbody>

                                @if(count($semesters)>0)
                                    @foreach($semesters as $semester)
                                        {{--<th class="align-middle" scope="row"><img style="width:60px ;height: 75px;" src="/storage/avatars/{{$dosen->foto}}"></th>--}}
                                        <tr>
                                            <td class="text-center">{!! $semester->semId !!}</td>
                                            <td class="text-center">{!! $semester->semTglMulai !!}</td>
                                            <td class="text-center">{!! $semester->semTglSelesai !!}</td>
                                            <td class="text-center">{!! $semester->semTipe==1 ? 'Ganjil' :'Genap' !!} </td>
                                            <td class="text-center">{!! $semester->semTahun !!}</td>
                                            <td class="text-center">{!! $semester->prodiNama !!}</td>
                                            <td class="text-center">{!! $semester->nama !!}</td>
                                            <td class="text-center">{!! $semester->semIsAktif==1 ? 'Aktif' : 'Tidak Aktif' !!}</td>
                                            <td class="text-center text-inline">
                                                @if($semester->semIsAktif==0)
                                                    <a href="/semester/{{$semester->semId}}/aktif" class="btn btn-xs btn-primary" ><i class="glyphicon glyphicon-ok-sign"></i> Aktifkan</a>
                                                @else
                                                    <a class="btn btn-xs" style="background-color: #0a0a0a;color: #a9fd00;" disabled=""><i class="glyphicon glyphicon-ok-circle"></i> Aktif</a>
                                                @endif
                                            </td>
                                            <td class="text-center text-inline">
                                                <a>{!!Form::open(['action' => ['SemesterController@destroy', $semester->semId], 'method' => 'POST'])!!}
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
                            <div class="row">
                                <div class="col-sm-offset-4 col-sm-4">{{ $semesters->links() }}</div>

                            </div>
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
