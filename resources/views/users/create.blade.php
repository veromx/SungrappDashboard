@extends('layouts.master')

@section('content')
<form class="inline-form" id="create-user" method="POST" action="{{action('UserController@store')}}">
{{	csrf_field()	}}

<div class="form-group">
  <label for="email">Email</label>
  <input type="email" class="form-control" name="email" id="email" placeholder="example@example.com">
</div>
<div class="form-group">
  <label for="password">Password</label>
  <input type="password" class="form-control" id="password">
</div>
<div class="form-group">
  <label for="password-confirmation">Confirm password</label>
  <input type="password" class="form-control" name="password-confirmation" id="password">
</div>
<div class="form-group">
  <label for="first_name">First name</label>
  <input type="text" class="form-control" id="formGroupExampleInput2" placeholder="John">
</div>
<div class="form-group">
  <label for="last_name">Last name</label>
  <input type="text" class="form-control" name="last_name" id="last_name" placeholder="">
</div>
<div class="form-group">
  <label for="user_type">Type of user</label>
  <input type="text" class="form-control" name="user_type" id="user_type" placeholder="user">
</div>

<button type="submit" class="btn btn-primary">Registrar</button>
</form>
@endsection
