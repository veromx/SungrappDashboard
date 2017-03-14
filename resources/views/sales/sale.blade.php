@extends('layouts.master')

@section('content')
    <form id="register" method="POST" action="{{action('')}}">

        <div class="form-group row">
            <label for="supplier_id">Cliente:</label>
            <!-- select de distribuidores  -->
        </div>

        <div class="form-group row">
            <label for="package_id">Paquete</label>
            <input type="text" name="package_id" id="package_id" class="form-control" value="" required>
        </div>

        <div class="form-group row">
            <label for="amount">Cantidad</label>
            <input type="amount" name="amount" id="amount" class="form-control" value="" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Pagar</button>

    </form>
</div>
@endsection
