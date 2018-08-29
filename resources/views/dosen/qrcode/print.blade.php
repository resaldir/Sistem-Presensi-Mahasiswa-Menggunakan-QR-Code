<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{!! asset('template/bower_components/bootstrap/dist/css/bootstrap.min.css')!!}">

    <title>Document</title>
</head>
<body>
<h4 style="text-align: center">
    {!! $qr->mtkId !!} / {!! $qr->mtkNama !!}
    @switch($qr->klsNama)
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
<h4 style="text-align: center">
    Pertemuan : {!! $qr->qrcodePertemuan !!}/{!! $qr->klsJumlahPer !!}
</h4>


<div class="box-body">
    <section class="col-lg-offset-1 col-lg-10 ">
        <div class="row">
            <div class="text-center">
                <img src="https://chart.googleapis.com/chart?chs=400x400&cht=qr&chl={!! $qr->qrcodeKode !!}}" alt="">
            </div>
        </div>
        <div class="row ">
            <h5 style="text-align: center"><strong>Expired At : </strong>{!! $qrcode->qrcodeWaktuAkhir->format('H:m:s | d-m-Y') !!}</h5>
        </div>

    </section>

</div>
</body>
</html>