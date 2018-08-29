<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{!! asset('template/bower_components/bootstrap/dist/css/bootstrap.min.css')!!}">
    <title>Presensi Mahasiswa {!! $kelas->mtkNama !!}</title>

    <style>
        body{
            font-family: "Times New Roman";
        }
        h3{
            text-align: center;
            font-size: 16px;
        }

        .thead{
            text-align: center;

        }
        thead{
            font-size: 12px;
        }
        tbody{
            font-size: 11px;
        }
    </style>
</head>
<body>
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
<table class="table table-bordered" style="border-color: black">
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
                        <td class="text-center align-middle">Hadir</td>
                        @break
                        @case(2)
                        <td class="text-center align-middle" >Izin</td>
                        @break
                        @default
                        <td class="text-center align-middle" >-</td>
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
</body>
</html>