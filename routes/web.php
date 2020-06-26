<?php

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
Route::get('/about', 'PagesController@about');
Route::get('/contact', 'PagesController@contact');
Route::get('/asset', 'AssetController@index');
Route::get('/jasa', 'PagesController@jasa');
Route::get('/testimony', 'PagesController@testimony');
Route::get('/documentation', 'DocumentsController@index');
Route::get('/blog', 'BlogsController@index');
Route::get('/blog/{blog}', 'BlogsController@show');
Route::post('/pesan/add', 'MessagesController@store');
Route::post('/getCities', 'AssetController@getCities');
Route::post('/getAllCities', 'AssetController@getAllCities');
Route::post('/asset/filter', 'AssetController@filter');
Route::get('/asset/{asset}', 'AssetController@show');

//Admin
Route::group(['middleware' => ['admin']], function () {
    Route::prefix('dashboard/admin')->group(function () {
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
        Route::get('document/{document}', 'DocumentsController@show_detail');

        // Manage User Admin
        Route::get('manage', 'MyAdminController@manage');
        Route::get('manage/filter', 'MyAdminController@filter_manage');
        Route::get('manage/{myAdmin}', 'MyAdminController@show');
        Route::delete('manage/{myAdmin}', 'MyAdminController@destroy');
        Route::get('manage/{myAdmin}/edit', 'MyAdminController@edit');
        Route::patch('manage/{myAdmin}', 'MyAdminController@update');

        //Message Admin
        Route::get('message', 'MyAdminController@message');
        Route::get('message/{message}', 'MyAdminController@showMessage');
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
});

Auth::routes();
Route::get('/dashboard', 'MyAdminController@index')->name('dashboard')->middleware('auth');
Route::get('change-password', 'ChangePasswordController@index');
Route::post('change-password', 'ChangePasswordController@store')->name('change.password');

// USER
Route::group(['middleware' => ['user']], function () {
    Route::prefix('dashboard/user')->group(function () {
        Route::get('message', 'MyAdminController@userMessage');
        Route::get('message/{message}', 'MyAdminController@showUserMessage');
        Route::get('profile', 'MyAdminController@showUserProfile');
        Route::post('profile/{myAdmin}', 'MyAdminController@updateUserProfile');
        Route::delete('message/{message}', 'MessagesController@userMessageDestroy');
    });
});

// Pages User
Route::get('/{pages}', 'PagesController@home_user');
Route::get('about/{pages}', 'PagesController@about_user');
Route::get('contact/{pages}', 'PagesController@contact_user');
Route::get('blog/{pages}', 'BlogsController@index_user');
Route::get('blog/{blog}/{pages}', 'BlogsController@show_user');
Route::get('asset/{pages}', 'AssetController@index_user');
Route::get('asset/{asset}/{pages}', 'AssetController@show_user');
Route::get('jasa/{pages}', 'PagesController@jasa_user');
Route::get('testimony/{pages}', 'PagesController@testimony_user');
Route::get('documentation/{pages}', 'DocumentsController@index_user');
Route::post('pesan/add/{pages}', 'MessagesController@store');
