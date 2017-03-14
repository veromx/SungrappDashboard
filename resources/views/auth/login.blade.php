@extends('layouts.master')

@section('content')
<h1>Iniciar sesión en el sistema</h1>
<p><a href="{{ action('Auth\RegisterController@showRegistrationForm') }}">Registrarse como usuario</a></p>

<form class="form-horizontal" id="login" method="POST" action="{{action('Auth\LoginController@login')}}">

	<div class="form-group row">
		<label class="control-label col-sm-2" for="email">Email</label>
		<div class="col-sm-10">
			<input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
		</div>
	</div>

	<div class="form-group row">
		<label class="control-label col-sm-2" for="password">Password</label>
		<div class="col-sm-10">
			<input type="password" name="password" id="password" class="form-control" required>
		</div>
	</div>

	<button type="submit" class="btn btn-primary">Login</button>

</form>

@endsection
