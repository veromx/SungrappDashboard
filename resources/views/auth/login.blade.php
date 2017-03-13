@extends('layouts.master')

@section('content')
<form id="login" method="POST" action="{{action('Auth\LoginController@login')}}">

	<div class="form-group row">
		<label for="email">Email</label>
		<input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
	</div>

	<div class="form-group row">
		<label for="password">Password</label>
		<input type="password" name="password" id="password" class="form-control" required>
	</div>

	<button type="submit" class="btn btn-primary">Login</button>

</form>
@endsection
