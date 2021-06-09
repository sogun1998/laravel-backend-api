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
    Route::get('/teacher/get/{id}','AccountManage\UserManageController@show');

    Route::get('teacher/class/{id}','ClassManage\ClassController@show');
    Route::get('teacher/search','AccountManage\StudentManageController@search');
    Route::post('teacher/class/add','ClassManage\ClassController@addStudent');
    Route::post('teacher/class/remove','ClassManage\ClassController@removeStudent');
    Route::get('teacher/class/list_student/{id}','ClassManage\ClassController@listStudent');
    Route::get('teacher/class/list_parent/{id}','ClassManage\ClassController@listParent');
    Route::get('teacher/class/list_student/{id}/class_subject/{subjectClass}','ClassManage\ClassController@listStudentInTeachClass');
    Route::get('teacher/form_class/{id}','ClassManage\ClassController@getListClassControl');
    Route::get('teacher/student/{id}','AccountManage\StudentManageController@show');
    Route::put('/teacher/student/{id}','AccountManage\StudentManageController@update');
    Route::get('teacher/analyze/{id}','AccountManage\UserManageController@analyze');
    Route::get('teacher/getInfo/{id}','AccountManage\UserManageController@teacherStatus');
    Route::post('teacher/test/','TestManage\TestController@store');
    Route::get('teacher/test/{classSubject_id}','TestManage\TestController@index');
    Route::get('teacher/test/show/{id}','TestManage\TestController@show');
    Route::put('teacher/test/{id}','TestManage\TestController@update');
    Route::delete('teacher/test/{id}','TestManage\TestController@delete');
    Route::get('teacher/mark_detail/{test_id}','MarkDetailManage\MarkDetailController@indexFromTest');
    Route::put('/teacher/score/{id}','MarkDetailManage\MarkDetailController@update');
    Route::get('/teacher/score/{id}','MarkDetailManage\MarkDetailController@show');
    Route::post('teacher/hictory/send','MarkDetailManage\MarkHictoryController@store');
    Route::post('teacher/hictory/change','MarkDetailManage\MarkHictoryController@change');

    Route::get('teacher/student/{student}/class_sub/{classSubject_id}','AchievementManage\AchievementController@index');
    Route::get('teacher/chart/student/{student}/class_sub/{classSubject_id}','AchievementManage\AchievementController@initChart');
    Route::get('teacher/achievement/student/{student}','AchievementManage\AchievementController@subject_study');


    Route::post('teacher/conduct','ConductManage\ConductController@store');
    Route::get('teacher/conduct/student/{student}/class_sub/{classSubject_id}','ConductManage\ConductController@index');
    Route::get('teacher/conduct/student/{student}','ConductManage\ConductController@getAll');
    Route::get('teacher/conduct/avg/student/{student}','ConductManage\ConductController@average');
    Route::post('teacher/conduct/summary','ConductManage\ConductSummaryController@store');

    Route::get('teacher/parent/{id}','AccountManage\PhuhuynhManageController@show');
    Route::put('teacher/parent/{id}','AccountManage\PhuhuynhManageController@update');
    Route::post('teacher/parent/','AccountManage\PhuhuynhManageController@store');
    Route::get('teacher/student/parent/{id}','AccountManage\PhuhuynhManageController@showFromStudent');
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
    Route::get('/admin/teacher/count','AccountManage\UserManageController@countByMonth');
    Route::get('/admin/student/count','AccountManage\StudentManageController@countByMonth');
    Route::get('/admin/parent/count','AccountManage\PhuhuynhManageController@countByMonth');

//    Route::get('/teacher','UserManageController@index');
    Route::get('/student','AccountManage\StudentManageController@getTotalStudent');
    Route::get('/admin/student','AccountManage\StudentManageController@getAllStudent');
    Route::post('/student','AccountManage\StudentManageController@store');
    Route::put('/admin/student/{id}','AccountManage\StudentManageController@update');
    Route::delete('/student/{id}','AccountManage\StudentManageController@delete');
    Route::get('/admin/student/{id}','AccountManage\StudentManageController@show');
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
    Route::get('admin/subject/all','SubjectManage\SubjectController@all');
    Route::get('admin/subject/{id}','SubjectManage\SubjectController@show');
    Route::delete('admin/subject/{id}','SubjectManage\SubjectController@delete');
    Route::put('/admin/subject/{id}','SubjectManage\SubjectController@update');
    Route::post('/admin/assign/upload','AssignManage\AssignController@upload');
    Route::delete('/admin/assign/{id}','AssignManage\AssignController@delete');
    Route::get('/admin/assign/','AssignManage\AssignController@index');
    Route::get('/admin/assign/{id}','AssignManage\AssignController@show');
    Route::put('/admin/assign/{id}','AssignManage\AssignController@update');

    Route::post('/admin/hictory/accept','MarkDetailManage\MarkHictoryController@accept');
    Route::post('/admin/hictory/refuse','MarkDetailManage\MarkHictoryController@refuse');
    Route::get('/admin/hictory/','MarkDetailManage\MarkHictoryController@index');
    Route::get('/admin/hictory/detail/','MarkDetailManage\MarkHictoryController@detail');

});

Route::middleware(['auth:student','studentTokenValidate'])->group(function (){
    Route::get('/student/logout','Authenticate\StudentLoginController@logout');
    Route::put('/student/{id}','AccountManage\StudentManageController@update');
//    Route::get('/','Authenticate\AdminController@getAdmin');
    Route::get('student/{student}/class_sub/{classSubject_id}','AchievementManage\AchievementController@index');
    Route::get('student/chart/student/{student}/class_sub/{classSubject_id}','AchievementManage\AchievementController@initChart');
    Route::get('student/achievement/{student}','AchievementManage\AchievementController@subject_study');

    Route::get('student/conduct/{student}','ConductManage\ConductController@getAll');
    Route::get('student/conduct/avg/student/{student}','ConductManage\ConductController@average');
    Route::get('student/{id}','AccountManage\StudentManageController@show');
});
Route::middleware(['auth:phuhuynh','phuhuynhTokenValidate'])->group(function (){
    Route::get('/parent/logout','Authenticate\PhuhuynhController@logout');
    Route::put('/parent/{id}','AccountManage\PhuhuynhManageController@update');
    Route::get('/parent/{id}','AccountManage\PhuhuynhManageController@show');
    Route::get('/parent/achievement/{student}','AchievementManage\AchievementController@subject_study');
    Route::get('/parent/chart/student/{student}/class_sub/{classSubject_id}','AchievementManage\AchievementController@initChart');
    Route::get('phuhuynh/messages', 'ChatManage\ChatController@index');
    Route::post('/parent/messages', 'ChatManage\ChatController@store');
    Route::post('/parent/room', 'ChatManage\ChatController@makeRoom');
    Route::get('/parent/room/{id}','ChatManage\ChatController@showRoom');
    Route::get('/parent/getKeyTeacher/{id}','ChatManage\ChatController@getKeyTeacher');
});

Route::post('/user/register','Authenticate\UserController@register');

Route::post('/user/login','Authenticate\UserController@login');


Route::post('/admin/register','Authenticate\AdminController@register');

Route::post('/admin/login','Authenticate\AdminController@login');

Route::post('/student/register','Authenticate\StudentLoginController@register');

Route::post('/student/login','Authenticate\StudentLoginController@login');

Route::post('/parent/register','Authenticate\PhuhuynhController@register');

Route::post('/parent/login','Authenticate\PhuhuynhController@login');

