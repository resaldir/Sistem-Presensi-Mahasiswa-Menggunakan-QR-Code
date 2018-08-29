<?php

use Illuminate\Http\Request;




Route::post('mahasiswa','ApiController@krs');

Route::put('presensi','ApiController@presensiUpdate');

Route::post('izin','ApiController@getIzin');

Route::get('updateizin/{id}','ApiController@updateIzin')->name('izin');