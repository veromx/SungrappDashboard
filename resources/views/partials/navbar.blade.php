<nav class="navbar navbar-toggleable-md navbar-inverse bg-inverse">
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
    	<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse">
		<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
			<a class="navbar-brand" href="{{ route('admin') }}">Sungrapp</a>
			@if(Auth::check())
			<span class="navbar-text">{{ Auth::user()->first_name }} ({{ Auth::user()->email }}) </span>
			<a class="navbar-link" href="{{ action('Auth\LoginController@logout') }}">Cerrar sesión</a>
			@endif
		</ul>
@section('navbar')

@show
</div>
</nav>
