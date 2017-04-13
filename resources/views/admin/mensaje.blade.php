@extends('layouts.dashboard')
@section('page_heading','Nuevo Mensaje')
@section('section')

<div class="panel panel-primary">
	<div class="panel-heading"><strong>Redactar</strong></div>
	<div class="panel-body">
		<form class="form-horizontal" role="form" method="POST" action="{{ route('mensaje') }}">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="row">
				<div class="col-sm-4">
					<label class="control-label">Tipo de envio: <text style="color:red">*</text></label>
					<div >								
						<select class="form-control" name="tipo"  id="tipo" required="">
							<option value="">SELECCIONAR</option>
							
								<option name="area" value="area">Area</option>
								<option name="usuarios" value="usuarios">Usuario especifico</option>
							
						</select>
					</div>	 
				</div>
				</div>
			<div class="row area" hidden="">
				<div class="col-sm-6">
					<label class="control-label " >Enviar a:</label>
					<select name="destinatarios[]" multiple="" class="form-control " required="" id="destinatarios">
						<option value="administrador">Administradores</option>
						<option value="supervisor">Supervisores</option>
						<option value="recepcion">Recepcion</option>
						<option value="filtro">Filtro</option>
						<option value="enfermeria">Enfermera</option>
					</select>
				</div>
			</div>

			<div class="row usuarios" hidden="">
				<div class="col-sm-6">
					<label class="control-label " >Enviar a:</label>
					<div >								
						<select class="form-control" name="usuario"  id="usuario" required="">
							<option value="">SELECCIONAR</option>
							
								@foreach($usuarios as $usuario)
								 @if(Auth::user()->id != $usuario->id)<option name="{{$usuario->id}}" value="{{$usuario->id}}">{{$usuario->nombre}}</option>@endif
							@endforeach
							
						</select>
					</div>
				</div>
			</div>

			<div class=row>
				<div class="col-sm-12">
					<label class="control-label">Asunto</label>
					<input class="form-control" name="asunto" required="">
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<label class="control-label">Escriba a continuación su mensaje</label>
					<textarea class="form-control" name="mensaje" style="resize:vertical;" required=""></textarea>
				</div>
			</div>

			<div class="row">
				<center>
					<br>
					<button type="submit" class="btn btn-primary">Enviar</button>
				</center>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript">
	
$( "#tipo" ).change(function() {
  if ($("#tipo").val()=='area'){
  	$(".area").show();
  	
  	$(".usuarios").hide();
  	$("#destinatarios").prop('required', true);
  	$("#usuario").prop('required', false);
  }else if ($("#tipo").val()=='usuarios'){
  	$(".area").hide();
  	$(".usuarios").show();
  	$("#destinatarios").prop('required', false);
  	$("#usuario").prop('required', true);
  }else if ($("#tipo").val()==''){
  	$(".area").hide();
  	$(".usuariows").hide();
  }
});

</script>
@stop
