@extends('layouts.master')
@section('navbar')
@parent

@endsection

@section('content')
<h1>Sungrapp Dashboard API v1</h1>

<ul class="nav nav-pills nav-justified bg-primary flex-column flex-sm-row">
	<li class="nav-item">
		<a class="flex-sm-fill text-sm-center nav-link text-white" href="{{ action('SupplierController@index') }}">Proveedores</a>
	</li>
	<li class="nav-item">
		<a class="flex-sm-fill text-sm-center nav-link text-white" href="{{ action('SalesController@index') }}">Ventas</a>
	</li>
	<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle flex-sm-fill text-sm-center text-white" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Usuarios</a>
		<div class="dropdown-menu">
			<a class="dropdown-item" href="{{ action('UserController@index') }}">Usuarios Vertix</a>
			<a class="dropdown-item" href="{{ action('UserController@index', ['option'=>'by_supplier']) }}">Por proveedor</a>
		</div>
	</li>
	<li class="nav-item">
		<a class="flex-sm-fill text-sm-center nav-link text-white" href="{{ action('PackagesController@index') }}">Paquetes</a>
	</li>
	<li class="nav-item">
		<a class="flex-sm-fill text-sm-center nav-link text-white" href="{{ action('MessageController@index') }}">Mensajes</a>
	</li>
	<li class="nav-item">
		<a class="flex-sm-fill text-sm-center nav-link text-white" href="#">Reportes</a>
	</li>
</ul>

<hr>

<h3>Lista de licencias expiradas y por expirar</h3>
TODO: Lista

@endsection
