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

// 管理者のみ
Route::group(['middleware' => ['auth', 'can:admin']], function () {
    Route::get('/game/company/create', 'Game\CompanyController@create');
    Route::post('/game/company', 'Game\CompanyController@store');
    Route::get('/game/company/edit/{gameCompany}', 'Game\CompanyController@edit');
    Route::put('/game/company/{gameCompany}', 'Game\CompanyController@update');
    Route::get('/game/request/admin/add/{gar}', 'Game\RequestController@adminAdd');

    Route::get('/game/soft/edit/{game}', 'Game\SoftController@edit');
    Route::patch('/game/soft/edit/{game}', 'Game\SoftController@update');

    Route::get('/game/package/add/{game}', 'Game\PackageController@add');
    Route::post('/game/package/add/{game}', 'Game\PackageController@store');
    Route::get('/game/package/edit/{game}/{pkg}', 'Game\PackageController@edit');
    Route::patch('/game/package/edit/{game}/{pkg}', 'Game\PackageController@update');
    Route::delete('/game/package/{game}/{pkg}', 'Game\SoftController@remove');
});

Route::get('/', 'TopController@index');
Route::get('/auth/login', 'Auth\LoginController@login')->name('login');
Route::post('/auth/login', 'Auth\LoginController@authenticate');
Route::get('/auth/logout', 'Auth\LoginController@logout');

Route::get('/game/soft', 'Game\SoftController@index');
Route::post('/game/soft/comment/{game}', 'Game\SoftController@writeComment');
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

// レビュー
Route::get('/game/review/all', 'Game\ReviewController@index');
Route::post('/game/review/input', 'Game\ReviewController@postInput')->middleware('auth');
Route::get('/game/review/input/{game}', 'Game\ReviewController@input')->middleware('auth');
Route::get('/game/review/confirm/{game}', 'Game\ReviewController@confirm')->middleware('auth');
Route::post('/game/review/save/{game}', 'Game\ReviewController@save')->middleware('auth');
Route::get('/game/review/soft/{game}', 'Game\ReviewController@soft');
Route::get('/game/review/good/{review}', 'Game\ReviewController@good')->middleware('auth');
Route::get('/game/review/bad/{review}', 'Game\ReviewController@bad')->middleware('auth');
Route::get('/game/review/detail/{game}/{review}', 'Game\ReviewController@show');


Route::get('/site', 'Site\SearchController@index');
Route::get('/site/show/{site}', 'Site\SearchController@show');


Route::get('/site/manage', 'Site\ManageController@index')->middleware('auth');
Route::get('/site/manage/add', 'Site\ManageController@add')->middleware('auth');
Route::get('/site/manage/edit/{site}', 'Site\ManageController@edit')->middleware('auth');


Route::get('/game/company', 'Game\CompanyController@index');
Route::get('/game/company/{gameCompany}', 'Game\CompanyController@show');

//Auth::routes();
