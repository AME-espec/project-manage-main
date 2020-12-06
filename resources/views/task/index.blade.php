
@extends('layouts.app')

@section('title', 'Tareas')

@section('content')
	
	<div class="row">
		<div class="col-md-12">
			<!-- DataTales Example -->
		    <div class="card shadow mb-4">
		        <div class="card-header py-3">
		            <h6 class="m-0 font-weight-bold text-primary">
		            	Tareas Registradas

		            	<a href="{{ route('task.create') }}" class="btn btn-primary btn-sm float-right">Crear nueva</a>
		            </h6>
		        </div>
		        <div class="card-body">
		            <div class="table-responsive">
		                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
		                    <thead class="bg-primary text-white">
		                        <tr>
		                        	<th>Proyecto</th>
		                            <th>Tarea</th>
		                            <th>Comentario</th>
		                            <th>Estado</th>
		                            <th>Empleados</th>
		                            <th>Inicio</th>
		                            <th>Fin</th>
		                            <th>Límite</th>
		                            <th>Registrado</th>
		                            <th>Acciones</th>
		                        </tr>
		                    </thead>
		                    <tfoot>
		                        <tr>
		                        	<th>Proyecto</th>
		                            <th>Tarea</th>
		                            <th>Comentario</th>
		                            <th>Estado</th>
		                            <th>Empleados</th>
		                            <th>Inicio</th>
		                            <th>Fin</th>
		                            <th>Límite</th>
		                            <th>Registrado</th>
		                            <th>Acciones</th>
		                        </tr>
		                    </tfoot>
		                    <tbody>
								<!-- <?php// print_r($tareas); exit;?> -->
		                    	@foreach($tareas as $tarea)
			                        <tr>
			                            <td>{{ $tarea->proyecto }}</td>
			                            <td>{{ $tarea->descripcion }}</td>
			                            <td>{{ $tarea->comentario }}</td>
			                            <td>
			                            	@if($tarea->estatus == 'E')
                                                <span class="badge badge-warning">En Espera</span>
                                            @elseif($tarea->estatus == 'P')
                                               <span class="badge badge-info">En Proceso</span>
                                            @else
                                            	<span class="badge badge-success">Terminado</span>
                                            @endif
										</td>
										<?php
											$tmp = \App\UsersTask::employes($tarea->id);
										?>
			                            <td>@if($tmp) {{ $tmp }} @else Sin asignaciones @endif </td>
			                            <td>{{ $tarea->fecha_inicio }}</td>
			                            <td>{{ $tarea->fecha_final }}</td>
			                            <td>{{ $tarea->fecha_limite }}</td>
			                            <td>{{ $tarea->fecha_registro }}</td>
			                            <td style="display: flex; justify-content: space-around;">
			                            	<a class="btn btn-info btn-sm" href="{{ route('task.edit', $tarea->id) }}">Editar</a>

			                            	@if($tarea->estado == 1)
				                            	<form action="{{ route('task.destroy', $tarea->id) }}" method="POST">
				                            		@csrf
				                            		@method('DELETE')

				                            		<button class="btn btn-danger btn-sm">Eliminar</button>
				                            	</form>
				                            @endif

				                            @if($tarea->estado == 0)
				                            	<form action="{{ route('task.restore', $tarea->id) }}" method="POST">
				                            		@csrf

				                            		 <button style="margin-left:5px;" class="btn btn-success btn-sm"> Restaurar</button>
				                            	</form>
				                            @endif
			                            </td>
			                        </tr>
		                        @endforeach
		                    </tbody>
		                </table>
		            </div>
		        </div>
		    </div>
		</div>
	</div>

@endsection


@section('css')
	<link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection

@section('js')
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="js/demo/datatables-demo.js"></script>
@endsection