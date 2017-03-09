@extends('layouts.master')

@section('content')

@if($users->count()>0)
<ul>
@foreach($users as $u)
<li>Name: <a href="{{ action('UserController@show',$u->id)}}">{{ $u->first_name . " " . $u->last_name }}</a></li>
<li>Email: {{ $u->email }}</li>
<li>Type of user: {{ $u->user_type }}</li>

@endforeach
</li>
@endif

@endsection
