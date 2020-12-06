@extends('layouts.app')

@section('title', 'Crear Tarea')

@section('content')

	<div class="row">
		<div class="col-md-12">
		    <div class="card shadow mb-4">
		        <div class="card-header py-3">
		            <h6 class="m-0 font-weight-bold text-primary">
		            	Formulario para editar tarea

		            	<a href="{{ route('task.index') }}" class="btn btn-primary btn-sm float-right">Ver tareas</a>
		            </h6>
		        </div>
		        <div class="card-body">
		        	<form action="{{ route('task.update', $tarea->id) }}" method="POST">
		        		@csrf
		        		@method('PUT')

		        		<div class="form-group">
		        			<label for="id_proyecto">Proyecto: <strong class="text-danger">*</strong></label>
		        			<select name="id_proyecto" class="form-control" required="">
		        				<option value="" >Seleccionar proyecto...</option>

		        				@foreach($proyectos as $proyecto)
		        					<option value="{{ $proyecto->id_proyecto }}" @if($tarea->id_proyecto == $proyecto->id_proyecto) selected="" @endif>{{ $proyecto->nombre }}</option>
		        				@endforeach
		        			</select>
		        		</div>

		        		<div class="form-group">
		        			<label for="id_empleado">Empleado: <small>(opcional)</small></label>
		        			<select class="js-example-basic-multiple form-control" name="states[]" multiple="multiple">
	        					<!-- <option  disabled="true">Seleccionar empleado...</option> -->
								@foreach($empleados as $empleado)
								<?php $temp = \App\UsersTask::OneEmployee($empleado->id); ?>
		        					<option value="{{ $empleado->id }}" @if($temp) selected="" @endif>{{ $empleado->name }}</option>
		        				@endforeach
		        			</select>
		        		</div>

		        		<div class="form-group">
		        			<label for="descripcion">Nombre de la tarea: <strong class="text-danger">*</strong></label>
		        			<input type="text" name="descripcion" class="form-control" maxlength="255" required="" value="{{ $tarea->descripcion }}">
		        		</div>

		        		<div class="form-group">
		        			<label for="comentario">Comentario de la tarea: <strong class="text-danger">*</strong></label>
		        			<textarea name="comentario" class="form-control" required="">{{ $tarea->comentario }}</textarea>
		        		</div>

		        		<div class="form-group">
		        			<label for="estatus">Estado: <strong class="text-danger">*</strong></label>
		        			<select name="estatus" class="form-control" required="">
		        				<option value="E" @if($tarea->estatus == 'E') selected="" @endif>En espera</option>
		        				<option value="P" @if($tarea->estatus == 'P') selected="" @endif>En proceso</option>
		        			</select>
		        		</div>

		        		<div class="form-group">
		        			<label for="fecha_inicio">Fecha inicio: <small>(opcional)</small></label>
		        			<input type="date" name="fecha_inicio" class="form-control" value="{{ $tarea->fecha_inicio }}">
		        		</div>

		        		<div class="form-group">
		        			<label for="fecha_final">Fecha final: <small>(opcional)</small></label>
		        			<input type="date" name="fecha_final" class="form-control" value="{{ $tarea->fecha_final }}">
		        		</div>

		        		<div class="form-group">
		        			<label for="fecha_limite">Fecha límite: <strong class="text-danger">*</strong></label>
		        			<input type="date" name="fecha_limite" class="form-control" required="" value="{{ $tarea->fecha_limite }}">
		        		</div>

		        		<button type="submit" class="btn btn-success btn-sm btn-block">Guardar</button>
		        	</form>
		        </div>
		    </div>
		</div>
	</div>

@endsection