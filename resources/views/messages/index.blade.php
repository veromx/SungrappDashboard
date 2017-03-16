@extends('layouts.master')

@section('content')
{{var_dump($suppliers->toArray())}}
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
			<th>Mensaje</th>
			<th></th>
		</tr>
	</thead>
	<tbody>

	</tbody></table>
	</div>

@endsection
