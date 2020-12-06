@extends('layouts.app')

@section('title', 'Crear Proyecto')

@section('content')

	<div class="row">
		<div class="col-md-12">
		    <div class="card shadow mb-4">
		        <div class="card-header py-3">
		            <h6 class="m-0 font-weight-bold text-primary">
		            	Formulario para editar proyecto

		            	<a href="{{ route('project.index') }}" class="btn btn-primary btn-sm float-right">Ver proyectos</a>
		            </h6>
		        </div>
		        <div class="card-body">
		        	<form action="{{ route('project.update', $proyecto->id_proyecto) }}" method="POST">
		        		@csrf
		        		@method('PUT')

		        		<div class="form-group">
		        			<label for="id_manager">Manager: <strong class="text-danger">*</strong></label>
		        			<select name="id_manager" class="form-control">
	        					<option value="">Seleccionar manager...</option>

		        				@foreach($managers as $manager)
		        					<option value="{{ $manager->id }}" @if($proyecto->id_manager == $manager->id) selected="" @endif>{{ $manager->name }}</option>
		        				@endforeach
		        			</select>
		        		</div>

		        		<div class="form-group">
		        			<label for="nombre">Nombre del proyecto: <strong class="text-danger">*</strong></label>
		        			<input type="text" name="nombre" class="form-control" maxlength="255" required="" value="{{ $proyecto->nombre }}">
		        		</div>

		        		<div class="form-group">
		        			<label for="descripcion">Descripción del proyecto: <strong class="text-danger">*</strong></label>
		        			<textarea name="descripcion" class="form-control" required="">{{ $proyecto->descripcion }}</textarea>
		        		</div>

		        		<button type="submit" class="btn btn-success btn-sm btn-block">Guardar</button>
		        	</form>
		        </div>
		    </div>
		</div>
	</div>

@endsection