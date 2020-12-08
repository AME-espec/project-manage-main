<?php

namespace App\Http\Controllers;

use DB;
use App\Task;
use App\Project;
use App\UsersTask;
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
                    users_task as ut on id_tarea = t.id
                        LEFT JOIN
                    users AS u ON ut.user_id = u.id
                WHERE
                    (ut.user_id = '$user_id')
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
                    users_task as ut on id_tarea = t.id 
                        LEFT JOIN
                    users AS u ON ut.user_id = u.id
                WHERE
                    (ut.user_id = '$user_id')
                        AND t.estatus = 'C'
                        AND p.estado = 1
                        AND t.estado = 1
                ;
            ");
        }

        return view('home', [
            'proyectos' => Project::count(),
            'terminadas' => (\Auth::user()->role == 'M') ? Task::where('estatus', '=', 'C')->count() : $this->CountStatus('C'),
            'proceso' => (\Auth::user()->role == 'M') ? Task::where('estatus', '=', 'P')->count() : $this->CountStatus('P'),
            'pendientes' => Task::where('estatus', '=', 'E')->count(),
            'tareas' => $tareas,
            'tareas_concluidas' => $tareas_concluidas,
            'chart_proyectos' => Project::take(5)->orderBy('id_proyecto', 'DESC')->get()
        ]);
    }

    private function CountStatus($status){

        $user_id = \Auth::user()->id;
        $ut = UsersTask::where('user_id',$user_id)->get();
        $c = 0;

        if($ut){
            foreach($ut as $u){
                $find = Task::where(['estatus' => $status,'id'=>$u->id_tarea])->first();
                if($find){
                    $c = $c + 1;
                }
            }
            return $c;
        }
        return $c;
        
    }

    public function pie(Request $request){
        $c = array();
        $dates = DB::select("Select CASE WHEN (100 - (DATEDIFF(t.fecha_final, t.fecha_inicio) / DATEDIFF(t.fecha_limite, t.fecha_inicio)) * 100) >= 50 THEN 'Excelente'
            WHEN (100 - (DATEDIFF(t.fecha_final, t.fecha_inicio) / DATEDIFF(t.fecha_limite, t.fecha_inicio)) * 100) BETWEEN 30 AND 49 THEN 'Eficiente'
            WHEN (100 - (DATEDIFF(t.fecha_final, t.fecha_inicio) / DATEDIFF(t.fecha_limite, t.fecha_inicio)) * 100) BETWEEN 0 AND 29 THEN 'Normal'
            ELSE 'Deficiente'
        END AS productividad from tareas t where estatus = 'C';");
            if ($dates) {
                foreach ($dates as $d) {
                    array_push($c, $d->productividad);
                }
                $value = array_count_values($c);
                
            $response = array(
                'status' => 'success',
                'val' => $value,
                );
            return response()->json($response);
            }
        
    }


}
