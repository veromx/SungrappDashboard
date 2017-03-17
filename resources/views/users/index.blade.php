@extends('layouts.master')

@section('content')
<h1>Usuarios</h1>
<hr>

@if(!$by_supplier)
<div class="row">
	<div class="col-sm-10">
		<h3>Usuarios Vertix</h3>
	</div>
	<div class="col-sm-2 ">
		<a class="btn btn-primary float-sm-right" href="{{action('UserController@create')}}">Nuevo</a>
	</div>
</div>
<div class="table-responsive">
	<table class="table">
	<thead class="thead-inverse">
		<tr>
			<th>Nombre</th>
			<th>Email</th>
			<th></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		@foreach($users as $user)
			<tr>
				<td>{{$user['first_name'] . ' ' . $user['last_name']}}</td>
				<td>{{$user['email']}}</td>
				<td>
					<a role="button" class="btn btn-primary cursor-default"
					href="{{ action('UserController@edit', $user['id']) }}">Edit</a>
				</td>
				<td>
					<form method="POST" action="{{ action('UserController@destroy', $user['id']) }}">
						<input type="hidden" name="_method" value="DELETE">
						<button class="btn btn-danger" type="submit">Delete</button>
					</form>
				</td>
		@endforeach
	</tbody></table>
</div>
@endif

@if($by_supplier)
<h3>Usuarios de proveedores</h3>
<form class="form mb-2" method="GET" action="{{action('UserController@index')}}">
	<input type="hidden" name="option" value="by_supplier">
	<div class="input-group">
		<select name="supplier" class="custom-select form-control">
			@foreach($suppliers as $supplier)
				<option value="{{ $supplier['id'] }}" {{$supplier['id']==$supplier_id?"selected":""}}>
					{{ $supplier['full_name'] }}</option>
			@endforeach
		</select>
		<span class="input-group-btn">
			<button type="submit" class="btn btn-primary">Consultar</button>
		</span>
	</div>
</form>

@if(!empty($users))
<div class="table-responsive">
	<table class="table">
		<thead class="thead-inverse">
			<tr>
				<th>Nombre</th>
				<th>Email</th>
				<th colspan="2"></th>
			</tr>
		</thead>
		<tbody>
			@foreach($users as $user)
				<tr>
					<td>{{$user['first_name'] . ' ' . $user['last_name']}}</td>
					<td>{{$user['email']}}</td>
					<td>
						<a role="button" class="btn btn-primary cursor-default"
						href="{{ action('UserController@edit', $user['id']) }}">Edit</a>
					</td>
					<td>
						<form method="POST" action="{{ action('UserController@destroy', $user['id']) }}">
							<input type="hidden" name="_method" value="DELETE">
							<button class="btn btn-danger" type="submit">Delete</button>
						</form>
					</td>
			@endforeach
		</tbody>
	</table>
</div>

@endif {{--users--}}

@endif {{--by_supplier--}}

@endsection
