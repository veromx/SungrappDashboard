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
	<li class="nav-item">
		<a class="flex-sm-fill text-sm-center nav-link text-white" href="{{ action('UserController@index') }}">Usuarios</a>
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
