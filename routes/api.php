<?php

use Illuminate\Http\Request;




Route::post('mahasiswa','ApiController@krs');

Route::put('presensi','ApiController@presensiUpdate');

Route::post('izin','ApiController@getIzin');

Route::post('izin/baru','ApiController@izin');

Route::get('updateizin/{id}','ApiController@updateIzin')->name('izin');

Route::get('updateizinBaru/{id}','ApiController@updateIzinBaru');

Route::post('register', 'ApiController@registration');

Route::post('login', 'ApiController@login');

Route::post('profile', 'ApiController@profile');

Route::post('kelas', 'ApiController@kelasList');

Route::post('kelas/detail', 'ApiController@kelasDetail');

Route::post('presensi/lihat', 'ApiController@lihatPresensi');

Route::post('presensi/lihat/hadir', 'ApiController@lihatPresensiHadir');

Route::post('jadwal', 'ApiController@jadwal');

Route::post('izin/mahasiswa', 'ApiController@izinMahasiswa');

Route::put('presensi/mahasiswa','ApiController@presensiMahasiswa');