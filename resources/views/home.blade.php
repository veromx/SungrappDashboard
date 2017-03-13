@extends('layouts.master')

@section('content')
<h1>Sungrapp Dashboard API v1</h1>

@if(Auth::check())
<p>Sesión iniciada como {{ Auth::user()->first_name }} ({{ Auth::user()->email }})</p>
<p><a href="{{ action('Auth\LoginController@logout') }}">Cerrar sesión</a></p>
@else
<p><a href="{{ action('Auth\LoginController@showLoginForm') }}">Iniciar sesión</a></p>
<p><a href="{{ action('Auth\RegisterController@showRegistrationForm') }}">Registrarse</a></p>
@endif

@endsection
