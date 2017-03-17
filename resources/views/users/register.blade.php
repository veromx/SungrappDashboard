@extends('layouts.master')

@section('content')
<h1>Registro de usuario</h1>

<form class="form px-4 py-2" id="register" method="POST" action="{{action('UserController@store')}}">

	<div class="form-group row">
		<label class="col-form-label col-sm-2" for="first_name">First name</label>
		<div class="col-sm-10">
			<input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name') }}" required>
		</div>
	</div>

	<div class="form-group row">
		<label class="col-form-label col-sm-2" for="last_name">Last name</label>
		<div class="col-sm-10">
			<input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name') }}">
		</div>
	</div>

	<div class="form-group row">
		<label class="col-form-label col-sm-2" for="email">Email</label>
		<div class="col-sm-10">
			<input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
		</div>
	</div>

	<div class="form-group row">
		<label class="col-form-label col-sm-2" for="password">Password</label>
		<div class="col-sm-10">
			<input type="password" name="password" id="password" class="form-control" required>
		</div>
	</div>

	<div class="form-group row">
		<label class="col-form-label col-sm-2" for="password_confirmation">Confirm password</label>
		<div class="col-sm-10">
			<input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
		</div>
	</div>

	<div class="form-group row">
		<label class="col-form-label col-sm-2" for="user_type">Tipo de usuario</label>
		<div class="col-sm-10">
			<select class="custom-select form-control" name="user_type" id="user_type">
				@foreach($user_type as $type)
					<option value="{{ $type['key'] }}">
					{{ $type['value'] }}</option>
				@endforeach
			</select>
		</div>
	</div>

	<button type="submit" class="btn btn-primary">Registro</button>

</form>

@endsection
