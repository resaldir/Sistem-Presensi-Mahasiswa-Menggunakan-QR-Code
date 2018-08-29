@extends('layouts.master')

@section('title')
    Calendar Dosen
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
                    <a href="/calender">
                        <i class="fa fa-calendar"></i> <span>Calendar</span>
                    </a>
                </li>

                <li>
                    <a href="/jadwal">
                        <i class="fa fa-table"></i> <span>Jadwal Kuliah</span>
                    </a>
                <li>

                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-edit"></i> <span>Presensi</span>
                        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="/presensi/search"><i class="fa fa-circle-o"></i> Lihat Daftar Presensi</a></li>
                        <li><a href="/qrcode"><i class="fa fa-circle-o"></i> Buat Presensi Baru</a></li>
                    </ul>
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
                Calendar
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Calendar</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <section class="col-lg-12">
                    <!-- Calendar -->
                    <iframe src="https://calendar.google.com/calendar/b/3/embed?showTitle=0&amp;showPrint=0&amp;showCalendars=0&amp;height=450&amp;wkst=2&amp;bgcolor=%23FFFFFF&amp;src=en.indonesian%23holiday%40group.v.calendar.google.com&amp;color=%23125A12&amp;src=37nkp59d6qb6doi474of5vghi4%40group.calendar.google.com&amp;color=%23B1365F&amp;ctz=Asia%2FJakarta" style="border-width:0" width="1050" height="450" frameborder="0" scrolling="no"></iframe>
                <!-- /.content -->
            </div>
        </section>
    </div>
    <!-- /.content-wrapper -->
@endsection
