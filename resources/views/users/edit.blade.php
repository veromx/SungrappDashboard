@extends('layouts.master')

@section('content')

<h3>Editar usuario {{ $user['email'] }}</h3>

<form class="form px-4 py-2" action="{{ action('UserController@update', $user['id']) }}" method="POST">
	<input type="hidden" name="_method" value="PATCH">
	<div class="form-group row">
		<label class="col-form-label col-sm-2" for="first_name">Nombre</label>
		<div class="col-sm-10">
			<input class="form-control" type="text" name="first_name" id="first_name"
			value="{{ old('first_name', $user['first_name']) }}">
		</div>
	</div>

	<div class="form-group row">
		<label class="col-form-label col-sm-2" for="last_name">Apellidos</label>
		<div class="col-sm-10">
			<input class="form-control" type="text" name="last_name" id="last_name"
			value="{{ old('last_name', $user['last_name']) }}">
		</div>
	</div>

	<div class="form-group row">
		<label class="col-form-label col-sm-2" for="email">Correo electrónico</label>
		<div class="col-sm-10">
			<input class="form-control" type="email" name="email" id="email"
			value="{{ old('email', $user['email']) }}">
		</div>
	</div>

	<div class="form-group row">
		<label class="col-form-label col-sm-2" for="user_type">Tipo de usuario</label>
		<div class="col-sm-10">
			<select class="custom-select form-control" name="user_type" id="user_type">
				@foreach($user_type as $type)
					<option value="{{ $type['key'] }}"
					{{ old('user_type', $user['user_type'])===$type['key']?' selected':'' }}>
					{{ $type['value'] }}</option>
				@endforeach
			</select>
		</div>
	</div>

	<button type="submit" class="btn btn-primary">Enviar</button>
</form>

@endsection
