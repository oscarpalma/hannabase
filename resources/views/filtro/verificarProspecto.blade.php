@extends('base')
@section('cabezera','Verificar')
@section('css')
<!-- Modal CSS -->
    <link href="/static/css-modal/modal.css" rel="stylesheet">   
@endsection
@section('content')
<div class ="navbar navbar-default">
	<form class="navbar-form navbar-left" method="post" >
		<input type="hidden" name="_token" value="{{ csrf_token() }}">	
		<div class="form-group">
		    <textarea type="text" class="form-control" name="curp" id="curp" rows="4" cols="71"  placeholder="Buscar CURP"></textarea> 
		</div>
		<div class="form-group">
		<button type="submit" class="btn btn-primary " ><i class="fa fa-search " aria-hidden="true"></i> Verificar </button> <br><br>
		<a href="#ayuda" data-toggle="modal" data-target="#ayuda" class="btn btn-info" ><i class="fa fa-question-circle" aria-hidden="true"></i> Ayuda</a>
		</div>
	</form>
</div>
<style type="text/css">
	textarea {
    resize: none;
}
</style>

<!--Dialogo de ayuda-->
<div id="ayuda" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header modal-header-info">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Ayuda</h4>
      </div>
      <div class="modal-body">
        <p>En el campo mostrado, ingresar la curp de los prospectos a verificar, separados por comas. Puede utilizar los espacios y saltos de líneas (presionar Enter) que deseé, pero siempre tiene que haber una coma entre cada una de las CURP ingresadas. Puede mezclar MAYÚSCULAS con minúsculas. </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>

  </div>
</div>

<!-- Agregar resultados de busqueda -->
@if(isset($prospectos))
	<table class="table table-striped table-bordered table-hover dataTable no-footer" border="2" width="100%" rules="rows" style='text-transform:uppercase'>
		<tr>
			<th>Nombre</th>
			<th>CURP</th>
			<th>Estado</th>
			<th>Observaciones</th>
		</tr>

		@foreach($prospectos as $prospecto)
			<tr>
				<td>{{$prospecto['nombre']}}</td>
				<td>{{$prospecto['curp']}}</td>
				<td>{{$prospecto['estado']}}</td>
				<td>{{$prospecto['observacion']}}</td>
			</tr>
		@endforeach
	</table>
@endif            
@stop
