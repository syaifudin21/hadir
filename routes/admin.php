<?php

Route::get('/', 'Admin\AdminController@index')->name('admin.home');
Route::get('/login', 'Admin\LoginController@showLoginForm')->name('admin.login');
Route::post('/login', 'Admin\LoginController@login')->name('admin.login');
Route::post('/logout', 'Admin\LoginController@logout')->name('admin.logout');

Route::get('/sinctime', 'Admin\AdminController@sinctime');
Route::get('/download/manual', 'Admin\DownloadController@downloadmanual');
Route::get('/download/clear', 'Admin\DownloadController@downloadclear');

Route::get('/upload/server', 'Admin\UploadController@upload');

Route::get('/user', 'Admin\UserController@index');
Route::post('/user', 'Admin\UserController@store')->name('user.tambah');
Route::put('/user/update', 'Admin\UserController@update')->name('user.update');
Route::delete('/user/{id}', 'Admin\UserController@delete')->name('user.hapus');

Route::get('/mesin', 'Admin\MesinController@index');
Route::post('/mesin', 'Admin\MesinController@store')->name('mesin.tambah');
Route::put('/mesin/update', 'Admin\MesinController@update')->name('mesin.update');
Route::delete('/mesin/{id}', 'Admin\MesinController@delete')->name('mesin.hapus');

Route::get('/waktu', 'Admin\WaktuController@index');
Route::post('/waktu', 'Admin\WaktuController@store')->name('waktu.tambah');
Route::put('/waktu/update', 'Admin\WaktuController@update')->name('waktu.update');
Route::delete('/waktu/{id}', 'Admin\WaktuController@delete')->name('waktu.hapus');

Route::get('/rekaman', 'Admin\RekamController@index');
Route::get('/singkron', 'Admin\SingkronController@index');

Route::get('/setsingkron', 'Admin\SetSingkronController@index');
Route::post('/setsingkron', 'Admin\SetSingkronController@store')->name('setsingkron.tambah');
Route::put('/setsingkron/update', 'Admin\SetSingkronController@update')->name('setsingkron.update');
Route::delete('/setsingkron/{id}', 'Admin\SetSingkronController@delete')->name('setsingkron.hapus');

Route::get('/gagalabsen', 'Admin\GagalAbsenController@index');
Route::post('/gagalabsen', 'Admin\GagalAbsenController@store')->name('gagalabsen.tambah');
Route::put('/gagalabsen/update', 'Admin\GagalAbsenController@update')->name('gagalabsen.update');
Route::delete('/gagalabsen/{id}', 'Admin\GagalAbsenController@delete')->name('gagalabsen.hapus');


