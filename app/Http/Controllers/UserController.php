<?php

namespace App\Http\Controllers;

use App\Task;
use App\User;
use App\UsersTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
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

        return view('user.index', [
            'usuarios' => User::all()
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

        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(\Auth::user()->role == 'E')
            return redirect()->route('home');
        
        $rules = [
            'email' => 'required|email|unique:users'
        ];

        $messages = [
            'email.required' => 'El campo :attribute es requerido.',
            'email.email' => 'El campo :attribute debe ser tipo email.',
            'email.unique' => 'El email ingresado ya existe.'
        ];

        $this->validate($request, $rules, $messages);

        $user = new User;

        $user->create([
            'name' => $request->nombre,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role
        ]);

        return redirect()->route('user.index');
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
        //
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
        $user = User::find($id);

        // $user->nombre = $request->name;
        $user->password = bcrypt($request->password);
        $user->update();

        return redirect()->route('home');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function profile ($id)
    {
        if(\Auth::user()->role == 'E')
            return redirect()->route('home');

        return view('user.profile', [
            'usuario' => User::where('id',$id)->first(),
            'proyectos' => $this->ProyectsCount($id),
            'tareas' => UsersTask::where('user_id',$id)->count(),
            'pendientes' => $this->CountStatus($id,'P'),
            'completadas' => $this->CountStatus($id,'C'),
            'colaboradores' => $this->ColaboradoresCount($id),
            'tiempo_usado' => $this->TiempoUsado($id),
            'tiempo_ahorrado' => $this->TiempoAhorrado($id),
            'productividad' => $this->Productividad($id),

        ]);
    }

    private function ProyectsCount($id){
        $ut = UsersTask::where('user_id',$id)->pluck('id_tarea')->toArray();
        $c = 0;
        
        if ($ut) {
            $l = implode(', ', $ut);
            $c =  DB::select("select count(DISTINCT id_proyecto) as proyecto from tareas where id IN (".$l.");");
            return $c[0]->proyecto;
        }
        return $c;
    }

    private function CountStatus($id,$status){

        
        $ut = UsersTask::where('user_id',$id)->get();
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

    private function ColaboradoresCount($id){
        $ut = UsersTask::where('user_id',$id)->pluck('id_tarea')->toArray();
        $c = 0;
        
        if ($ut) {
            $l = implode(', ', $ut);
            $c =  DB::select("select count(DISTINCT user_id) as colaboradores from users_task where id_tarea  IN($l) and user_id != $id;");
            return $c[0]->colaboradores;
        }
        return $c;
    }

    private function TiempoUsado($id){
        $ut = UsersTask::where('user_id',$id)->pluck('id_tarea')->toArray();
        $c = 0;
        $total=0;
        if ($ut) {
            $l = implode(', ', $ut);
            $dates = DB::select("select CONCAT(FORMAT((DATEDIFF(t.fecha_final, t.fecha_inicio) / DATEDIFF(t.fecha_limite, t.fecha_inicio)) * 100, 2)) as date
        from tareas t where id in ($l) and estatus = 'C';");
            if($dates){
                foreach($dates as $d){
                    // print_r($d->date);
                    // exit;
                    $total += (int) $d->date;
                    
                }
                $c = ($total / count($dates)) * .100;
                return $c;
            }
        }
        return $c;
    }

    private function TiempoAhorrado($id){
        $ut = UsersTask::where('user_id',$id)->pluck('id_tarea')->toArray();
        $c = 0;
        $total=0;
        if ($ut) {
            $l = implode(', ', $ut);
            $dates = DB::select("select CONCAT(FORMAT(100 - (DATEDIFF(t.fecha_final, t.fecha_inicio) / DATEDIFF(t.fecha_limite, t.fecha_inicio)) * 100, 2)) as date
                from tareas t where id in ($l) and estatus = 'C';");
            if($dates){
                foreach($dates as $d){
                    // print_r($d->date);
                    // exit;
                    $total += (int) $d->date;
                    
                }
                $c = ($total / count($dates)) * 0.100 ;
                return $c;
            }
        }
        return $c;
    }

    private function Productividad($id){
        $ut = UsersTask::where('user_id',$id)->pluck('id_tarea')->toArray();
        $c = array();

        if ($ut) {
            $l = implode(', ', $ut);
            $dates = DB::select("Select CASE WHEN (100 - (DATEDIFF(t.fecha_final, t.fecha_inicio) / DATEDIFF(t.fecha_limite, t.fecha_inicio)) * 100) >= 50 THEN 'Excelente'
            WHEN (100 - (DATEDIFF(t.fecha_final, t.fecha_inicio) / DATEDIFF(t.fecha_limite, t.fecha_inicio)) * 100) BETWEEN 30 AND 49 THEN 'Eficiente'
            WHEN (100 - (DATEDIFF(t.fecha_final, t.fecha_inicio) / DATEDIFF(t.fecha_limite, t.fecha_inicio)) * 100) BETWEEN 0 AND 29 THEN 'Normal'
            ELSE 'Deficiente'
        END AS productividad from tareas t where id in ($l) and estatus = 'C';");
            if($dates){
                foreach($dates as $d){
                    
                    array_push($c,$d->productividad);
                }
                $value = max(array_count_values($c));
                return array_search($value, array_count_values($c));
            }

        }
        return "Sin resultados";
    }
}
