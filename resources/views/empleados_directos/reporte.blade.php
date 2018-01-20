@extends('base')
@section('titulo','Generar Reporte')
@section('cabezera','Generar Reporte')
@section('css')
 <link href="/static/select2/select2.css" rel="stylesheet">
@stop
@section('content')
<form class="form-horizontal @if(isset($parametros['reporte']) && !empty($parametros['reporte']['empleados'])) collapse @endif" method="POST" action="{{route('reporte_empleados_crtm')}}" id="generarReporte">
	<div class="panel panel-primary">
		<div class="panel-heading"></div>
		<div class="panel-body">
			<div class="row-sm">					
				<p>Campos marcados con <text style="color:red">*</text> son obligatorios.</p>
				<div class="form-actions"><label>Semana Actual {{date("W")}}</label></div>
			</div>
			<input type="hidden" name="_token" value="{{ csrf_token() }}">	
			<div class="row">
				<div class="col-sm-4">
					<label class="control-label">Empleado</label>
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
					<label class="control-label">Semana <text style="color:red">*</text></label>
					<div>
						<select class="form-control" name="semana">
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
						<!--desde 2013 hasta el anio actual, como en coen-->
							@for($i = date('Y'); $i >= 2017; $i--)
								<option value="{{$i}}">{{$i}}</option>
							@endfor
						</select>
					</div>
				</div>
			</div>

			<div class="row">
				<br>
			    <div class="form-actions">
					<button type="submit" class="btn btn-primary" value="validate" style="margin-right: 15px;">
						Buscar
					</button>
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
                                
                                
                            </ul>
                        </div>
                    </div>
          </div> 
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">

	<div id="dvData" class="tabla">
	<!--Tabla con los resultados de la busqueda-->
		<table class="table table-striped table-bordered table-hover dataTable no-footer" border="2" width="100%" rules="rows" style='text-transform:uppercase' id="tblExport">
			<thead>
				<tr>
					<th colspan="21"></th>
					<th><div class="form-actions">{{$parametros['reporte']['total_dias']}}</div></th>
					<th><div class="form-actions">{{$parametros['reporte']['total_horas']}}</div></th>
					<th><div class="form-actions">{{$parametros['reporte']['total_horas_extra']}}</div></th>
					<th><div class="form-actions">{{$parametros['reporte']['total_prestamos']}}</div></th>
					<th><div class="form-actions">{{$parametros['reporte']['total_descuentos']}}</div></th>
				</tr>

				<tr>
					<th colspan="4">Centro de Trabajo</th>
					<th colspan="3">Del {{$parametros['fecha1']}} al {{$parametros['fecha2']}}</th>
					<th colspan="2">Lunes {{$parametros['reporte']['dias'][1]['dia']}}</th>
					<th colspan="2">Martes {{$parametros['reporte']['dias'][2]['dia']}}</th>
					<th colspan="2">Miercoles {{$parametros['reporte']['dias'][3]['dia']}}</th>
					<th colspan="2">Jueves {{$parametros['reporte']['dias'][4]['dia']}}</th>
					<th colspan="2">Viernes {{$parametros['reporte']['dias'][5]['dia']}}</th>
					<th colspan="2">Sabado {{$parametros['reporte']['dias'][6]['dia']}}</th>
					<th colspan="2">Domingo {{$parametros['reporte']['dias'][7]['dia']}}</th>
					<th colspan="5"><div class="form-actions">Total</div></th>
					</tr>
			</thead>

			<tr>
				<th>#</th>
				<th>ID</th>
				<th><div class="form-actions">A. Paterno</div></th>
				<th><div class="form-actions">A. Materno</div></th>
				<th><div class="form-actions">Nombre</div></th>
				<th><div class="form-actions">Área</div></th>
				<th># de Cuenta</th>
				@for($i = 0; $i < 7; $i++)
					<th>R/T</th>
					<th>O/T</th>
				@endfor
				<th>Dias</th>
				<th>R/T</th>
				<th>O/T</th>
				<th><div class="form-actions">Prestamos</div></th>
				<th><div class="form-actions">Descuentos</div></th>
				
			</tr>

			<?php
				$i = 1;
			?>
			@foreach($parametros['reporte']['empleados'] as $empleado)
				<tr>
					<td>{{$i++}}</td>
					<td>{{array_search($empleado, $parametros['reporte']['empleados'])}}</td>
					<td>{{$empleado['ap_paterno']}}</td>
					<td>{{$empleado['ap_materno']}}</td>
					<td>{{$empleado['nombre']}}</td>
					<td>{{$empleado['area']}}</td>
					@if($empleado['no_cuenta'] != null)
						<td>{{$empleado['no_cuenta']}}</td>
					@else
						<td>N/A</td>
					@endif
					<?php
					$dias = 0;
					?>
					@foreach($empleado['checadas'] as $checada)
						@if($checada != null)
							<td>{{$checada->horas_ordinarias}}</td>
							<td>{{$checada->horas_extra}}</td>
							<?php $dias++;?>
						@else
							<td>0</td>
							<td>0</td>
						@endif
					@endforeach
					<td><div class="form-actions">{{$dias}}</div></td>
					<td><div class="form-actions">{{$empleado['horas_ordinarias']}}</div></td>
					<td><div class="form-actions">{{$empleado['horas_extra']}}</div></td>		
					<td><div class="form-actions">{{$empleado['prestamos']}}</div></td>
					<td><div class="form-actions">{{$empleado['descuentos']}}</div></td>				
				</tr>
			@endforeach

		</table>
	</div>
	</div></div>
	</div>
	</div>
	
	@else
<div class="alert alert-info alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></strong> No se encontro ningun resultado con los parametros especificados.<br><br> 
				
			</div> 
@endif
@endif

@stop

@section('js')
<script src="{{ asset("static/select2/select2.js") }}" type="text/javascript"></script>
<script src="{{ asset("static/js/jquery.btechco.excelexport.js") }}" type="text/javascript"></script>
<script src="{{ asset("static/js/jquery.base64.js") }}" type="text/javascript"></script>

<script>
	$('.reporte').collapse('show');
    $(document).ready(function () {
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
    	$("#empleado").select2();

@if(isset($parametros['reporte']))
        $("#btnExport").click(function () {
            $("#tblExport").btechco_excelexport({
                containerid: "tblExport"
               , datatype: $datatype.Table
               , filename: 'Reporte interno semana '+{{$parametros['semana']}}
            });
        });

  @endif       
    
 
    });

   
</script>
    @stop