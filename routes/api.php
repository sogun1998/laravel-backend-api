<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:user','userTokenValidate'])->group(function () {

    Route::get('/user/post','PostController@get');

    Route::post('/user/post','PostController@store');

    // Route::patch('/user/post','PostController@update');

    Route::delete('/user/post','PostController@destroy');

    Route::get('/user/logout','UserController@logout');
    Route::get('/user','UserController@getUser');
});

Route::middleware(['auth:admin','adminTokenValidate'])->group(function () {

    Route::delete('/admin/level','LevelTeacherController@delete');
    Route::get('/admin/level','LevelTeacherController@getAll');
    Route::delete('/admin/level','LevelTeacherController@delete');
    Route::post('/admin/level/findLevel','LevelTeacherController@findLevel');
    Route::get('/admin/posts','AdminController@getAllPosts');
    Route::post('/admin/level','LevelTeacherController@store');
    Route::get('/admin/logout','AdminController@logout');
    Route::get('/admin','AdminController@getAdmin');


    Route::get('/teacher','UserManageController@getAllUser');

    Route::post('/teacher','UserManageController@store');
    Route::put('/teacher/{id}','UserManageController@update');
    Route::delete('/teacher/{id}','UserManageController@delete');
    Route::get('/teacher/{id}','UserManageController@show');
    Route::put('/addLevelTecher/{id}','UserManageController@addLevelTeacher');

//    Route::get('/teacher','UserManageController@index');
});


Route::post('/user/register','UserController@register');

Route::post('/user/login','UserController@login');


Route::post('/admin/register','AdminController@register');

Route::post('/admin/login','AdminController@login');
