@extends('layouts.dashboard')
@section('page_heading','Confirmar datos')
@section('section')

<div class="container-fluid">
	<div class="row">
		<form class="form-horizontal" role="form" method="POST" action="{{route('eliminar_checada')}}" id="eliminar-checada-form"  >
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="panel-body">
			<h3>Las siguientes checadas serás eliminadas:</h3>
				 

				<div class="form-group">
				    <center>
						
						<table class="table table-striped table-bordered table-hover dataTable no-footer" border="2" width="100%" rules="rows" style='text-transform:uppercase'>
					<tr>
						<th><center>Cliente</center></th>
						<th><center>Empleado</center></th>
						<th><center>Fecha</center></th>
						<th><center>Entrada</center></th>
						<th><center>Salida</center></th>
						<th><center>Incidencia</center></th>
					</tr>
						@foreach($parametros['check'] as $info)
						

					<tr>
						<td><center>{{$info['cliente']->nombre}}</center></td>
						<td><center>{{$info['empleado']}}</center></td>
						<td><center>{{$info['checada']->fecha}}</center></td>
						<td><center>{{$info['checada']->hora_entrada}}</center></td>
						<td><center>{{$info['checada']->hora_salida}}</center></td>

						<!--mostrar N/A si no hay incidencia-->
						@if($info['checada']->incidencia != null)
							@if($info['checada']->incidencia == 'falta injustificada')
								<td><center><b><p style="color:red">{{$info['checada']->incidencia}}</p></b></center></td>
							@else
								<td><center><b><p style="color:green">{{$info['checada']->incidencia}}</p></b></center></td>
							@endif
						@else
							<td><center>N/A</center></td>
						@endif
					</tr>
				
						@endforeach
						</table>
						<button type="submit" class="btn btn-danger" style="margin-right: 15px;">
							Eliminar 
						</button>
					</center>
				</div>

			</div>
			@foreach($parametros['idChecadas'] as $checada)
			<input type="hidden" name="checadas[]" value="{{$checada}}">
			@endforeach
		</form>
	</div>
</div>

@stop