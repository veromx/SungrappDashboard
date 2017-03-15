<nav class="navbar navbar-toggleable-md navbar-inverse bg-inverse">
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    	<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
			<li>
				<a class="navbar-brand" href="{{ route('admin') }}">Sungrapp</a>
			</li>
			@if(Auth::check())
				<li>
					<span class="navbar-text">{{ Auth::user()->first_name }} ({{ Auth::user()->email }}) </span>
				</li>
				<li>
					<a class="navbar-link" href="{{ action('Auth\LoginController@logout') }}">Cerrar sesión</a>
				</li>
			@endif
		</ul>
@section('navbar')

@show
</div>
</nav>
