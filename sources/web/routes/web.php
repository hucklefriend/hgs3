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
Route::get('/auth/login', 'AuthController@login');

Route::get('test', function (){ return 'aaa'; });

Route::get('/master', 'Master\TopController@index')->name('master');
Route::get('/master/game_company', 'Master\GameCompanyController@list')->name('master_game_company_list');
Route::get('/master/game_company/add', 'Master\GameCompanyController@add')->name('master_add_game_company');
Route::post('/master/game_company/add', 'Master\GameCompanyController@postAdd')->name('master_post_add_game_company');
//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

Route::post('/auth/login_mail_auth', 'AuthController@login_mail_auth')->name('login_mail_auth');
//Route::post('/auth/provisional_registration', 'RegistrationController@register')->name('provisional_registration');
