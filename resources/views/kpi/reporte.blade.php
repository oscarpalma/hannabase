@extends('layouts.dashboard')
@section('page_heading','Logros')
@section('head')

@stop
@section('section')

@if(Session::has('success'))
	

<div class="alert alert-success alert-dismissible" role="alert" id="success">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span></strong> {{Session::get('success')}}
				
			</div>
@endif
<form class="form-horizontal" role="form" method="POST" action="{{ route('kpi_reporte') }}" >
	<div class="panel panel-primary">
		<div class="panel-heading"><strong></strong></div>
		<div class="panel-body">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">	
			<div class="row-sm">					
				<p>Campos marcados con <text style="color:red">*</text> son obligatorios.</p>
				
			</div>
			<div class="row">
				<div class="col-sm-4">
					<label class="control-label">Area <text style="color:red">*</text></label>
					<div>
						<select class="form-control" id="area" name="area" required="">
							<!--en caso de no especificar ninguno-->
							<option value="">Seleccione</option>
							@foreach($areas as $area)
							 <option value="{{$area->idAreaCt}}">{{$area->nombre}}</option>
							 @endforeach 
						</select>
					</div>
				</div>

				<div class="col-sm-4">
					<label class="control-label">Por <text style="color:red">*</text></label>
					<div>
						<select class="form-control" name="por" id="por" required="">
							
							<option value="semana">Semana</option>
							<option value="mes">Mes</option>
							<option value="anual">Año</option>
							
						</select>
					</div>
				</div>

				<div class="col-sm-4">
					<label class="control-label" id="etiqueta">Semana <text style="color:red">*</text></label>
					<select class="form-control" name="valor" id="selector">
						@for($s = 1; $s <= date('W'); $s++)
							<option value="{{$s}}">Semana {{$s}}</option>
						@endfor
					</select>
					<text id="nota"><strong>Nota:</strong> se toma en cuenta solo el año actual</text>
				</div>
				
			</div>

			<div class="row">
			
				

				

				
					<br>
				    <center>
						<button type="submit" class="btn btn-primary" value="validate" style="margin-right: 15px;">
							Buscar
						</button>
						
					</center>
				

			</div>
		</div>
	</div>
</form>

@if(Session::has('resultados'))
@if(count(Session::get('resultados'))>0)
	<br>
	
	<h1>Reporte </h1>
	
	<br>

	<!--Tabla con los resultados de la busqueda-->
	<div id="dvData" style="overflow:scroll; overflow:auto;">
		<table class="table table-striped table-bordered table-hover dataTable no-footer" border="2" width="100%" rules="rows" style='text-transform:uppercase' id="exportTable">
			<thead >
				

				<tr>
					<th>#</th>
					<th>Tipo de KPI</th>
					<th>Unidad</th>
					
					<th>Logro</th>
					
					
					<th>Lunes</th>
					<th>Martes</th>
					<th>Miercoles</th>
					<th>Jueves</th>
					<th>Viernes</th>
					<th>Sabado</th>
					<th>Domingo</th>
					<th>Total</th>
				</tr>

				
				
			</thead>

			<tbody>
				<?php
				$i = 1;
				?>
				@foreach(Session::get('resultados') as $resultados)
					<tr>
						<td>{{$i++}}</td>
						<td>{{$resultados['tipo_kpi']}}</td>
						<td>{{$resultados['unidad']}}</td>
						@foreach($resultados['logros'] as $logros)
						<td rowspan="2">{{round($logros->plan,0)}}</td>
						@endforeach
						
						
								
					</tr>
				@endforeach
				
			</tbody>

		</table>



	</div>
	<br>
	<div class="row">
        <div class="col-lg-8" style="">
        	<h1>Grafica</h1>
    		<canvas id="cbar" ></canvas>
		</div>
	</div>

<button onclick="imprimir();" class="btn btn-primary">Exportar a PDF</button>
<br>

	<br><br>
	@else
<div class="alert alert-info alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong>¡Sin resultado!</strong> No se encontro ningun resultado con los parametros especificados.<br><br> 
				
			</div> 


@endif

@endif

 

<script>



    $(document).ready(function () {
       
       $('#por').on('change', function(e){
	        
	        if(e.target.value == 'semana'){
		        $("#selector").empty();
		        $("#etiqueta").empty();
		        $("#nota").empty();
		        $("#nota").append("<strong>Nota:</strong> se toma en cuenta solo el año actual");
		        $("#etiqueta").append("Semana <text style='color:red'>*</text>");

		        for(var s = 1; s < 54; s++){
		        	$("#selector").append('<option value="' + s + '" >Semana ' + s + '</option>');
		        }

		    }

		    if(e.target.value == 'mes'){
		    	$("#selector").empty();
		    	$("#etiqueta").empty();
		        $("#nota").empty();
		        $("#nota").append("<strong>Nota:</strong> se toma en cuenta solo el año actual");
		    	$("#etiqueta").append("Mes <text style='color:red'>*</text>");
		    	$("#selector").append('<option value="1">Enero</option>');		    	
		    	$("#selector").append('<option value="2">Febrero</option>');
		    	$("#selector").append('<option value="3">Marzo</option>');
		    	$("#selector").append('<option value="4">Abril</option>');
		    	$("#selector").append('<option value="5">Mayo</option>');
		    	$("#selector").append('<option value="6">Junio</option>');
		    	$("#selector").append('<option value="7">Julio</option>');
		    	$("#selector").append('<option value="8">Agosto</option>');
		    	$("#selector").append('<option value="9">Septiembre</option>');
		    	$("#selector").append('<option value="10">Octubre</option>');
		    	$("#selector").append('<option value="11">Noviembre</option>');
		    	$("#selector").append('<option value="12">Diciembre</option>');
		    }

		    if(e.target.value == 'anual'){
		    	$("#selector").empty();
		    	$("#etiqueta").empty();
		        $("#nota").empty();
		    	$("#etiqueta").append("Año <text style='color:red'>*</text>");	    	
		    	$("#selector").append('<option value="2016">2016</option>');
		    	$("#selector").append('<option value="2017">2017</option>');
		    }
	    });

	$('#area').on('change', function(e){
    
    var idAreaCt = e.target.value;
		     $.ajax({
		            type: "GET",
		            url: "{{ URL::to('kpi/obtenerLogros') }}",
		            data: { id:idAreaCt},
		            dataType: "json",
		            cache : false,
		            success: function(data){
		            	$('#tipo').empty();
		              	if(data.length>0){		              		   	
		       		    	$('#tipo').append('<option value="">Seleccione</option>');
					       	$.each(data,function(index,tiposObj){
					       		$('#tipo').append('<option value="'+tiposObj.idTipoKpi+'">'+tiposObj.nombre+'</option>');
					       		
					       	});
			       		}else{
			       			$('#tipo').append('<option value="">-------</option>');
			       		}
		          
		            } ,error: function(xhr, status, error) {
		              alert(error);
		            },

		        });
	
});
    });

   
</script>




@stop