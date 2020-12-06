<?php

namespace App\Http\Controllers;

use DB;
use App\Task;
use App\Project;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $tareas = null;
        $tareas_concluidas = null;

        if(\Auth::user()->role == 'E')
        {
            $user_id = \Auth::user()->id;

            // tareas en pendientes y en curso
            $tareas = DB::select("
                SELECT
                    p.nombre AS proyecto,
                    u.name AS usuario,
                    t.*
                FROM
                    proyectos AS p
                        INNER JOIN
                    tareas AS t ON p.id_proyecto = t.id_proyecto
                        LEFT JOIN
                    users AS u ON t.id_empleado = u.id
                WHERE
                    (t.id_empleado = '$user_id' OR t.id_empleado IS NULL)
                        AND t.estatus IN ('E', 'P')
                        AND p.estado = 1
                        AND t.estado = 1
                ;
            ");

            // tareas culminadas por el usuario
            $tareas_concluidas = DB::select("
                SELECT
                    p.nombre AS proyecto,
                    u.name AS usuario,
                    t.*
                FROM
                    proyectos AS p
                        INNER JOIN
                    tareas AS t ON p.id_proyecto = t.id_proyecto
                        LEFT JOIN
                    users AS u ON t.id_empleado = u.id
                WHERE
                    (t.id_empleado = '$user_id' OR t.id_empleado IS NULL)
                        AND t.estatus = 'C'
                        AND p.estado = 1
                        AND t.estado = 1
                ;
            ");
        }

        return view('home', [
            'proyectos' => Project::count(),
            'terminadas' => (\Auth::user()->role == 'M') ? Task::where('estatus', '=', 'C')->count() : Task::where(['estatus' => 'C', 'id_empleado' => \Auth::user()->id])->count(),
            'proceso' => (\Auth::user()->role == 'M') ? Task::where('estatus', '=', 'P')->count() : Task::where(['estatus' => 'P', 'id_empleado' => \Auth::user()->id])->count(),
            'pendientes' => Task::where('estatus', '=', 'E')->count(),
            'tareas' => $tareas,
            'tareas_concluidas' => $tareas_concluidas
        ]);
    }
}
