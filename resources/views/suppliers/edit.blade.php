@extends('layouts.master')

@section('content')
<h3>Editar proveedor {{ $supplier['name'] }}</h3>
<form class="form px-4 py-2" action="{{ action('SupplierController@update', $supplier['id']) }}" method="POST">
	<input type="hidden" name="_method" value="PATCH">

	<div class="form-group row">
		<label class="col-form-label col-sm-2" for="full_name">Nombre</label>
		<div class="col-sm-10">
			<input class="form-control" type="text" name="full_name" id="full_name"
			value="{{ old('full_name', $supplier['full_name']) }}">
		</div>
	</div>

	<div class="form-group row">
		<label class="col-form-label col-sm-2" for="rfc">RFC</label>
		<div class="col-sm-10">
			<input class="form-control" type="text" name="rfc" id="rfc"
			value="{{ old('rfc', $supplier['rfc']) }}">
		</div>
	</div>

	<div class="form-group row">
		<label class="col-form-label col-sm-2" for="email">Correo electrónico</label>
		<div class="col-sm-10">
			<input class="form-control" type="email" name="email" id="email"
			value="{{ old('email', $supplier['email']) }}">
		</div>
	</div>

	<div class="form-group row">
		<label class="col-form-label col-sm-2" for="phone_number">Teléfono</label>
		<div class="col-sm-10">
			<input class="form-control" type="tel" name="phone_number" id="phone_number"
			value="{{ old('phone_number', $supplier['phone_number']) }}">
		</div>
	</div>

	<div class="form-group row">
		<label class="col-form-label col-sm-2" for="logo_file_name">Logo</label>
		<div class="col-sm-10">
			<input class="form-control" type="text" name="logo_file_name" id="logo_file_name"
			value="{{ old('logo_file_name', $supplier['logo_file_name']) }}">
		</div>
	</div>

	<button type="submit" class="btn btn-primary">Enviar</button>
</form>
@endsection
