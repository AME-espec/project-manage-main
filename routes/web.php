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

Route::get('/', function () {

	return redirect()->route('login');
    // return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::resource('project', 'ProjectController')->middleware('auth');
Route::resource('task', 'TaskController')->middleware('auth');
Route::resource('user', 'UserController')->middleware('auth');

Route::post('take-task/{id}', 'TaskController@takeTask')
	->middleware('auth')
	->name('task.take');

Route::post('end-task/{id}', 'TaskController@endTask')
	->middleware('auth')
	->name('task.end');

Route::post('restore-task/{id}', 'TaskController@restore')
	->middleware('auth')
	->name('task.restore');

Route::post('restore-project/{id}', 'ProjectController@restore')
	->middleware('auth')
	->name('project.restore');

Route::get('seguimiento-tareas', 'TaskController@seguimiento')
	->middleware('auth')
	->name('task.progress');