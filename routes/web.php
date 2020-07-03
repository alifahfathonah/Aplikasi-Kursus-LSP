<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

// Pages Default
Route::get('/', 'PagesController@home');
Route::get('about', 'PagesController@about');
Route::get('contact', 'PagesController@contact');
Route::get('asset', 'AssetController@index');
Route::get('service', 'PagesController@service');
Route::get('testimony', 'PagesController@testimony');
Route::get('documentation', 'DocumentsController@index');
Route::get('blog', 'BlogsController@index');
Route::get('blog/{blog}', 'BlogsController@show');
Route::post('getCities', 'AssetController@getCities');
Route::post('getAllCities', 'AssetController@getAllCities');
Route::post('asset/filter', 'AssetController@filter');
Route::get('asset/{asset}', 'AssetController@show');
Route::post('pesan/add', 'MessagesController@store');

//Admin
Route::group(['prefix' => 'dashboard/admin', 'middleware' => ['admin']], function () {
    //Blog Admin
    Route::delete('blog/{blog}', 'BlogsController@destroy');
    Route::get('blog/add', 'BlogsController@create');
    Route::post('blog/add', 'BlogsController@store');
    Route::get('blog/{blog}/edit', 'BlogsController@edit');
    Route::patch('blog/{blog}', 'BlogsController@update');
    Route::post('blog/deleteImage', 'BlogsController@deleteImage');
    Route::get('blog', 'BlogsController@list');
    Route::get('blog/filter', 'BlogsController@filter_list');
    Route::get('blog/{blog}', 'BlogsController@show_detail');

    //Documentation Admin
    Route::delete('document/{document}', 'DocumentsController@destroy');
    Route::get('document/add', 'DocumentsController@create');
    Route::post('document/add', 'DocumentsController@store');
    Route::get('document/{document}/edit', 'DocumentsController@edit');
    Route::patch('document/{document}', 'DocumentsController@update');
    Route::post('document/deleteImage', 'DocumentsController@deleteImage');
    Route::post('document/deleteVideo', 'DocumentsController@deleteVideo');
    Route::get('document', 'DocumentsController@list');
    Route::get('document/filter', 'DocumentsController@filter_list');
    Route::get('document/{document}', 'DocumentsController@show');

    // Manage User Admin
    Route::get('manage', 'MyAdminController@manage');
    Route::get('manage/filter', 'MyAdminController@filter_manage');
    Route::get('manage/{myAdmin}', 'MyAdminController@show');
    Route::delete('manage/{myAdmin}', 'MyAdminController@destroy');
    Route::get('manage/{myAdmin}/edit', 'MyAdminController@edit');
    Route::patch('manage/{myAdmin}', 'MyAdminController@update');

    //Message Admin
    Route::get('message', 'MessagesController@list');
    Route::get('message/{message}', 'MessagesController@show');
    Route::delete('message/{message}', 'MessagesController@destroy');

    //Profile Admin
    Route::get('profile', 'MyAdminController@showProfile');
    Route::post('profile/{myAdmin}', 'MyAdminController@updateProfile');

    //Asset Admin
    Route::get('asset', 'AssetController@list');
    Route::get('asset/filter', 'AssetController@filter_list');
    Route::get('asset/add', 'AssetController@create');
    Route::post('asset/add', 'AssetController@store');
    Route::post('asset/getCities', 'AssetController@getCities');
    Route::get('asset/{asset}', 'AssetController@show_detail');
    Route::get('asset/{asset}/edit', 'AssetController@edit');
    Route::patch('asset/{asset}', 'AssetController@update');
    Route::post('asset/deleteImage', 'AssetController@deleteImage');
    Route::delete('asset/{asset}', 'AssetController@destroy');
});

// USER
Route::group(['prefix' => 'dashboard/user', 'middleware' => ['user']], function () {
    Route::get('message', 'MessagesController@list');
    Route::get('message/{message}', 'MessagesController@show');
    Route::get('profile', 'MyAdminController@showProfile');
    Route::post('profile/{myAdmin}', 'MyAdminController@updateProfile');
    Route::delete('message/{message}', 'MessagesController@Destroy');
});

Auth::routes();
Route::get('/dashboard', 'MyAdminController@index')->name('dashboard')->middleware('auth');
Route::get('change-password', 'ChangePasswordController@index');
Route::post('change-password', 'ChangePasswordController@store')->name('change.password');

// Pages User
Route::get('{pages}', 'PagesController@home');
Route::get('about/{pages}', 'PagesController@about');
Route::get('contact/{pages}', 'PagesController@contact');
Route::get('service/{pages}', 'PagesController@service');
Route::get('testimony/{pages}', 'PagesController@testimony');
Route::get('blog/{blog}/{pages}', 'BlogsController@show');
Route::get('asset/{asset}/{pages}', 'AssetController@show');
Route::get('documentation/{pages}', 'DocumentsController@index');

