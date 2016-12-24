@extends('layouts.dashboard')
@section('page_heading','Confirmar datos')
@section('section')

<div class="container-fluid">
	<div class="row">
		<form class="form-horizontal" role="form" method="POST" action="{{ route('eliminar_checada_ct', $checada->idChecadaCt)}}" id="confirmar-form"  >
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="panel-body">
			<h3>Confirmar</h3>
				<table class="table table-striped table-bordered table-hover dataTable no-footer" border="2" width="100%" rules="rows" style='text-transform:uppercase'>
					<tr>
						<th>ID de empleado</th>
						<th>Fecha</th>
						<th>Hora de entrada</th>
						<th>Hora de salida</th>
						<th>Horas trabajadas</th>
						<th>Horas extra</th>
						<th>Incidencia</th>
						<th>Comentarios</th>
					</tr>

					<tr>
						<td>{{$checada->idEmpleadoCt}}</td>
						<td>{{$checada->fecha}}</td>
						<td>{{$checada->hora_entrada}}</td>
						<td>{{$checada->hora_salida}}</td>
						<td>{{$checada->horas_ordinarias}}</td>
						<td>{{$checada->horas_extra}}</td>

						<!--mostrar N/A si no hay incidencia-->
						@if($checada->incidencia != null)
							<td><b>{{$checada->incidencia}}</b></td>
						@else
							<td>N/A</td>
						@endif

						<!--mostrar N/A si no hay comentarios-->
						@if($checada->comentarios != null)
							<td><b>{{$checada->comentarios}}</b></td>
						@else
							<td>N/A</td>
						@endif
					</tr>
				</table>


				<div class="form-group">
				    <center>
						<button type="submit" class="btn btn-danger" value="validate" style="margin-right: 15px;">
							Eliminar 
						</button>
					</center>
				</div>

			</div>
		</form>
	</div>
</div>

@stop