@extends('base')
@section('cabezera','Bandeja de entrada')
@section('content')

@foreach($notificaciones as $notificacion)
	@if($notificacion->area == Auth::user()->role || $notificacion->destinatario == Auth::user()->id )
		<div class="panel panel-primary">
			<div class="panel-heading"></div>
			<div class="panel-body">
				<div class="row">
					<div class="col-sm-6">
						<label class="control-label">De: </label>
						<text>{{$notificacion->remitente}}</text>
					</div>

					<div class="col-sm-6" align="right">
						<label class="control-label">Fecha: </label>
						<text>{{$notificacion->fecha}}</text>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-12">
						<label class="control-label">Asunto: </label>
						<text>{{$notificacion->asunto}}</text>
					</div>
				</div>
				<hr>

				<div class="row">
					<div class="col-sm-12">
						<label class="control-label">Contenido:</label>
						<p><?php 
echo $notificacion->mensaje; 
?></p>
					</div>
				</div>
			</div>
		</div>
	@endif
@endforeach

@stop