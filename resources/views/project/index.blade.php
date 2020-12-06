@extends('layouts.app')

@section('title', 'Proyectos')

@section('content')
	
	<div class="row">
		<div class="col-md-12">
			<!-- DataTales Example -->
		    <div class="card shadow mb-4">
		        <div class="card-header py-3">
		            <h6 class="m-0 font-weight-bold text-primary">
		            	Proyectos Resgitrados

		            	<a href="{{ route('project.create') }}" class="btn btn-primary btn-sm float-right">Crear nuevo</a>
		            </h6>
		        </div>
		        <div class="card-body">
		            <div class="table-responsive">
		                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
		                    <thead class="bg-primary text-white">
		                        <tr>
		                            <th>Nombre</th>
		                            <th>Descripción</th>
		                            <th>Tareas</th>
		                            <th>Manager</th>
		                            <th>Registrado</th>
		                            <th>Acciones</th>
		                        </tr>
		                    </thead>
		                    <tfoot>
		                        <tr>
		                            <th>Nombre</th>
		                            <th>Descripción</th>
		                            <th>Tareas</th>
		                            <th>Manager</th>
		                            <th>Registrado</th>
		                            <th>Acciones</th>
		                        </tr>
		                    </tfoot>
		                    <tbody>
		                    	@foreach($proyectos as $proyecto)
			                        <tr>
			                            <td>{{ $proyecto->nombre }}</td>
			                            <td>{{ $proyecto->descripcion }}</td>
			                            <td>{{ $proyecto->tasks->count() }}</td>
			                            <td>{{ $proyecto->manager->name }}</td>
			                            <td>{{ $proyecto->fecha_registro }}</td>
			                            <td style="display: flex; justify-content: space-around;">
											<a class="btn btn-info btn-sm" href="{{ route('project.edit', $proyecto->id_proyecto) }}">Editar</a>

											@if($proyecto->estado == 1)
										    	<form action="{{ route('project.destroy', $proyecto->id_proyecto) }}" method="POST">
										    		@csrf
										    		@method('DELETE')

										    		<button class="btn btn-danger btn-sm">Eliminar</button>
										    	</form>
										    @endif

										    @if($proyecto->estado == 0)
										    	<form action="{{ route('project.restore', $proyecto->id_proyecto) }}" method="POST">
										    		@csrf

										    		<button class="btn btn-success btn-sm">Restaurar</button>
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