@extends('layouts.app')

@section('title', 'Crear Usuario')

@section('content')

	<div class="row">
		<div class="col-md-12">
		    <div class="card shadow mb-4">
		        <div class="card-header py-3">
		            <h6 class="m-0 font-weight-bold text-primary">
		            	Formulario para registrar nuevo usuario

		            	<a href="{{ route('user.index') }}" class="btn btn-primary btn-sm float-right">Ver usuarios</a>
		            </h6>
		        </div>
		        <div class="card-body">
		        	@include('errors')

		        	<form action="{{ route('user.store') }}" method="POST">
		        		@csrf

		        		<div class="form-group">
		        			<label for="nombre">Nombre del usuario: <strong class="text-danger">*</strong></label>
		        			<input type="text" name="nombre" class="form-control" maxlength="255" required="" value="{{ old('nombre') }}">
		        		</div>

		        		<div class="form-group">
		        			<label for="email">Correo electrónico: <strong class="text-danger">*</strong></label>
		        			<input type="text" name="email" class="form-control" maxlength="255" required="" value="{{ old('email') }}">
		        		</div>

		        		<div class="form-group">
		        			<label for="password">Contraseña: <strong class="text-danger">*</strong> <button type="button" class="btn btn-sm btn-dark" id="ver-contraseña" style="padding: 0px 6px; font-size: 12px;">Ver contraseña</button></label>
		        			<input type="password" name="password" class="form-control" maxlength="255" required="">
		        		</div>

		        		<div class="form-group">
		        			<label for="role">Rol de usuario: <strong class="text-danger">*</strong></label>
		        			<select name="role" class="form-control" required="">
		        				<option value="M" @if(old('role') == 'M') selected="" @endif>Gestor de proyecto</option>
		        				<option value="E" @if(old('role') == 'R') selected="" @endif>Empleado</option>
		        			</select>
		        		</div>

		        		<button type="submit" class="btn btn-success btn-sm btn-block">Guardar</button>
		        	</form>
		        </div>
		    </div>
		</div>
	</div>

@endsection