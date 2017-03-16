@extends('layouts.master')

@section('content')
{{var_dump($packages)}}
<div class="row">
	<div class="col-sm-10">
		<h3>Paquetes</h3>
	</div>
	<div class="col-sm">
		<a class="btn btn-primary" href="{{action('PackagesController@create')}}">Nuevo paquete</a>
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

	</tbody></table>
	</div>
@endsection
