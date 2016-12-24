@extends('layouts.dashboard')
@section('page_heading','Lista de Inventario')
@section('section')

@if(Session::has('mensaje'))
    <script type="text/javascript">
        window.onload = function(){ alert("{{Session::get('mensaje')}}");}
    </script>
@endif
<!--
<script>
  $(document).ready(function(){
    $(".time_element").timepicki();
  });
</script>
-->

<form class="form-horizontal" role="form" method="POST" action="{{route('eliminar_inventario',$inventario->id)}}" >
<input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="panel panel-primary">
		<div class="panel-heading"><strong>Datos</strong></div>
		<div class="panel-body">
			<div class="row">
				<div class="col-sm-4">
					<label class="control-label">Nombre</label>
					<input class="form-control" name="nombre" required="" value="{{$inventario->nombre}}" readonly>
				</div>

				<div class="col-sm-4">
					<label class="control-label">Modelo</label>
					<input class="form-control" name="modelo" required="" value="{{$inventario->modelo}}" readonly>
				</div>

				<div class="col-sm-4">
					<label class="control-label">Marca</label>
					<input class="form-control" name="marca" required="" value="{{$inventario->marca}}" readonly>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-4">
					<label class="control-label">Descripcion</label>
					<input class="form-control" name="descripcion" required="" value="{{$inventario->descripcion}}" readonly>
				</div>				

				<div class="col-sm-4">
					<label class="control-label">Unidades</label>
					<input class="form-control" name="unidades" required="" value="{{$inventario->unidades}}" readonly>
				</div>

				<div class="col-sm-4">
					<br>
					<center>
						<button class="btn btn-danger" type="submit">Eliminar</button>
					</center>
				</div>
			</div>
		</div>
	</div>
</form>
@stop