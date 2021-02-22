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

    Route::get('/user/logout','Authenticate\UserController@logout');
    Route::get('/user','Authenticate\UserController@getUser');
});

Route::middleware(['auth:admin','adminTokenValidate'])->group(function () {

    Route::delete('/admin/level','LevelManage\LevelTeacherController@delete');
    Route::get('/admin/level','LevelManage\LevelTeacherController@getAll');
    Route::delete('/admin/level','LevelManage\LevelTeacherController@delete');
    Route::post('/admin/level/findLevel','LevelManage\LevelTeacherController@findLevel');
//    Route::get('/admin/posts','AdminController@getAllPosts');
    Route::post('/admin/level','LevelManage\LevelTeacherController@store');
    Route::get('/admin/logout','Authenticate\AdminController@logout');
    Route::get('/admin','Authenticate\AdminController@getAdmin');


    Route::get('/teacher','AccountManage\UserManageController@getAllUser');
    Route::post('/teacher','AccountManage\UserManageController@store');
    Route::put('/teacher/{id}','AccountManage\UserManageController@update');
    Route::delete('/teacher/{id}','AccountManage\UserManageController@delete');
    Route::get('/teacher/{id}','AccountManage\UserManageController@show');
    Route::put('/addLevelTecher/{id}','AccountManage\UserManageController@addLevelTeacher');

//    Route::get('/teacher','UserManageController@index');

    Route::get('/student','AccountManage\StudentManageController@getAllStudent');
    Route::post('/student','AccountManage\StudentManageController@store');
    Route::put('/student/{id}','AccountManage\StudentManageController@update');
    Route::delete('/student/{id}','AccountManage\StudentManageController@delete');
    Route::get('/student/{id}','AccountManage\StudentManageController@show');
});

Route::middleware(['auth:student','studentTokenValidate'])->group(function (){
    Route::get('/student/logout','Authenticate\StudentLoginController@logout');
//    Route::get('/','Authenticate\AdminController@getAdmin');
});

Route::post('/user/register','Authenticate\UserController@register');

Route::post('/user/login','Authenticate\UserController@login');


Route::post('/admin/register','Authenticate\AdminController@register');

Route::post('/admin/login','Authenticate\AdminController@login');

Route::post('/student/register','Authenticate\StudentLoginController@register');

Route::post('/student/login','Authenticate\StudentLoginController@login');
