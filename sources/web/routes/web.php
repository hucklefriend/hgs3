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

Route::get('/', 'TopController@index');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::post('/auth/login_mail_auth', 'AuthController@login_mail_auth')->name('login_mail_auth');
Route::post('/auth/provisional_registration', 'RegistrationController@register')->name('provisional_registration');
