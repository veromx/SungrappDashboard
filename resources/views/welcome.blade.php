@extends('layouts.master')

@section('content')
<h1>Sungrapp</h1>
@if(!Auth::check())
	<a href="{{ action('Auth\LoginController@showLoginForm') }}">Iniciar sesión</a><br>
	<a href="{{ action('Auth\RegisterController@showRegistrationForm') }}">Registro en el sistema</a><br>
@else
	<a href="{{ url('admin') }}">Panel de control</a>
@endif
@include('partials.contact_form')


@endsection
