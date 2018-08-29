@extends('layouts.master')

@section('title')
    Direktori Mahasiswa Aktif Semester
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
                        <li><a href="#"><i class="fa fa-circle-o"></i> Mahasiswa Aktif</a></li>
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
                Direktori Mahasiswa Aktif
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Direktori</li>
                <li class="active">Mahasiswa Aktif</li>
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
                            <table class="table table-bordered table-hover table-responsive" id="dataDosen">
                                <thead class="thead">
                                <tr>
                                    <th scope="col"  class="text-center">Semester Aktif</th>
                                    <th scope="col"  class="text-center">NIM</th>
                                    <th scope="col"  class="text-center ">Nama</th>
                                    <th scope="col"  class="text-center">Kurikulum</th>
                                    <th scope="col"  class="text-center">Program Studi</th>
                                    <th scope="col"  class="text-center">Fakultas</th>
                                    <th scope="col"  class="text-center">Aksi</th>
                                </tr>
                                </thead>
                                <tbody>

                                @if(count($mhsAktifs)>0)
                                    @foreach($mhsAktifs as $mhsAktif)
                                        {{--<th class="align-middle" scope="row"><img style="width:60px ;height: 75px;" src="/storage/avatars/{{$dosen->foto}}"></th>--}}
                                        <tr>
                                            <td class="text-center">{!! $mhsAktif->semId !!}</td>
                                            <td class="text-center">{!! $mhsAktif->mhsId !!}</td>
                                            <td class="text-uppercase">{!! $mhsAktif->mhsNama !!}</td>
                                            <td class="text-center">{!! $mhsAktif->kurNama !!}</td>
                                            <td class="text-center">{!! $mhsAktif->prodiNama !!}</td>
                                            <td class="text-center">{!! $mhsAktif->nama !!}</td>
                                            <td class="text-center"><a href="/krs/{{$mhsAktif->mhsId}}/detail" class="btn btn-xs" style="background-color: #0a0a0a;color: #a9fd00;"><i class="glyphicon glyphicon-align-justify"></i> Detail</a></td>
                                        </tr>
                                    @endforeach
                                @else
                                    no Post
                                @endif

                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-sm-offset-4 col-sm-4">{{ $mhsAktifs->links() }}</div>

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

@section('script')

    <script src="{{ asset('template/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('template/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}"></script>
    <script>
        $(function () {
            $('#dataDosen').DataTable({"pageLength":1});
        });
    </script>
@endsection