<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('welcome');
});
//Route::get('api/updateizin/{id}','ApiController@updateIzin')->name('izin');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('ubahpassword', 'UbahPasswordController');

Route::resource('semester', 'SemesterController');

Route::resource('kelas', 'KelasController');

Route::resource('krs', 'KrsController');

Route::resource('ruangan', 'RuanganController');

Route::resource('jadwal', 'JadwalController');

Route::resource('calender', 'CalenderController');

Route::resource('qrcode', 'QrCodeController');

Route::get('/semester/{id}/aktif', 'SemesterController@aktif');

Route::get('/krs/{id}/detail', 'MhsAktifController@detail');

Route::get('/dosen', 'DosenController@index');

Route::get('/matakuliah', 'MtkController@index');

Route::get('/mahasiswaaktif', 'MhsAktifController@index');

Route::get('/kelas/{id}/detail', 'KelasController@detail');

Route::get('/mahasiswa', 'MahasiswaController@index');

Route::post('/presensi', 'PresensiController@index')->name('presensi');

Route::get('/cetak', 'JadwalController@cetak');

Route::get('/qrcode/{id}/showme', 'QrCodeController@showme');

Route::get('/qrcode/{id}/cetak', 'QrCodeController@cetak');

Route::get('/presensi/search', 'PresensiController@search');

Route::get('/presensi/{id}/cetak', 'PresensiController@cetak');

Route::get('/presensi/{id}', 'PresensiController@show');

Route::get('/presensi/{id}/save', 'PresensiController@export');

Route::get('/presensi/{id}/izinshow', 'PresensiController@izinShow');

Route::get('/izin/{id}/yes', 'PresensiController@updateIzinY');

Route::get('/izin/{id}/no', 'PresensiController@updateIzinN');

