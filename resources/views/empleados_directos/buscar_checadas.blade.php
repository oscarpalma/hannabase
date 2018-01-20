@extends('base')
@section('titulo','Buscar Checada')
@section('cabezera','Buscar Checada')
@section('css')

 <link href="/static/select2/select2.css" rel="stylesheet"> 
  
<!-- Modal CSS -->
    <link href="/static/css-modal/modal.css" rel="stylesheet">  
@endsection
@section('content')
<form class="form-horizontal @if(isset($parametros['checadas']) && !empty($parametros['empleadosPorChecada'])) collapse @endif" method="POST" action="{{ route('buscarC_empleados_crtm') }}" id="buscar_checada">
	<div class="panel panel-primary">
		<div class="panel-heading"></div>
		<div class="panel-body">
			<div class="row-sm">					
				<p>Campos marcados con <text style="color:red">*</text> son obligatorios.</p>
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
					<label class="control-label">Desde <text style="color:red">*</text></label>
					<div>
						<input class="form-control" name="fecha1" type="date" value="0001-01-01" max="<?php echo date('Y-m-d'); ?>">
						<!--La fecha 1 o inicial sera 1-enero-0001, para asegurar de encontrar todos los valores posibles -->
					</div>
				</div>

				<div class="col-sm-4">
					<label class="control-label">Hasta <text style="color:red">*</text></label>
					<div>
						<input class="form-control" name="fecha2" type="date" value="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d'); ?>">
						<!--La fecha 2 o final sera el dia actual por defecto-->
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
	@if(isset($parametros['checadas']) && !empty($parametros['empleadosPorChecada'])) 
		<a class="btn btn-primary" role="button" data-toggle="collapse" href=".resultados" aria-expanded="false" aria-controls="resultados">
	  		Mostrar Checadas
		</a>
	@endif
</form>

@if(isset($parametros['checadas']))
@if(!empty($parametros['empleadosPorChecada']))
	<div id="checadas">
	<div class="resultados collapse">
	
	<a class="btn btn-primary" role="button" data-toggle="collapse" href="#buscar_checada" aria-expanded="false" aria-controls="buscar_checada" id="mostrar">
  		Buscar
	</a>
	<br><br>
	<!--Muestra una lista de los filtros de busqueda activos
	*****El intervalo de fechas siempre esta definido*****-->


	
	<br>
	<div id="resultados">
	<p class="text-info"><strong>Filtros Activos:</strong></p>
	@foreach($parametros['filtrosActivos'] as $filtro)
		<li >{{$filtro}}</li>
	@endforeach
	<div class="alert alert-success alert-dismissible" role="alert" hidden="" id="success">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></strong> Se borraron las checadas exitosamente
				
	</div>
	<div class="panel panel-primary">
          <div class="panel-heading">
          		<span class="fa  fa-clock-o"></span> Checadas encontradas
                    <div class="pull-right action-buttons">
                        <div class=" pull-right">
                           <button type="button" class="btn btn-danger btn-xs dropdown-toggle" id="eliminar" title="Eliminar">
                          <span class="glyphicon glyphicon-trash" style="margin-right: 0px;"></span>
                        
                        </button>

                            
                        </div>
                    </div>
          </div> 
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
       <!-- Div que se mostrará solo si se eliminan todos los resultados de la tabla -->
        <div class="alert alert-info alert-dismissible" role="alert" id="vacio" hidden>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></strong> No hay descuentos que mostrar
					
				</div>                    
    <div class="tabla">
	<!--Tabla con los resultados de la busqueda-->
	<table id="tablaChecadas" class="table table-striped table-bordered table-hover dataTable no-footer" border="2" width="100%" rules="rows" style='text-transform:uppercase'>
		<thead>
		<tr>
			<th><input type="checkbox" id="selecTodo" /></th>
			<th><div class="form-actions">#</div></th>
			<th><div class="form-actions">Empleado</div></th>
			<th><div class="form-actions">Fecha</div></th>
			<th><div class="form-actions">Entrada</div></th>
			<th><div class="form-actions">Salida</div></th>
			<th><div class="form-actions">Incidencia</div></th>
			
		</tr>
		</thead>
		<tbody>
		<?php $cont = 1; ?>
		@foreach($parametros['checadas'] as $checada)
			<tr id="{{$checada->idChecada}}">
				<td> <input type="checkbox" name="seleccionado" class="select" /> </td>
				<td hidden>{{$checada->idChecada}}</td>
				<td><div class="form-actions">{{$cont++}}</div></td>
				<td><div class="form-actions">{{$parametros['empleadosPorChecada'][$checada->idChecada]}}</div></td>
				<td><div class="form-actions">{{$checada->fecha}}</div></td>
				<td><div class="form-actions">{{$checada->hora_entrada}}</div></td>
				<td><div class="form-actions">{{$checada->hora_salida}}</div></td>

				<!--mostrar N/A si no hay incidencia-->
				@if($checada->incidencia != null)
					@if($checada->incidencia == 'falta injustificada')
						<td><div class="form-actions"><b><p style="color:red">{{$checada->incidencia}}</p></b></div></td>
					@else
						<td><div class="form-actions"><b><p style="color:green">{{$checada->incidencia}}</p></b></div></td>
					@endif
				@else
					<td><div class="form-actions">N/A</div></td>
				@endif

				</tr>
		@endforeach
		</tbody>
	</table>
	</div></div></div>
	</div>
	</div>
	</div>
	@else
<div class="alert alert-info alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></strong> No se encontro ningun resultado con los parametros especificados.<br><br> 
				
			</div> 
@endif
@endif
<!-- Modal eliminar -->
<div class="modal fade" id="eliminarModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                               
                                <!-- Contenido modal eliminar -->
                                <div class="modal-dialog" >
                                    <div class="modal-content">
                                        <div class="modal-header modal-header-danger">
                                            <h4 class="modal-title">Eliminar Checadas</h4>
                                          </div>
                                          <div class="modal-body">
                                            <p><strong> ¿Esta seguro de eliminar las siguientes checadas?</strong></p>
                                          <div class="tabla-modal">
                                           <table class="table table-striped table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                            
											<th><div class="form-actions">Empleado</div></th>
											<th><div class="form-actions">Fecha</div></th>
											<th><div class="form-actions">Entrada</div></th>
											<th><div class="form-actions">Salida</div></th>
                                         </tr>
                                    </thead>
                                    <tbody id="infoEliminar">
                                    
                                    </tbody>
                                    </table>
                                    </div>

                                            <div class="row">
                                                <div class="col-12-xs text-center">
                                                    <button class="btn btn-success btn-m" id="confirmacionEliminar">Si</button>
                                                    <button class="btn btn-danger btn-m" data-dismiss="modal">No</button>
                                                </div>
                                            </div>
                                          </div>
                                    <!-- /.modal-content -->
                                </div> </div>
                                <!-- /.modal-dialog eliminar-->

                            </div>
                            <!-- /.modal -->
            <!-- /.Modal eliminar --> 
    
@stop

@section('js')
<script src="{{ asset("static/select2/select2.js") }}" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('.resultados').collapse('show');
		@if(isset($parametros['checadas']) && !empty($parametros['empleadosPorChecada']))
			var posicion_boton = $("#resultados").offset().top;
			//hacemos scroll hasta los resultados
			$("html, body").animate({scrollTop:posicion_boton+"px"});
			$('#buscar_checada').on('show.bs.collapse', function () {
  				$('.resultados').collapse('hide');
			});
			$('.resultados').on('show.bs.collapse', function () {
  				
  				$('#buscar_checada').collapse('hide');

			});
		@endif
		$("#empleado").select2();

	var ids=[];
     var i=0;
     $("#eliminar").click(function(){
            
            //Vaciar las filas previas de la tabla
            $("#infoEliminar").html("");
            //vaciar arreglo de ids
            ids=[];
            i=0;
            // Obtenemos todos los valores contenidos en los <td> de las fila
            // seleccionadas
            $(".select:checked").parents("tr").each(function(){
               ids[i]=$(this).find("td").eq(1).html();
                $("#infoEliminar").append('<tr>'+
                                       '<td>'+$(this).find("td").eq(3).html()+'</td>'+
                                       '<td>'+$(this).find("td").eq(4).html()+'</td>'+
                                        '<td>'+$(this).find("td").eq(5).html()+'</td>'+
                                        '<td>'+$(this).find("td").eq(6).html()+'</td>'+
                                        
                                        '</tr>"');
                i++;
                });
            if(i>0)
                $('#eliminarModal').modal();
            });
	
	$("#selecTodo").click(function(){
        if($("#selecTodo").prop("checked")){
            $(".select").prop("checked", true);
        }else{
            $(".select").prop("checked", false);
        }
        
    });

	$("#confirmacionEliminar").on("click",function() {
      
      $( "#load" ).show();
       var dataString = { 
              checadas : ids,
              _token : '{{ csrf_token() }}'
            };
        $.ajax({
            type: "POST",
            url: "{{ URL::to('empleados/crtm/baja_checadas') }}",
            data: dataString,
            dataType: "json",
            cache : false,
            success: function(data){
              $( "#load" ).hide();
             
              if(data){
                $('#eliminarModal').modal('toggle');
                $.each(ids, function(key,value){
                    $("#"+value).fadeOut();
                });
                if($("#tablaChecadas tbody tr").length>1){
	                $("#success").show(600);		                
	                $("#success").delay(2000).hide(600);
                }else{
                	 $("#success").show(600);		                
	                $("#success").delay(2000).hide(600);
	                $("#tablaChecadas").hide();
	                $("#vacio").show(200);
                }     
              } 
          
            } ,error: function(xhr, status, error) {
              alert(error);
            },
        });
    });

	});
</script>
@stop