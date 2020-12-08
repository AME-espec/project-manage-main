@extends('layouts.app')

@section('title', 'Seguimiento de Tareas')

@section('content')
	
	<div class="row">
		<div class="col-md-12">
			<!-- DataTales Example -->
		    <div class="card shadow mb-4">
		        <div class="card-header py-3">
		            <h6 class="m-0 font-weight-bold text-primary">
		            	Progreso de los empleados
		            </h6>
		        </div>
		        <div class="card-body">
		            <div class="table-responsive">
		                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
		                    <thead class="bg-primary text-white">
		                        <tr>
		                        	<th>Proyecto</th>
		                            <th>Tarea</th>
		                            <th>Empleado</th>
		                            <th>Fecha Inicio</th>
		                            <th>Fecha Fin</th>
		                            <th>Fecha Límite</th>
		                            <th>Realizado en</th>
		                            <th>Tiempo Límite</th>
		                            <th>Tiempo Usado</th>
		                            <th>Tiempo Ahorrado</th>
		                            <th>Productividad</th>
		                        </tr>
		                    </thead>
		                    <tfoot>
		                        <tr>
		                        	<th>Proyecto</th>
		                            <th>Tarea</th>
		                            <th>Empleado</th>
		                            <th>Inicio</th>
		                            <th>Fin</th>
		                            <th>Límite</th>
		                            <th>Realizado en</th>
		                            <th>Tiempo Límite</th>
		                            <th>Tiempo usado</th>
		                            <th>Tiempo ahorrado</th>
		                            <th>Productividad</th>
		                        </tr>
		                    </tfoot>
		                    <tbody>
		                    	@foreach($progresos as $progreso)
			                        <tr>
			                            <td>{{ $progreso->proyecto }}</td>
			                            <td>{{ $progreso->tarea }}</td>
										<?php
											$tmp = \App\UsersTask::employes($progreso->id);
										?>
			                            <td>@if($tmp) {{ $tmp }} @else Sin asignaciones @endif </td>
			                            <td>{{ $progreso->fecha_inicio }}</td>
			                            <td>{{ $progreso->fecha_final }}</td>
			                            <td>{{ $progreso->fecha_limite }}</td>
			                            <td>{{ $progreso->completado_en }}</td>
			                            <td>{{ $progreso->tiempo_limite }}</td>
			                            <td>{{ $progreso->tiempo_usado }}</td>
			                            <td>{{ $progreso->tiempo_ahorrado }}</td>
			                            <td>
			                            	@if($progreso->productividad == 'Excelente')
                                                <span class="badge badge-success" style="padding: .4em .6em; font-size: 85%;">{{ $progreso->productividad }}</span>
                                            @elseif($progreso->productividad == 'Eficiente')
                                               <span class="badge badge-primary" style="padding: .4em .6em; font-size: 85%;">{{ $progreso->productividad }}</span>
                                            @elseif($progreso->productividad == 'Normal')
                                               <span class="badge badge-warning" style="padding: .4em .6em; font-size: 85%;">{{ $progreso->productividad }}</span>
                                            @else
                                            	<span class="badge badge-danger" style="padding: .4em .6em; font-size: 85%;">{{ $progreso->productividad }}</span>
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