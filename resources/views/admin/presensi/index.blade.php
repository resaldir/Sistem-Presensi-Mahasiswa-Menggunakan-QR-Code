@extends('layouts.master')

@section('title')
    Presensi {!! $kelas->mtkNama !!}
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
                <a href="/presensi/search" class="btn btn-primary btn-sm" alt="tambah" style="color: #a9fd00;background-color: #0a0a0a"><i class="glyphicon glyphicon-chevron-left" ></i></a> Presensi Mahasiswa
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Presensi</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">


            </div>
            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <section class="col-lg-12">
                    <div class="box">
                        <div class="box-body">
                            <h4 style="text-align: center">
                                {!! $kelas->mtkId !!} / {!! $kelas->mtkNama !!}
                                @switch($kelas->klsNama)
                                    @case(1)
                                    A
                                    @break
                                    @case(2)
                                    B
                                    @break
                                    @case (3)
                                    C
                                    @break
                                    @case (4)
                                    D
                                    @break
                                    @default

                                @endswitch
                            </h4>
                            <h5 style="text-align: center">
                                {!! $kelas ->dsnNama !!} <br>
                                Total Pertemuan : {!! $kelas->klsJumlahPer !!} Pertemuan <br>
                                Semester : {!! $kelas->semTahun !!}/{!! $kelas->semTahun +1  !!}
                            </h5>
                            <div class="row text-center">
                                <a href="/qrcode" class="btn btn-sm" style="background-color: black;color: #a9fd00"><i class="glyphicon glyphicon-qrcode"></i> Generate Qr Code</a>
                                <a href="/qrcode/{{$kelas->klsId}}" class="btn btn-sm" style="background-color: black;color: #a9fd00"><i class="glyphicon glyphicon-eye-open"> </i> Lihat Qr Code</a>

                            </div>
                            <a href="/presensi/{{$kelas->klsId}}/cetak" target="_blank" class="btn btn-primary btn-sm" alt="print" style="color: #a9fd00;background-color: #0a0a0a"><i class="glyphicon glyphicon-print" ></i> Print</a>
                            {{--<a href="/presensi/{{$kelas->klsId}}/export" target="_blank" class="btn btn-primary btn-sm" alt="print" style="color: #a9fd00;background-color: #0a0a0a"><i class="glyphicon glyphicon-download-alt" ></i> Save As .xls</a>--}}
                            <table class="table table-bordered border border-dark table-hover" style="border-color: black">
                                <thead class="thead">
                                <tr>
                                    <th scope="col"  class="text-center align-middle" style="vertical-align: middle">NIM</th>
                                    <th scope="col"  class="text-center" style="vertical-align: middle">NAMA</th>
                                    @for ($p = 1; $p <= $col; $p++)
                                        <th scope="col"  class="text-center"><u>P {!! $p !!}</u> <br>
                                            @foreach($code->where('qrcodePertemuan',$p) as $qr)
                                                <small style="font-size: 10px">
                                                    {!! $qr->created_at->format('d/m') !!}
                                                </small>

                                            @endforeach
                                        </th>
                                    @endfor
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($krss)>0)
                                        @foreach($krss as $krs)
                                                <tr>
                                                    <td class="text-center" style="vertical-align: middle">{!! $krs->mhsId !!}</td>
                                                    <td class="text-uppercase">{!! $krs->mhsNama !!}</td>

                                                    @foreach($presensi->where('mhsId',$krs->mhsId) as $per)
                                                    {{--@for ($p = 0; $p < $col; $p++)--}}
                                                        {{--@if($per->qrcodePertemuan == $p+1)--}}
                                                            @switch($per->presensiStatus)
                                                                @case(1)
                                                                    <td class="text-center align-middle" style="background-color: darkgreen"></td>
                                                                @break
                                                                @case(2)
                                                                    <td class="text-center align-middle" style="background-color: darkgoldenrod">
                                                                        <a href="/presensi/{{$per->presensiId}}/izinshow"><i class="glyphicon glyphicon-envelope" style="color: white;" ></i></a></td>
                                                                @break
                                                                @default
                                                                    <td class="text-center align-middle" style="background-color: darkred"></td>
                                                            @endswitch
                                                        {{--@else--}}
                                                            {{--<td class="text-center align-middle" style="background-color: grey"></td>--}}
                                                        {{--@endif--}}
                                                    {{--@endfor--}}
                                                        @endforeach
                                                </tr>

                                        @endforeach
                                @else
                                    no Post
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
