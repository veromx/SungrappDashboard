<h3>Contacto</h3>
<form id="supplier-contact" action="{{ action('MessageController@store') }}" method="POST">

	<div class="form-group">
	<label for="full_name">Nombre</label>
	<input class="form-control" type="text" name="full_name" id="full_name" required>
	</div>
	<div class="form-group">
	<label for="email">Correo electrónico</label>
	<input class="form-control" type="email" name="email" id="email" required>
	</div>
	<div class="form-group">
	<label for="phone_number">Teléfono</label>
	<input class="form-control" type="text" name="phone_number" id="phone_number" required>
	</div>
	<div class="form-group">
	<label for="message">Mensaje</label>
	<textarea class="form-control" type="textarea" name="message" id="message" required></textarea>
	</div>

	<input type="hidden" name="potential_supplier" value=1>
	<button type="submit" class="btn btn-primary">Enviar</button>

</form>
