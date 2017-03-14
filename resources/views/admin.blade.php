@extends('layouts.master')

@section('content')
<h1>Sungrapp Dashboard API v1</h1>

	<p>Sesión iniciada como {{ Auth::user()->first_name }} ({{ Auth::user()->email }})</p>
	<p><a href="{{ action('Auth\LoginController@logout') }}">Cerrar sesión</a></p>


@endsection
