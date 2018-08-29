<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{!! asset('template/bower_components/bootstrap/dist/css/bootstrap.min.css')!!}">
    <title>Jadwal Kuliah Departemen {!! $user->prodiNama !!}</title>

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
    <h3>Jadwal Kuliah Semester {!! $sem->semTipe==1 ? "Ganjil":"Genap" !!} {!! $sem->semTahun !!}/{!! $sem->semTahun +1  !!} <br>
        Departemen {!! $user->prodiNama !!}<br>
        Fakultas {!! $user->nama !!} USU</h3>

    <table class="table table-bordered">
        <thead class="thead">
        <tr>
            <th scope="col"  class="text-center align-middle">Hari</th>
            <th scope="col"  class="text-center">Jam</th>
            <th scope="col"  class="text-center">Kode Matkul</th>
            <th scope="col"  class="text-center">Nama Mata Kuliah</th>
            <th scope="col"  class="text-center">SKS</th>
            <th scope="col"  class="text-center">SEM</th>
            <th scope="col"  class="text-center">Kelas</th>
            <th scope="col"  class="text-center">Dosen</th>
            <th scope="col"  class="text-center">Ruangan</th>
        </tr>
        </thead>
        <tbody>
        @if(count($jadwals)>0)
            @foreach($jadwals as $jadwal)
                {{--<th class="align-middle" scope="row"><img style="width:60px ;height: 75px;" src="/storage/avatars/{{$dosen->foto}}"></th>--}}
                <tr>
                    <td style="text-transform: uppercase;text-align: center;vertical-align: middle" >{!! $jadwal->hariNama !!}</td>
                    <td class="text-center align-middle" style="vertical-align: middle">{!! $jadwal->jdwlSesiMulai !!} - {!! $jadwal->jdwlSesiSelesai !!}</td>
                    <td class="text-center align-middle" style="vertical-align: middle">{!! $jadwal->mtkId !!}</td>
                    <td class="align-middle" style="vertical-align: middle">{!! $jadwal->mtkNama !!}</td>
                    <td class="text-center align-middle" style="vertical-align: middle">{!! $jadwal->mtkTotalSks !!}</td>
                    <td class="text-center align-middle" style="vertical-align: middle">{!! $jadwal->mtkSemester !!}</td>
                    <td class="text-center align-middle" style="vertical-align: middle">
                        @switch($jadwal->klsNama)
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
                            -
                        @endswitch
                    </td>
                    <td class="align-middle" style="vertical-align: middle">{!! $jadwal->dsnNama !!}</td>
                    <td class="align-middle" style="vertical-align: middle">{!! $jadwal->ruanganKode !!}</td>

                </tr>
            @endforeach
        @else
            No Post
        @endif
        </tbody>
    </table>
<h5 class="text-left" style="padding-left: 75%">An. Dekan <br>
Wakil Dekan I <br><br><br>
Prof. Dr. Ing. Ir. Johannes Tarigan <br>
NIP. 195612241981031002</h5>
</body>
</html>