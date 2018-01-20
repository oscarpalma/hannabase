@extends('base')
@section('titulo','Generar Reporte')
@section('cabezera','Generar Reporte')
@section('css')
<link href="/static/select2/select2.css" rel="stylesheet">

@stop
@section('content')


<form class="form-horizontal @if(isset($parametros['reporte']) && !empty($parametros['reporte']['empleados'])) collapse @endif" method="POST" action="{{ route('reporte_checadas') }}" id="generarReporte">
	<div class="panel panel-primary">
		<div class="panel-heading"></div>
		<div class="panel-body">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">	
			<div class="row-sm">					
				<p>Campos marcados con <text style="color:red">*</text> son obligatorios.</p>
				<div class="form-actions"><label>Semana Actual {{date("W")}}</label></div>
			</div>
			<div class="row">
				<div class="col-sm-4">
					<label class="control-label">Empleado <text style="color:red">*</text></label>
					<div>
						<select class="form-control" id="empleado" name="empleado" style="width: 100%">
							<!--en caso de no especificar ninguno-->
							<option value="null">Todos</option>

							@foreach($parametros['empleados'] as $empleado)
								<option value="{{$empleado->idEmpleado}}">{{$empleado->idEmpleado}} - {{$empleado->ap_paterno}} {{$empleado->ap_materno}}, {{$empleado->nombres}}</option>
							@endforeach
						</select>
					</div>
				</div>

				<div class="col-sm-4">
					<label class="control-label">Empresa <text style="color:red">*</text></label>
					<div>
						<select class="form-control" name="cliente" id="cliente">
							<!--en caso de no especificar ninguno-->
							<option value="">Seleccione</option>
							@foreach($parametros['clientes'] as $cliente)
								<option value="{{$cliente->idCliente}}">{{$cliente->nombre}}</option>
							@endforeach
						</select>
					</div>
				</div>

				<div class="col-sm-4">
					<label class="control-label">Turno <text style="color:red">*</text></label>
					<div>
						<select class="form-control" name="turno" id="turno" required>
							<!--en caso de no especificar ninguno-->
							<option value="">-------</option>
						</select>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-4">
					<label class="control-label">Semana <text style="color:red">*</text></label>
					<div>
						<select class="form-control" name="semana" >
							@for($i = 1; $i<=date("W"); $i++)
								<option value="{{$i}}">Semana {{$i}}</option>
							@endfor
						</select>
					</div>
				</div>

				<div class="col-sm-4">
					<label class="control-label">Año <text style="color:red">*</text></label>
					<div>
						<select class="form-control" name="year">
						<!--desde 2016 hasta el anio actual, como en coen-->
							@for($i = date('Y'); $i >= 2017; $i--)
								<option value="{{$i}}">{{$i}}</option>
							@endfor
						</select>
					</div>
				</div>

				<div class="col-sm-4">
					<br>
				    <div class="form-actions">
						<button type="submit" class="btn btn-primary" value="validate" style="margin-right: 15px;">
							Buscar
						</button>
					</div>
				</div>

			</div>
		</div>
	</div>
	@if(isset($parametros['reporte']['empleados']) && !empty($parametros['reporte']['empleados']))
		
		<a class="btn btn-primary" role="button" data-toggle="collapse" href=".reporte" aria-expanded="false" aria-controls="reporte">
	  		Mostrar Reporte
		</a>
	@endif
</form>

@if(isset($parametros['reporte']))
@if(!empty($parametros['reporte']['empleados']))
	
	<div class="reporte collapse">
	<a class="btn btn-primary" role="button" data-toggle="collapse" href="#generarReporte" aria-expanded="false" aria-controls="generarReporte" id="mostrar">
  		Generar Nuevo
	</a>
	<br><br>
	<div id="resultados">
	<!--Tabla con los resultados de la busqueda-->
	<div class="panel panel-primary">
          <div class="panel-heading">
          		<span class="fa  fa-bar-chart-o"></span> Reporte - Semana {{$parametros['semana']}}
                    <div class="pull-right action-buttons">
                        <div class="btn-group pull-right">
                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                <span class="glyphicon glyphicon-download-alt" style="margin-right: 0px;"></span>
                            </button>
                            <ul class="dropdown-menu slidedown">
                                <li><a href="#" id="btnExport"><span class="fa fa-file-excel-o"></span> Interno</a></li>
                                <li><a href="#" id="btnCliente"><span class="fa fa-file-excel-o"></span> Cliente</a></li>
                                
                            </ul>
                        </div>
                    </div>
          </div> 
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper tabla">

		<table class="table table-striped table-bordered table-hover dataTable no-footer" style='text-transform:uppercase' >
			<thead >
				<tr>
					<th colspan="28" style="" ></th>
					<th colspan="6" align="right" style="" ><div class="form-actions">TOTAL</div></th>
				</tr>

				<tr>
					<th colspan="4" style="" >Cliente: {{$parametros['reporte']['cliente']}}</th>
					<th colspan="3" style="" >Horario: {{$parametros['reporte']['turno']}}</th>
					@for($i = 1; $i <= 7; $i++)
						<th colspan="2"  >Personas</th>
						<th style="" >{{$parametros['reporte']['dias'][$i]['personas']}}</th>
					@endfor
					<th style="" >{{$parametros['reporte']['total_dias']}}</th>
					<th style="" >{{$parametros['reporte']['total_horas_ordinarias']}}</th>
					<th style="" >{{$parametros['reporte']['total_horas_extra']}}</th>
					<th style="" ><div class="form-actions">{{$parametros['reporte']['total_descuentos']}}</div></th>
					<th style="" ><div class="form-actions">{{$parametros['reporte']['total_reembolsos']}}</div></th>
					<th style="" > <div class="form-actions">{{$parametros['reporte']['total_comedores']}}</div></th>
				</tr>

				<?php
					//convertir las fechas a datetime, para darles el formato necesario
					$fecha1 = new DateTime($parametros['fecha1']);
					$fecha2 = new DateTime($parametros['fecha2']);

					//array con las traducciones correspondientes a espanol
					$meses =[
					'January' => 'Enero',
					'February' => 'Febrero',
					'March' => 'Marzo',
					'April' => 'Abril',
					'May'   => 'Mayo',
					'June'  => 'Junio',
					'July'  => 'Julio',
					'August' => 'Agosto',
					'September' => 'Septiembre',
					'October' => 'Octubre',
					'November' => 'Noviembre',
					'December' => 'Diciembre'];
				?>

				<tr>
					<th colspan="4" style="" >Semana {{$parametros['semana']}}</th>
					<th colspan="3" style="" >Del {{$fecha1->format('j')}} de {{$meses[$fecha1->format('F')]}} @if($fecha1->format('Y') != $fecha2->format('Y')) del {{$fecha1->format('Y')}} @endif al {{$fecha2->format('j')}} de {{$meses[$fecha2->format('F')]}} del {{$fecha2->format('Y')}}</th>
					<th colspan="3" style="" >Lunes {{$parametros['reporte']['dias'][1]['dia']}}</th>
					<th colspan="3" style="" >Martes {{$parametros['reporte']['dias'][2]['dia']}}</th>
					<th colspan="3" style="" >Miercoles {{$parametros['reporte']['dias'][3]['dia']}}</th>
					<th colspan="3" style="" >Jueves {{$parametros['reporte']['dias'][4]['dia']}}</th>
					<th colspan="3" style="" >Viernes {{$parametros['reporte']['dias'][5]['dia']}}</th>
					<th colspan="3" style="" >Sabado {{$parametros['reporte']['dias'][6]['dia']}}</th>
					<th colspan="3" style="" >Domingo {{$parametros['reporte']['dias'][7]['dia']}}</th>
					<th colspan="3" style="" >Total trabajado</th>
					<th rowspan="2" style="" >Descuentos</th>
					<th rowspan="2" style="" >Reembolsos</th>
					<th rowspan="2" style="" >Comedores</th>
				</tr>

				<tr>
					<th style="" >#</th>
					<th style="" >ID</th>
					<th style="" >A. Paterno</th>
					<th style="" >A. Materno</th>
					<th style="" >Nombre</th>
					<th style="" >Puesto</th>
					<th style="" ># de Cuenta</th>

					@for($i = 0; $i < 7; $i++)
						<th style="" >C.P</th>
						<th style="" >R/T</th>
						<th style="" >O/T</th>
					@endfor

					<th style="" >Dias</th>
					<th style="" >R/T</th>
					<th style="" >O/T</th>
					
				</tr>
			</thead>

			<tbody>
				<?php
				$i = 1;
				?>
				@foreach($parametros['reporte']['empleados'] as $empleado)
					<tr>
						<td>{{$i++}}</td>
						<td>{{$empleado['id']}}</td>
						<td>{{strtoupper($empleado['ap_paterno'])}}</td>
						<td>{{strtoupper($empleado['ap_materno'])}}</td>
						<td>{{strtoupper($empleado['nombre'])}}</td>
						<td>OPERADOR</td>

					        @if($empleado['no_cuenta'] === null)
							<td><div class="form-actions"></div></td>
						@else
							<td><div class="form-actions">{{$empleado['no_cuenta']}}</div></td>
						@endif

						<!--se usara como contador para los dias trabajados-->
						<?php
						$diasTrabajados = 0;
						?>
						@foreach($empleado['checadas'] as $checada)
							@if($checada != null)
								<td>{{$parametros['reporte']['cliente']}}</td>
								<td>{{$checada->horas_ordinarias}}</td>
								<td>{{$checada->horas_extra}}</td>
								<?php $diasTrabajados++;?>
							@else
								<td></td>
								<td></td>
								<td></td>
							@endif
						@endforeach
						<td>{{$diasTrabajados}}</td>
						<td>{{$empleado['horas_ordinarias']}}</td>
						<td>{{$empleado['horas_extra']}}</td>
						<td><div class="form-actions">{{$empleado['descuentos']}}</div></td>
						<td><div class="form-actions">{{$empleado['reembolsos']}}</div></td>
						<td><div class="form-actions">{{$empleado['comedores']}}</div></td>		
					</tr>
			@endforeach
			</tbody>

		</table>



	</div>

	</div>
	</div>
	<div>
<!-- Tabla identica a la anterior para descargar con color -->
<table class="table table-striped table-bordered table-hover dataTable no-footer" style='text-transform:uppercase' id="tblExport" hidden="">
			<thead >
				<tr>
					<th colspan="28" style="" class="color"></th>
					<th colspan="6" align="right" style="" class="color"><div class="form-actions">TOTAL</div></th>
				</tr>

				<tr>
					<th colspan="4" style="" class="color" >Cliente: {{$parametros['reporte']['cliente']}}</th>
					<th colspan="3" style="" class="color">Horario: {{$parametros['reporte']['turno']}}</th>
					@for($i = 1; $i <= 7; $i++)
						<th colspan="2" style="" class="color">Personas</th>
						<th style="" class="color">{{$parametros['reporte']['dias'][$i]['personas']}}</th>
					@endfor
					<th style="" class="color">{{$parametros['reporte']['total_dias']}}</th>
					<th style="" class="color">{{$parametros['reporte']['total_horas_ordinarias']}}</th>
					<th style="" class="color">{{$parametros['reporte']['total_horas_extra']}}</th>
					<th style="" class="color"><div class="form-actions">{{$parametros['reporte']['total_descuentos']}}</div></th>
					<th style="" class="color"><div class="form-actions">{{$parametros['reporte']['total_reembolsos']}}</div></th>
					<th style="" class="color"> <div class="form-actions">{{$parametros['reporte']['total_comedores']}}</div></th>
				</tr>

				<?php
					//convertir las fechas a datetime, para darles el formato necesario
					$fecha1 = new DateTime($parametros['fecha1']);
					$fecha2 = new DateTime($parametros['fecha2']);

					//array con las traducciones correspondientes a espanol
					$meses =[
					'January' => 'Enero',
					'February' => 'Febrero',
					'March' => 'Marzo',
					'April' => 'Abril',
					'May'   => 'Mayo',
					'June'  => 'Junio',
					'July'  => 'Julio',
					'August' => 'Agosto',
					'September' => 'Septiembre',
					'October' => 'Octubre',
					'November' => 'Noviembre',
					'December' => 'Diciembre'];
				?>

				<tr>
					<th colspan="4" style="" class="color">Semana {{$parametros['semana']}}</th>
					<th colspan="3" style="" class="color">Del {{$fecha1->format('j')}} de {{$meses[$fecha1->format('F')]}} @if($fecha1->format('Y') != $fecha2->format('Y')) del {{$fecha1->format('Y')}} @endif al {{$fecha2->format('j')}} de {{$meses[$fecha2->format('F')]}} del {{$fecha2->format('Y')}}</th>
					<th colspan="3" style="" class="color">Lunes {{$parametros['reporte']['dias'][1]['dia']}}</th>
					<th colspan="3" style="" class="color">Martes {{$parametros['reporte']['dias'][2]['dia']}}</th>
					<th colspan="3" style="" class="color">Miercoles {{$parametros['reporte']['dias'][3]['dia']}}</th>
					<th colspan="3" style="" class="color">Jueves {{$parametros['reporte']['dias'][4]['dia']}}</th>
					<th colspan="3" style="" class="color">Viernes {{$parametros['reporte']['dias'][5]['dia']}}</th>
					<th colspan="3" style="" class="color">Sabado {{$parametros['reporte']['dias'][6]['dia']}}</th>
					<th colspan="3" style="" class="color">Domingo {{$parametros['reporte']['dias'][7]['dia']}}</th>
					<th colspan="3" style="" class="color">Total trabajado</th>
					<th rowspan="2" style="" class="color">Descuentos</th>
					<th rowspan="2" style="" class="color">Reembolsos</th>
					<th rowspan="2" style="" class="color">Comedores</th>
				</tr>

				<tr>
					<th style="" class="color">#</th>
					<th style="" class="color">ID</th>
					<th style="" class="color">A. Paterno</th>
					<th style="" class="color">A. Materno</th>
					<th style="" class="color">Nombre</th>
					<th style="" class="color">Puesto</th>
					<th style="" class="color"># de Cuenta</th>

					@for($i = 0; $i < 7; $i++)
						<th style="" class="color">C.P</th>
						<th style="" class="color">R/T</th>
						<th style="" class="color">O/T</th>
					@endfor

					<th style="" class="color">Dias</th>
					<th style="" class="color">R/T</th>
					<th style="" class="color">O/T</th>
					
				</tr>
			</thead>

			<tbody>
				<?php
				$i = 1;
				?>
				@foreach($parametros['reporte']['empleados'] as $empleado)
					<tr>
						<td>{{$i++}}</td>
						<td>{{$empleado['id']}}</td>
						<td>{{strtoupper($empleado['ap_paterno'])}}</td>
						<td>{{strtoupper($empleado['ap_materno'])}}</td>
						<td>{{strtoupper($empleado['nombre'])}}</td>
						<td>OPERADOR</td>

						@if($empleado['no_cuenta'] === null)
							<td><div class="form-actions"></div></td>
						@else
							<td><div class="form-actions">{{$empleado['no_cuenta']}}</div></td>
						@endif

						<!--se usara como contador para los dias trabajados-->
						<?php
						$diasTrabajados = 0;
						?>
						@foreach($empleado['checadas'] as $checada)
							@if($checada != null)
								<td>{{$parametros['reporte']['cliente']}}</td>
								<td>{{$checada->horas_ordinarias}}</td>
								<td>{{$checada->horas_extra}}</td>
								<?php $diasTrabajados++;?>
							@else
								<td></td>
								<td></td>
								<td></td>
							@endif
						@endforeach
						<td>{{$diasTrabajados}}</td>
						<td>{{$empleado['horas_ordinarias']}}</td>
						<td>{{$empleado['horas_extra']}}</td>
						<td><div class="form-actions">{{$empleado['descuentos']}}</div></td>
						<td><div class="form-actions">{{$empleado['reembolsos']}}</div></td>
						<td><div class="form-actions">{{$empleado['comedores']}}</div></td>		
					</tr>
			@endforeach
			</tbody>

		</table>
</div>
<div>
		<!-- Tabla para el cliente -->
<table class="table table-striped table-bordered table-hover dataTable no-footer" style='text-transform:uppercase' id="tablaCliente" hidden="">
			<thead >
				<tr>
					<th colspan="4">Centro de Trabajo</th>
					<th colspan="5">{{$parametros['reporte']['cliente']}}</th>
					<th colspan="12"><div class="form-actions">Reporte de Carga Diaria de Trabajo CT</div></th>
					<th colspan="5"></th>
					<th colspan="4">Fecha: <?php echo date('d/m/Y'); ?></th>
				</tr>

				<tr>
					<th colspan="27" style="" class="color"></th>
					<th colspan="3" align="right" style="" class="color"><div class="form-actions">TOTAL</div></th>
				</tr>

				<tr>
					<th colspan="4" style="" class="color" >Cliente: {{$parametros['reporte']['cliente']}}</th>
					<th colspan="2" style="" class="color">Horario: {{$parametros['reporte']['turno']}}</th>
					@for($i = 1; $i <= 7; $i++)
						<th colspan="2" style="" class="color">Personas</th>
						<th style="" class="color">{{$parametros['reporte']['dias'][$i]['personas']}}</th>
					@endfor
					<th style="" class="color">{{$parametros['reporte']['total_dias']}}</th>
					<th style="" class="color">{{$parametros['reporte']['total_horas_ordinarias']}}</th>
					<th style="" class="color">{{$parametros['reporte']['total_horas_extra']}}</th>
					
				</tr>

				<?php
					//convertir las fechas a datetime, para darles el formato necesario
					$fecha1 = new DateTime($parametros['fecha1']);
					$fecha2 = new DateTime($parametros['fecha2']);

					//array con las traducciones correspondientes a espanol
					$meses =[
					'January' => 'Enero',
					'February' => 'Febrero',
					'March' => 'Marzo',
					'April' => 'Abril',
					'May'   => 'Mayo',
					'June'  => 'Junio',
					'July'  => 'Julio',
					'August' => 'Agosto',
					'September' => 'Septiembre',
					'October' => 'Octubre',
					'November' => 'Noviembre',
					'December' => 'Diciembre'];
				?>

				<tr>
					<th colspan="4" style="" class="color">Semana {{$parametros['semana']}}</th>
					<th colspan="2" style="" class="color">Del {{$fecha1->format('j')}} de {{$meses[$fecha1->format('F')]}} @if($fecha1->format('Y') != $fecha2->format('Y')) del {{$fecha1->format('Y')}} @endif al {{$fecha2->format('j')}} de {{$meses[$fecha2->format('F')]}} del {{$fecha2->format('Y')}}</th>
					<th colspan="3" style="" class="color">Lunes {{$parametros['reporte']['dias'][1]['dia']}}</th>
					<th colspan="3" style="" class="color">Martes {{$parametros['reporte']['dias'][2]['dia']}}</th>
					<th colspan="3" style="" class="color">Miercoles {{$parametros['reporte']['dias'][3]['dia']}}</th>
					<th colspan="3" style="" class="color">Jueves {{$parametros['reporte']['dias'][4]['dia']}}</th>
					<th colspan="3" style="" class="color">Viernes {{$parametros['reporte']['dias'][5]['dia']}}</th>
					<th colspan="3" style="" class="color">Sabado {{$parametros['reporte']['dias'][6]['dia']}}</th>
					<th colspan="3" style="" class="color">Domingo {{$parametros['reporte']['dias'][7]['dia']}}</th>
					<th colspan="3" style="" class="color">Total trabajado</th>
					
				</tr>

				<tr>
					<th style="" class="color">#</th>
					<th style="" class="color">ID</th>
					<th style="" class="color">A. Paterno</th>
					<th style="" class="color">A. Materno</th>
					<th style="" class="color">Nombre</th>
					<th style="" class="color">Puesto</th>
					

					@for($i = 0; $i < 7; $i++)
						<th style="" class="color">C.P</th>
						<th style="" class="color">R/T</th>
						<th style="" class="color">O/T</th>
					@endfor

					<th style="" class="color">Dias</th>
					<th style="" class="color">R/T</th>
					<th style="" class="color">O/T</th>
					
				</tr>
			</thead>

			<tbody>
				<?php
				$i = 1;
				?>
				@foreach($parametros['reporte']['empleados'] as $empleado)
					<tr>
						<td>{{$i++}}</td>
						<td>{{$empleado['id']}}</td>
						<td>{{strtoupper($empleado['ap_paterno'])}}</td>
						<td>{{strtoupper($empleado['ap_materno'])}}</td>
						<td>{{strtoupper($empleado['nombre'])}}</td>
						<td>OPERADOR</td>

						

						<!--se usara como contador para los dias trabajados-->
						<?php
						$diasTrabajados = 0;
						?>
						@foreach($empleado['checadas'] as $checada)
							@if($checada != null)
								<td>{{$parametros['reporte']['cliente']}}</td>
								<td>{{$checada->horas_ordinarias}}</td>
								<td>{{$checada->horas_extra}}</td>
								<?php $diasTrabajados++;?>
							@else
								<td></td>
								<td></td>
								<td></td>
							@endif
						@endforeach
						<td>{{$diasTrabajados}}</td>
						<td>{{$empleado['horas_ordinarias']}}</td>
						<td>{{$empleado['horas_extra']}}</td>
								
					</tr>
			@endforeach
			</tbody>

		</table>

		<table hidden="">
			<thead>
			<tr></tr>
				<tr>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
					<th colspan="2">__________________</th>
				<th colspan="11"></th>
				<th colspan="5">__________________</th>
				</tr>
					<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>

						<th colspan="2">Firma de Autorización</th>
				<th colspan="11"></th>
						<th colspan="5">Firma de Supervisor</th>
					</tr>
				<tr></tr>
				<tr>
					<th colspan="3">Comentarios</th>
				</tr>
				
			</thead>
		</table>
		<table class="table table-striped table-bordered table-hover dataTable no-footer" border="2" hidden="">
			<thead><tr>
					<th rowspan="3" colspan="30" class="table table-striped table-bordered table-hover dataTable no-footer" border="2"></th>
				</tr>
			</thead>
		</table>

		</div>
		
</div></div>
	@else
<div class="alert alert-info alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></strong> No se encontro ningun resultado con los parametros especificados.<br><br> 
				
			</div> 


@endif

@endif

@endsection

@section('js')
<script src="{{ asset("static/select2/select2.js") }}" type="text/javascript"></script>
<script src="{{ asset("static/js/jquery.btechco.excelexport.js") }}" type="text/javascript"></script>
<script src="{{ asset("static/js/jquery.base64.js") }}" type="text/javascript"></script>

<script>
	$('.reporte').collapse('show');
    $(document).ready(function () {
    	$("#empleado").select2();
    	@if(isset($parametros['reporte']) && !empty($parametros['reporte']['empleados']))
    		var posicion_boton = $("#resultados").offset().top;
			//hacemos scroll hasta los resultados
			$("html, body").animate({scrollTop:posicion_boton+"px"});
			$('#generarReporte').on('show.bs.collapse', function () {
  				$('.reporte').collapse('hide');
			});
			$('.reporte').on('show.bs.collapse', function () {
  				$('#generarReporte').collapse('hide');
			});
			
			

		@endif
        $("#btnExport").click(function (e) {
        	e.preventDefault();
        	var cliente= "@if(isset($parametros['reporte'])){{$parametros['semana']}} {{$parametros['reporte']['cliente']}}@endif";
        	var worksheet= "@if(isset($parametros['reporte'])){{$parametros['reporte']['cliente']}}@endif"
            $("#tblExport").btechco_excelexport({
                containerid: "tblExport"
               , datatype: $datatype.Table
               , filename: 'semana '+cliente
               , nombre: worksheet
               
            });
        });

         $("#btnCliente").click(function (e) {
         	e.preventDefault();
        	var cliente= "@if(isset($parametros['reporte'])){{$parametros['semana']}} {{$parametros['reporte']['cliente']}}@endif";
        	var worksheet= "@if(isset($parametros['reporte'])){{$parametros['reporte']['cliente']}}@endif"
            $("#tblExport").btechco_excelexport({
                containerid: "tablaCliente"
               , datatype: $datatype.Table
               , filename: 'semana '+cliente +' Cliente'
               , nombre: worksheet
               
            });
        });
    
 $('#cliente').on('change', function(e){
        
        var idCliente = e.target.value;
        var dataString = { 
              idCliente : idCliente             
            };
        $.ajax({
            type: "GET",
            url: "{{ URL::to('empleados/turnos') }}",
            data: dataString,
            dataType: "json",
            cache : false,
            success: function(data){
              $('#turno').empty();             
              if(data.length >0){
                
	            $("#cliente option[value='']").hide();
	           	$('#turno').append('<option value="">Seleccione</option>');
	           	$.each(data,function(index,turnosObj){
	           	$('#turno').append('<option value="'+turnosObj.idTurno+'">'+turnosObj.hora_entrada+" - "+turnosObj.hora_salida+'</option>');
	               });               
              }else{
              	$('#turno').append('<option value="">-------</option>');
	           	$("#hora_entrada").val("");
	         	$("#hora_salida").val("");
	         	$("#horas_ordinarias").val("");	
              } 
          
            } ,error: function(xhr, status, error) {
              alert(error);
            },
        });
        
   
        });
    });

   
</script>
    @stop