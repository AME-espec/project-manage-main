<?php

namespace App\Http\Controllers;

use App\User;
use App\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
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

        return view('project.index', [
            'proyectos' => Project::all()
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

        return view('project.create');
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

        $project = new Project;

        $project->create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'id_manager' => \Auth::user()->id
        ]);

        return redirect()->route('project.index');
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

        return view('project.edit', [
            'proyecto' => Project::find($id),
            'managers' => User::where('role', '=', 'M')->get()
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

        $project = Project::find($id);

        $project->nombre = $request->nombre;
        $project->descripcion = $request->descripcion;
        $project->id_manager = $request->id_manager;
        $project->update();

        return redirect()->route('project.index');
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

        $project = Project::find($id);

        $project->estado = '0';
        $project->update();

        return redirect()->route('project.index');
    }

    public function restore($id)
    {
        if(\Auth::user()->role == 'E')
            return redirect()->route('home');
        
        $project = Project::find($id);

        $project->estado = '1';
        $project->update();

        return redirect()->route('project.index');
    }
}
