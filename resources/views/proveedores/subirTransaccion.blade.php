@extends('layouts.dashboard')
@section('page_heading','Subir Transacciones')

@section('section')

@if(isset($message))
	<script type="text/javascript">
		window.onload = function(){ alert("{{$message}}");}
	</script>
@endif

<div class="container-fluid">
	<div class="row">
		<div class="panel panel-primary">
			<div class="panel-heading"><strong>Subir Checadas</strong></div>
			<div class="panel-body">
			@if (count($errors) > 0)
			<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong>¡Alerta!</strong> Hubo problemas para guardar los datos<br><br>
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
			@endif
			<!--<img src='{{url(Auth::user()->foto)}}' class='img-responsive' style='max-width: 150px' />-->
			<form class="form-horizontal" role="form" method="POST" action="#" id="registro-form" data-parsley-validate="" enctype='multipart/form-data'>
				<input type="hidden" name="_token" value="{{ csrf_token() }}">	
				<div class="row">
					<div class="col-sm-12">
						<label class="control-label">Seleccione el archivo de excel desde su ordenador.</label>
					</div>
				</div>
					<div class="row">
					
				    
					<div class="col-sm-6">
							<div class="panel-body">
							 <label class="control-label">Archivo </label>
							 	<div >
									<input type="file"  class="form-control" name="archivo"  id="archivo" >
								</div>
							</div>
					</div>
					
				</div>
				
				<div class="form-group">
				    <center>
						<button type="submit" class="btn btn-primary" value="validate" style="margin-right: 15px;">
							Guardar
						</button>
					</center>
				</div>
				
			</form>
			<!--Fin de Forma -->
			</div>
		</div>
	</div>
</div>      




@stop
