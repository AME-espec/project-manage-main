@extends('layouts.app')

@section('title', 'Perfil del ' .$usuario->name)

@section('content')

<div class="row">
	<div class="col-md-2">
	<a class="btn btn-info" href="{{ route('user.index') }}">< Atrás</a>
	</div><br><br><br>

</div>

<div class="row">
<div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Productividad</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $productividad }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
			<div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Tiempo Usado</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $tiempo_usado}}%</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
			<div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Tiempo ahorrado</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $tiempo_ahorrado }}%</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
	</div>
	<div class="row">
		<div class="col-md-9">
			<!-- DataTales Example -->
		    <div class="card shadow mb-4">
		        <div class="card-header py-3">
		            <h6 class="m-0 font-weight-bold text-primary">
		            	Detalles
		            </h6>
		        </div>
		        <div class="card-body">
					<ul class="list-group">
					<li class="list-group-item d-flex justify-content-between align-items-center">
					    Proyectos 
					    <span class="badge badge-primary badge-pill">{{ $proyectos }}</span>
					  </li>
					  <li class="list-group-item d-flex justify-content-between align-items-center">
					    Tareas
					    <span class="badge badge-primary badge-pill">{{ $tareas }}</span>
					  </li>
					  <li class="list-group-item d-flex justify-content-between align-items-center">
					    Tareas Pendientes
					    <span class="badge badge-primary badge-pill">{{ $pendientes }}</span>
					  </li>
					  <li class="list-group-item d-flex justify-content-between align-items-center">
					  	Tareas Completadas
					    <span class="badge badge-primary badge-pill">{{ $completadas }}</span>
					  </li>
					  <li class="list-group-item d-flex justify-content-between align-items-center">
					  	Colaboradores
					    <span class="badge badge-primary badge-pill">{{ $colaboradores }}</span>
					  </li>
					</ul>

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