<form id="login" method="POST" action="{{action('Auth\LoginController@login')}}">

<div class='form-group'>

	<label for="email">Email</label>
	<input type="email" name="email" id="email" required>

	<label for="password">Password</label>
	<input type="password" name="password" id="password" required>

	<button type="submit">Login</button>
</div>
</form>
