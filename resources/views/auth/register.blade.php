@extends('layouts.master')

@section('content')
<h1>Registro de usuario</h1>
<p><a href="{{ action('Auth\LoginController@showLoginForm') }}">Iniciar sesión en el sistema</a></p>

<form id="register" method="POST" action="{{action('Auth\RegisterController@register')}}">

	<div class="form-group row">
		<label for="first_name">First name</label>
		<input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name') }}" required>
	</div>

	<div class="form-group row">
		<label for="last_name">Last name</label>
		<input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name') }}">
	</div>

	<div class="form-group row">
		<label for="email">Email</label>
		<input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
	</div>

	<div class="form-group row">
		<label for="password">Password</label>
		<input type="password" name="password" id="password" class="form-control" required>
	</div>

	<div class="form-group row">
		<label for="password_confirmation">Confirm password</label>
		<input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
	</div>

	<div class="form-group row">
		<label for="user_type">Type of user</label>
		<input type="text" name="user_type" id="user_type" class="form-control" value="{{ old('user_type') }}" required>
	</div>

	<button type="submit" class="btn btn-primary">Registro</button>

</form>

@endsection
