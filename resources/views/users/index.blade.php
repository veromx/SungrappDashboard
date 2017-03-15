@extends('layouts.master')

@section('content')
<h1>Usuarios</h1>
<hr>
<h3>Usuarios Vertix</h3>
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
			<td>{{ $user['first_name'] . ' ' . $user['last_name'] }}</td>
			<td>{{ $user['email'] }}</td>
			<td><a href="{{ action('UserController@edit',$user['id']) }}">Edit</a></td>
			<td>
				<form method="POST" action="{{ action('UserController@destroy', $user['id']) }}">
					<input type="hidden" name="_method" value="DELETE">
					<button class="btn btn-danger" type="submit">Delete</button>
				</form></td>
		</tr>
	@endforeach
	</tbody></table>

@endsection
