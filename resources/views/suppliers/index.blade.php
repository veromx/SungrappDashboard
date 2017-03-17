@extends('layouts.master')

@section('content')
<div class="row">
	<div class="col-sm-10">
		<h3>Proveedores</h3>
	</div>
</div>
<div class="table-responsive">
	<table class="table">
	<thead class="thead-inverse">
		<tr>
			<th>Nombre</th>
			<th>RFC</th>
			<th>Email</th>
			<th>Teléfono</th>
			<th>Proyecto</th>
			<th>Estado</th>
			<th></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
	@foreach($suppliers as $supplier)
		<tr>
			<td>{{ $supplier['full_name'] }}</td>
			<td>{{ $supplier['rfc'] }}</td>
			<td>{{ $supplier['email'] }}</td>
			<td>{{ $supplier['phone_number'] }}</td>
			<td>{{ $supplier->project->name }}</td>
			<td>{{ $supplier->project->status->status_name }}</td>
			<td><a role="button" class="btn btn-primary cursor-default" href="{{ action('SupplierController@edit',$supplier['id']) }}">Edit</a></td>
			<td>
				<form method="POST" action="{{ action('SupplierController@destroy', $supplier['id']) }}">
					<input type="hidden" name="_method" value="DELETE">
					<button class="btn btn-danger" type="submit">Delete</button>
				</form></td>
		</tr>
	@endforeach
	</tbody></table>
</div>
@endsection
