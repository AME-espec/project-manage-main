@extends('layouts.app')

@section('title', 'Usuarios')

@section('content')
	
	<div class="row">
		<div class="col-md-12">
			<!-- DataTales Example -->
		    <div class="card shadow mb-4">
		        <div class="card-header py-3">
		            <h6 class="m-0 font-weight-bold text-primary">
		            	Usuarios Registrados

		            	<a href="{{ route('user.create') }}" class="btn btn-primary btn-sm float-right">Crear nuevo</a>
		            </h6>
		        </div>
		        <div class="card-body">
		            <div class="table-responsive">
		                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
		                    <thead class="bg-primary text-white">
		                        <tr>
		                        	<th>Nombre</th>
		                            <th>Correo</th>
		                            <th>Rol</th>
		                            <th>Registrado</th>
		                             <th>Acciones</th> 
		                        </tr>
		                    </thead>
		                    <tfoot>
		                        <tr>
		                        	<th>Nombre</th>
		                            <th>Correo</th>
		                            <th>Rol</th>
		                            <th>Registrado</th>
		                            <th>Acciones</th> 
		                        </tr>
		                    </tfoot>
		                    <tbody>
		                    	@foreach($usuarios as $usuario)
			                        <tr>
			                            <td>{{ $usuario->name }}</td>
			                            <td>{{ $usuario->email }}</td>
			                            <td>{{ $usuario->roleDescription }}</td>
										<td>{{ $usuario->created_at }}</td>
										<td style="display: flex; justify-content: space-around;">
										@if($usuario->role == 'E')
											<a class="btn btn-info btn-sm" href="{{ route('user.profile', $usuario->id) }}">Detalles</a>
										@endif
			                            </td>
			                            {{-- <td style="display: flex; justify-content: space-around;">
			                            	<a class="btn btn-info btn-sm" href="{{ route('user.edit', $usuario->id) }}">Editar</a>

			                            	<form action="{{ route('user.destroy', $usuario->id) }}" method="POST">
			                            		@csrf
			                            		@method('DELETE')

			                            		<button class="btn btn-danger btn-sm">Eliminar</button>
			                            	</form>
			                            </td> --}}
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