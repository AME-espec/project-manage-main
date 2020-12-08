<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use \App\Task;
use \App\User;
use \App\Project;
use App\UsersTask;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(\Auth::user()->role == 'E')
            return redirect()->route('home');

        return view('task.index', [
            // 'tareas' => DB::table('tareas')
            //                 ->join('proyectos', 'tareas.id_proyecto', '=', 'proyectos.id_proyecto')
            //                 ->leftJoin('users', 'tareas.id_empleado', '=', 'users.id')
            //                 ->select('tareas.*', DB::raw('users.name as empleado'), DB::raw('proyectos.nombre as proyecto'), DB::raw('CAST(tareas.fecha_registro AS DATE) as fecha_registro'))
            //                 ->where('proyectos.estado', '=', 1)
            //                 ->get()
            'tareas' => DB::table('tareas')
                            ->join('proyectos', 'tareas.id_proyecto', '=', 'proyectos.id_proyecto')
                            ->select('tareas.*', DB::raw('proyectos.nombre as proyecto'), DB::raw('CAST(tareas.fecha_registro AS DATE) as fecha_registro'))
                            ->where(['proyectos.estado' => 1, 'tareas.estado' => '1'])
                            ->get(),
            'tareas_eliminadas' => DB::table('tareas')
                            ->join('proyectos', 'tareas.id_proyecto', '=', 'proyectos.id_proyecto')
                            ->select('tareas.*', DB::raw('proyectos.nombre as proyecto'), DB::raw('CAST(tareas.fecha_registro AS DATE) as fecha_registro'))
                            ->where(['proyectos.estado' => 1,'tareas.estado' => '0'])
                            ->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(\Auth::user()->role == 'E')
            return redirect()->route('home');

        return view('task.create', [
            'tareas' => Task::all(),
            'empleados' => User::where('role', '=', 'E')->get(),
            'proyectos' => Project::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    //    return $request->all();
        
        if(\Auth::user()->role == 'E')
            return redirect()->route('home');

        $task = new Task;
        $task->create([
            'id_proyecto' => $request->id_proyecto,
            'descripcion' => $request->descripcion,
            'comentario' => $request->comentario,
            // 'id_empleado' => (strlen($request->id_empleado) > 0) ? $request->id_empleado : null,
            'estatus' => (empty($request->states)  ? 'E' : 'P'),
            'fecha_inicio' => ($request->id_empleado != '' && is_null($request->fecha_inicio)) ? date('Y-m-d') : $request->fecha_inicio ?? null,
            'fecha_final' => $request->fecha_final ?? null,
            'fecha_limite' => $request->fecha_limite
        ]);

        $last = Task::orderBy('id', 'desc')->first();
        
        if (!empty($request->states)) {
            foreach ($request->states as $state) {
                $usersTask = new UsersTask();
                $usersTask->create([
                'id_tarea' => $last->id,
                'user_id' => $state
            ]);
            }
        }

        return redirect()->route('task.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(\Auth::user()->role == 'E')
            return redirect()->route('home');

        return view('task.edit', [
            'tarea' => Task::find($id),
            'empleados' => User::where('role', '=', 'E')->get(),
            'proyectos' => Project::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(\Auth::user()->role == 'E')
            return redirect()->route('home');

        $task = Task::find($id);
        $val_usr =  UsersTask::where('id_tarea', $id)->count();
        $task->id_proyecto = $request->id_proyecto;
        $task->descripcion = $request->descripcion;
        $task->comentario = $request->comentario;
        // $task->id_empleado = (strlen($request->id_empleado) > 0) ? $request->id_empleado : null;
        $task->estatus = (empty($request->states || $val_usr < 1 )  ? 'E' : 'P');
        $task->fecha_inicio = ($request->id_empleado != '' && is_null($request->fecha_inicio)) ? date('Y-m-d') : $request->fecha_inicio ?? null;
        $task->fecha_final = $request->fecha_final ?? null;
        $task->fecha_limite = $request->fecha_limite;
        $task->update();      
        
        // return  $request->states;
            UsersTask::where('id_tarea', $id)->delete();
        if (!empty($request->states)) {
            foreach ($request->states as $state) {
                $usersTask = new UsersTask();
                $usersTask->create([
                    'id_tarea' => $id,
                    'user_id' => (int) $state
                ]);
            }
        }
        
        

        return redirect()->route('task.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(\Auth::user()->role == 'E')
            return redirect()->route('home');

        $task = Task::find($id);

        $task->estado = '0';
        $task->update();

        return redirect()->route('task.index');
    }

    public function restore($id)
    {
        if(\Auth::user()->role == 'E')
            return redirect()->route('home');
        
        $task = Task::find($id);

        $task->estado = '1';
        $task->update();

        return redirect()->route('task.index');
    }

    public function takeTask ($id)
    {
        $task = Task::find($id);

        $task->id_empleado = Auth::user()->id;
        $task->estatus = 'P';
        $task->fecha_inicio = date('Y-m-d');
        $task->update();

        return redirect()->route('home');
    }

    public function endTask ($id)
    {
        $task = Task::find($id);
        $user_id = \Auth::user()->id;

        $task->estatus = 'C';
        $task->completed_by = $user_id;
        $task->fecha_final = date('Y-m-d');

        $task->update();

        return redirect()->route('home');
    }

    public function seguimiento ()
    {
        if(\Auth::user()->role == 'E')
            return redirect()->route('home');

        return view('task.progress', [
            'progresos' => DB::select("
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
            ")
        ]);
    }
}
