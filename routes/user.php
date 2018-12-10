<?php

Route::get('/', 'User\UserController@index')->name('user.home');
Route::get('/login', 'User\LoginController@showLoginForm')->name('user.login');
Route::post('/login', 'User\LoginController@login')->name('user.login');
Route::post('/logout', 'User\LoginController@logout')->name('user.logout');

Route::get('/kategori', 'User\KategoriController@index');
Route::post('/kategori', 'User\KategoriController@store')->name('kategori.tambah');
Route::put('/kategori/update', 'User\KategoriController@update')->name('kategori.update');
Route::delete('/kategori/{id}', 'User\KategoriController@delete')->name('kategori.hapus');