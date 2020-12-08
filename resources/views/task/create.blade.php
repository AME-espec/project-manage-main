@extends('layouts.app')

@section('title', 'Crear Tarea')

@section('content')

	<div class="row">
		<div class="col-md-12">
		    <div class="card shadow mb-4">
		        <div class="card-header py-3">
		            <h6 class="m-0 font-weight-bold text-primary">
		            	Formulario para registrar nueva tarea

		            	<a href="{{ route('task.index') }}" class="btn btn-primary btn-sm float-right">Ver tareas</a>
		            </h6>
		        </div>
		        <div class="card-body">
		        	<form action="{{ route('task.store') }}" method="POST">
		        		@csrf

		        		<div class="form-group">
		        			<label for="id_proyecto">Proyecto: <strong class="text-danger">*</strong></label>
		        			<select name="id_proyecto" class="form-control" required="">
		        				<option value="">Seleccionar proyecto...</option>

		        				@foreach($proyectos as $proyecto)
		        					<option value="{{ $proyecto->id_proyecto }}">{{ $proyecto->nombre }}</option>
		        				@endforeach
		        			</select>
		        		</div>

		        		<div class="form-group">
		        			<label for="id_empleado">Empleados: <small>(opcional)</small></label>
							<select class="js-example-basic-multiple form-control" name="states[]" multiple="multiple">
	        					<!-- <option  value="" disabled="true">Seleccionar empleado...</option> -->

		        				@foreach($empleados as $empleado)
		        					<option value="{{ $empleado->id }}">{{ $empleado->name }}</option>
		        				@endforeach
		        			</select>
		        		</div>

		        		<div class="form-group">
		        			<label for="descripcion">Nombre de la tarea: <strong class="text-danger">*</strong></label>
		        			<input type="text" name="descripcion" class="form-control" maxlength="255" required="">
		        		</div>

		        		<div class="form-group">
		        			<label for="comentario">Comentario de la tarea: <strong class="text-danger">*</strong></label>
		        			<textarea name="comentario" class="form-control" required=""></textarea>
		        		</div>

		        		<!-- <div class="form-group">
		        			<label for="estatus">Estado: <strong class="text-danger">*</strong></label>
		        			<select name="estatus" class="form-control" required="">
		        				<option value="E">En espera</option>
		        				<option value="P">En proceso</option>
		        			</select>
		        		</div> -->

		        		<div class="form-group">
		        			<label for="fecha_inicio">Fecha inicio: <strong class="text-danger">*</strong> </label>
		        			<input type="date" name="fecha_inicio" class="form-control" required="">
		        		</div>

		        		<div class="form-group">
		        			<label for="fecha_final">Fecha final: <small>(opcional)</small></label>
		        			<input type="date" name="fecha_final" class="form-control">
		        		</div>

		        		<div class="form-group">
		        			<label for="fecha_limite">Fecha límite: <strong class="text-danger">*</strong></label>
		        			<input type="date" name="fecha_limite" class="form-control" required="">
		        		</div>

		        		<button type="submit" class="btn btn-success btn-sm btn-block">Guardar</button>
		        	</form>
		        </div>
		    </div>
		</div>
	</div>

@endsection