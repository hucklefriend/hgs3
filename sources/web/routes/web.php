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
Route::get('/auth/login', 'Auth\LoginController@login');
Route::post('/auth/login', 'Auth\LoginController@authenticate');
Route::get('/auth/logout', 'Auth\LoginController@logout');

Route::get('/game/soft', 'Game\SoftController@index');
Route::get('/game/soft/{game}', 'Game\SoftController@show');

Route::get('/game/company', 'Game\CompanyController@index');
Route::get('/game/company/{gameCompany}', 'Game\CompanyController@show');

Route::get('/master', 'Master\TopController@index')->name('master');
Route::resource('master/game_company', 'Master\GameCompanyController');

Route::group(['middleware' => ['auth', 'can:admin']], function () {
    Route::get('/game/company/create', 'Game\CompanyController@create');
    Route::post('/game/company', 'Game\CompanyController@store');
    Route::get('/game/company/edit/{gameCompany}', 'Game\CompanyController@edit');
    Route::put('/game/company/{gameCompany}', 'Game\CompanyController@update');
});

//Auth::routes();
