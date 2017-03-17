@extends('layouts.master')

@section('content')

<div class="row">
	<div class="col-sm-10">
		<h3>Mensajes</h3>
	</div>
</div>
<div class="table-responsive">
	<table class="table">
	<thead class="thead-inverse">
		<tr>
			<th>Proveedor</th>
			<th>Email</th>
			<th>Teléfono</th>
			<th>Fecha</th>
			<th>Mensaje</th>
		</tr>
	</thead>
	<tbody>
		@foreach($messages as $msg)
		<tr>
			<td>{{ $msg->supplier->full_name }}</td>
			<td>{{ $msg->supplier->email }}</td>
			<td>{{ $msg->supplier->phone_number }}</td>
			<td>{{ $msg->created_at->formatLocalized('%d %B %Y') }}</td>
			<td>{{ $msg->message }}</td>
		</tr>
		@endforeach
	</tbody></table>
	</div>

@endsection
