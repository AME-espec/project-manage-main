<?php

use App\Task;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;

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

Route::get('user/user-profile/{id}', 'UserController@profile')
	->middleware('auth')
	->name('user.profile');

Route::get('/ajax-request', 'HomeController@pie')
	->middleware('auth');
	
Route::get('/all-tweets-csv', function() {
	$fileName = 'Productividad.csv';
	$tasks = DB::select("
                SELECT
                    p.nombre AS proyecto,
                    t.descripcion AS tarea,
                    t.id,
                    t.fecha_inicio,
                    t.fecha_final,
                    t.fecha_limite,
                    DATEDIFF(t.fecha_final, t.fecha_inicio) AS completado_en,
                    DATEDIFF(t.fecha_limite, t.fecha_inicio) AS tiempo_limite,
                    CONCAT(FORMAT((DATEDIFF(t.fecha_final, t.fecha_inicio) / DATEDIFF(t.fecha_limite, t.fecha_inicio)) * 100, 2), '%') AS tiempo_usado,
                    CONCAT(FORMAT(100 - (DATEDIFF(t.fecha_final, t.fecha_inicio) / DATEDIFF(t.fecha_limite, t.fecha_inicio)) * 100, 2), '%') AS tiempo_ahorrado,
                    CASE
                        WHEN (100 - (DATEDIFF(t.fecha_final, t.fecha_inicio) / DATEDIFF(t.fecha_limite, t.fecha_inicio)) * 100) >= 50 THEN 'Excelente'
                        WHEN (100 - (DATEDIFF(t.fecha_final, t.fecha_inicio) / DATEDIFF(t.fecha_limite, t.fecha_inicio)) * 100) BETWEEN 30 AND 49 THEN 'Eficiente'
                        WHEN (100 - (DATEDIFF(t.fecha_final, t.fecha_inicio) / DATEDIFF(t.fecha_limite, t.fecha_inicio)) * 100) BETWEEN 0 AND 29 THEN 'Normal'
                        ELSE 'Deficiente'
                    END AS productividad
                FROM
                    tareas AS t
                        INNER JOIN
                    proyectos AS p ON t.id_proyecto = p.id_proyecto
                       
                WHERE
                    t.estatus = 'C'
                ;
            ");
 
		 $headers = array(
			 "Content-type"        => "text/csv",
			 "Content-Disposition" => "attachment; filename=$fileName",
			 "Pragma"              => "no-cache",
			 "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
			 "Expires"             => "0"
		 );
 
		 $columns = array(
		 'Proyecto',
		 'Tarea',
		 'Empleado',
		 'Inicio',
		 'Fin',
		 'Límite',
		 'Realizado',
		 'Tiempo Límite',
		 'Tiempo usado',
		 'Tiempo ahorrado',
		 'Productividad'
		);
 
		 $callback = function() use($tasks, $columns) {
			 $file = fopen('php://output', 'w');
			 fputcsv($file, $columns);
 
			 foreach ($tasks as $task) {
		
				$tmp = \App\UsersTask::employes($task->id);
			
				$row['Proyecto'] = $task->proyecto;
				 $row['Tarea'] = $task->tarea;
				 $row['Empleado'] = ($tmp?$tmp:" Sin Asignaciones");
				 $row['Inicio'] = $task->fecha_inicio;
				 $row['Fin'] = $task->fecha_final;
				 $row['Límite'] = $task->fecha_limite;
				 $row['Realizado'] = $task->completado_en;
				 $row['Tiempo Límite'] = $task->tiempo_limite;
				 $row['Tiempo usado'] = $task->tiempo_usado;
				 $row['Tiempo ahorrado'] = $task->tiempo_ahorrado;
				 $row['Productividad'] = $task->productividad;
			
 
				 fputcsv($file, array(
					 $row['Proyecto'],
		 			 $row['Tarea'],
		 			 $row['Empleado'],
		 			 $row['Inicio'],
		 			 $row['Fin'],
		 			 $row['Límite'],
		 			 $row['Realizado'],
		 			 $row['Tiempo Límite'],
		 			 $row['Tiempo usado'],
		 			 $row['Tiempo ahorrado'],
		 			 $row['Productividad']
					));
			 }
 
			 fclose($file);
		 };
 
		 return response()->stream($callback, 200, $headers);
});