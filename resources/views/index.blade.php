@extends('layouts.master')

@section('content')


{{dd($errors)}}
@if($errors->any())
   @foreach ($errors as $error)
      <div>{{ $error }}</div>
  @endforeach
@endif


@endsection
