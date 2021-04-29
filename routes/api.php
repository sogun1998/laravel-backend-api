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
    Route::put('/user/{id}','AccountManage\UserManageController@update');

    Route::get('teacher/class/{id}','ClassManage\ClassController@show');
    Route::get('teacher/search','AccountManage\StudentManageController@search');
    Route::post('teacher/class/add','ClassManage\ClassController@addStudent');
    Route::post('teacher/class/remove','ClassManage\ClassController@removeStudent');
    Route::get('teacher/class/list_student/{id}','ClassManage\ClassController@listStudent');
    Route::get('teacher/form_class/{id}','ClassManage\ClassController@getListClassControl');
    Route::get('teacher/student/{id}','AccountManage\StudentManageController@show');
    Route::put('/teacher/student/{id}','AccountManage\StudentManageController@update');
    Route::get('teacher/analyze/{id}','AccountManage\UserManageController@analyze');
    Route::get('teacher/getInfo/{id}','AccountManage\UserManageController@teacherStatus');
});

Route::middleware(['auth:admin','adminTokenValidate'])->group(function () {

    Route::delete('/admin/level','LevelManage\LevelTeacherController@delete');
    Route::get('/admin/level','LevelManage\LevelTeacherController@getAll');
    Route::get('/admin/level/keyTeacher','LevelManage\LevelTeacherController@teccherCanbeKey');
    Route::delete('/admin/level','LevelManage\LevelTeacherController@delete');
    Route::post('/admin/level/findLevel','LevelManage\LevelTeacherController@findLevel');
//    Route::get('/admin/posts','AdminController@getAllPosts');

    Route::post('/admin/level','LevelManage\LevelTeacherController@store');
    Route::get('/admin/logout','Authenticate\AdminController@logout');
    Route::get('/admin','Authenticate\AdminController@getAdmin');


    Route::get('/admin/teacher','AccountManage\UserManageController@getAllUser');
    Route::get('/teacher','AccountManage\UserManageController@getTotalTeacher');
    Route::post('/teacher','AccountManage\UserManageController@store');
    Route::put('/teacher/{id}','AccountManage\UserManageController@update');
    Route::delete('/teacher/{id}','AccountManage\UserManageController@delete');
    Route::get('/teacher/{id}','AccountManage\UserManageController@show');
    Route::put('/addLevelTecher/{id}','AccountManage\UserManageController@addLevelTeacher');
    Route::put('/updateLevelTecher/{id}','AccountManage\UserManageController@updateLevelTeacher');
    Route::post('/teacher/delete', 'AccountManage\UserManageController@multiDelete');
    Route::put('/admin/teacher/upload','AccountManage\UserManageController@upload');

//    Route::get('/teacher','UserManageController@index');
    Route::get('/student','AccountManage\StudentManageController@getTotalStudent');
    Route::get('/admin/student','AccountManage\StudentManageController@getAllStudent');
    Route::post('/student','AccountManage\StudentManageController@store');
    Route::put('/admin/student/{id}','AccountManage\StudentManageController@update');
    Route::delete('/student/{id}','AccountManage\StudentManageController@delete');
    Route::get('/student/{id}','AccountManage\StudentManageController@show');
    Route::post('/student/delete', 'AccountManage\StudentManageController@multiDelete');
    Route::post('/admin/student/upload','AccountManage\StudentManageController@upload');

    Route::get('/class/getTotalClass','ClassManage\ClassController@getTotalClass');
    Route::get('admin/class','ClassManage\ClassController@getAllClass');
    Route::post('/class','ClassManage\ClassController@store');
    Route::get('/class/{id}','ClassManage\ClassController@show');
    Route::put('/class/{id}','ClassManage\ClassController@update');
    Route::delete('/class/{id}','ClassManage\ClassController@delete');
//    Route::post('/search','ClassManage\ClassController@search');

    Route::post('/admin/subject','SubjectManage\SubjectController@store');
    Route::get('admin/subject','SubjectManage\SubjectController@index');
    Route::get('admin/subject/{id}','SubjectManage\SubjectController@show');
    Route::delete('admin/subject/{id}','SubjectManage\SubjectController@delete');
    Route::put('/admin/subject/{id}','SubjectManage\SubjectController@update');
    Route::post('/admin/assign/upload','AssignManage\AssignController@upload');
    Route::delete('/admin/assign/{id}','AssignManage\AssignController@delete');
    Route::get('/admin/assign/','AssignManage\AssignController@index');
    Route::get('/admin/assign/{id}','AssignManage\AssignController@show');



});

Route::middleware(['auth:student','studentTokenValidate'])->group(function (){
    Route::get('/student/logout','Authenticate\StudentLoginController@logout');
    Route::put('/student/{id}','AccountManage\StudentManageController@update');
//    Route::get('/','Authenticate\AdminController@getAdmin');
});

Route::post('/user/register','Authenticate\UserController@register');

Route::post('/user/login','Authenticate\UserController@login');


Route::post('/admin/register','Authenticate\AdminController@register');

Route::post('/admin/login','Authenticate\AdminController@login');

Route::post('/student/register','Authenticate\StudentLoginController@register');

Route::post('/student/login','Authenticate\StudentLoginController@login');
