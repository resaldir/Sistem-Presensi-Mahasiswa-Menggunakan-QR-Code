<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Izin Mahasiswa</title>
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{!! asset('template/bower_components/bootstrap/dist/css/bootstrap.min.css')!!}">
</head>
<body>
<section class="content">
    <!-- Main row -->
    <div class="row">
        <div class="col-xs-offset-2 col-xs-8">
            <br>
            <p>Form Izin Ketidakhadiran Mahasiswa</p>
        </div>
    </div>
    <div class="row">
        <!-- Left col -->
        <section class="col-xs-12">

            {!! Form::open(['class'=>'form-horizontal','action'=>'ApiController@izin','method'=>'POST','files' => TRUE]) !!}
            <div class="form-group">
                <div class="col-xs-offset-2 col-xs-8">
                    {!! Form::text('klsId',$kelas,['class'=>'form-control']);!!}
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-offset-2 col-xs-8">
                    {!! Form::text('pertemuan',$pertemuan,['class'=>'form-control']);!!}
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-offset-2 col-xs-8">
                    {!! Form::text('token',$token,['class'=>'form-control']);!!}
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-offset-2 col-xs-8">
                    {!! Form::file('foto',null)!!}
                </div>
            </div>



            {!! Form::submit('Kirim', ['class'=>'btn btn-default col-xs-offset-2 col-xs-8','style'=>'background-color: #0a0a0a;color: #a9fd00']) !!}
            {!! Form::close() !!}

        </section>
        <!-- /.Left col -->
    </div>
    <!-- /.row (main row) -->
</section>
</body>
</html>