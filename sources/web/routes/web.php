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
Route::get('/auth/login', 'Auth\LoginController@login')->name('login');
Route::post('/auth/login', 'Auth\LoginController@authenticate');
Route::get('/auth/logout', 'Auth\LoginController@logout');

Route::get('/game/soft', 'Game\SoftController@index');
Route::get('/game/soft/{game}', 'Game\SoftController@show');

Route::get('/game/request', 'Game\RequestController@index')->middleware('auth');
Route::get('/game/request/input', 'Game\RequestController@input');
Route::post('/game/request', 'Game\RequestController@store')->middleware('auth');
Route::get('/game/request/edit/all', 'Game\RequestController@editListAll');
Route::get('/game/request/edit/{game}', 'Game\RequestController@editList');
Route::get('/game/request/show/edit/{gur}', 'Game\RequestController@showEdit');
Route::get('/game/request/input/edit/{game}', 'Game\RequestController@inputEdit');
Route::post('/game/request/input/edit/{game}', 'Game\RequestController@storeUpdate');
Route::get('/game/request/{gar}', 'Game\RequestController@show');


Route::get('/site', 'Site\SearchController@index');
Route::get('/site/show/{site}', 'Site\SearchController@show');


Route::get('/site/manage', 'Site\ManageController@index')->middleware('auth');
Route::get('/site/manage/edit/{site}', 'Site\ManageController@edit')->middleware('auth');

Route::group(['middleware' => ['auth', 'can:admin']], function () {
    Route::get('/game/company/create', 'Game\CompanyController@create');
    Route::post('/game/company', 'Game\CompanyController@store');
    Route::get('/game/company/edit/{gameCompany}', 'Game\CompanyController@edit');
    Route::put('/game/company/{gameCompany}', 'Game\CompanyController@update');
    Route::get('/game/request/admin/add/{gar}', 'Game\RequestController@adminAdd');
});

Route::get('/game/company', 'Game\CompanyController@index');
Route::get('/game/company/{gameCompany}', 'Game\CompanyController@show');

//Auth::routes();
