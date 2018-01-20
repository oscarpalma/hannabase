@extends('base')
@section('cabezera','Lista de Descuentos')
@section('css')
<!-- Modal CSS -->
    <link href="/static/css-modal/modal.css" rel="stylesheet">
@endsection
@section('content')
       
 
<form class="form-inline @if(isset($descuentos) && count ($descuentos) > 0) collapse @endif" role="form" method="POST" action="" id="buscarLista">
	<div class="panel panel-primary">
		<div class="panel-heading"></div>
		<div class="panel-body">
			
			<input type="hidden" name="_token" value="{{ csrf_token() }}">	
			
				
				<div class="form-group">
			    <label class="control-label">Semana:</label>
					
						<select class="form-control" name="semana">
							@for($i = 1; $i<=date("W"); $i++)
								<option value="{{$i}}">Semana {{$i}}</option>
							@endfor
						</select>
			  </div>
				
				<button type="submit" class="btn btn-primary" value="validate" >Buscar
					</button>
		</div>
	</div>
	@if(isset($descuentos) && count ($descuentos) > 0)
		
		<a class="btn btn-primary" role="button" data-toggle="collapse" href=".reporte" aria-expanded="false" aria-controls="reporte">
	  		Mostrar Lista
		</a>
	@endif
</form>
@if(isset($descuentos))
	
		@if ( !count ($descuentos) > 0 ) 

				<div class="alert alert-info alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></strong> No hay descuentos registrados en la semana especificada<br><br> 
					
				</div>
			@else
			<div class="reporte collapse">
				<a class="btn btn-primary" role="button" data-toggle="collapse" href="#buscarLista" aria-expanded="false" aria-controls="buscarLista" id="mostrar">
  					Buscar
				</a>
				
				
				
		<div id="resultados">
		<br>
			
			
	<div class="alert alert-success alert-dismissible" role="alert" id="success" hidden>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></strong> Se elimino el descuento exitosamente.
				
			</div>

	<div class="row">
					<div class="col-sm-4">
						<input id="buscar" class="form-control" placeholder="Busqueda">
					</div>
					
	</div>
	<br>
	<div class="panel panel-primary">
          <div class="panel-heading">
          		<span class="fa  fa-bar-chart-o"></span> Descuentos - Semana {{$semana}}
                    <div class="pull-right action-buttons">
                        <div class="btn-group pull-right">
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
			<table class="table table-striped table-bordered table-hover dataTable no-footer" border="2" width="100%" rules="rows" style='text-transform:uppercase' id='tablaDescuentos'> 
			    <thead>
					<tr>
						<th><input type="checkbox" id="selecTodo" /></th>
						<th>No. Empleado</th>
						<th>Nombre</th>
						<th>Material</th>
						<th>Precio</th>
						<th>Fecha</th>
						
					</tr>
				</thead>
				
				<tbody>
					@foreach($descuentos as $descuento)
					<tr id="{{$descuento['id']}}">
						<td> <input type="checkbox" name="seleccionado" class="select" /> </td>
						<td>{{$descuento['no_empleado']}}</td>
						<td >{{$descuento['nombre']}}</td>
						<td >{{$descuento['material']}}</td>
						<td >{{$descuento['precio']}}</td>
						<td>{{$descuento['fecha']}}</td>
						
						
					</tr>
				</tbody>
			    @endforeach
			</table>
			</div>
			</div>
			</div>
			</div>
			</div>
			@endif
		

<!-- Modal eliminar -->
<div class="modal fade" id="eliminarModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                               
                                <!-- Contenido modal eliminar -->
                                <div class="modal-dialog" >
                                    <div class="modal-content">
                                        <div class="modal-header modal-header-danger">
                                            <h4 class="modal-title">Eliminar Descuentos</h4>
                                          </div>
                                          <div class="modal-body">
                                            <p><strong> ¿Esta seguro de eliminar los siguientes descuentos?</strong></p>
                                           <div class="tabla-modal">
                                           <table class="table table-striped table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                            <th><div class="form-actions">#</div></th>
											<th><div class="form-actions">Nombre</div></th>
											<th><div class="form-actions">Material</div></th>
											<th><div class="form-actions">Precio</div></th>
											<th><div class="form-actions">Fecha</div></th>
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

@endif


@endsection

@section('js')
<script type="text/javascript">
	$('.reporte').collapse('show');
	 $(document).ready(function () {
    	
    	@if(isset($descuentos) && count ($descuentos) > 0)
    		var posicion = $("#resultados").offset().top;
			//hacemos scroll hasta los resultados
			$("html, body").animate({scrollTop:posicion+"px"});
			$('#buscarLista').on('show.bs.collapse', function () {
  				$('.reporte').collapse('hide');
			});
			$('.reporte').on('show.bs.collapse', function () {
  				$('#buscarLista').collapse('hide');
			});
			
			

		@endif

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
               ids[i]=$(this).attr('id');

                $("#infoEliminar").append('<tr>'+
                                       '<td>'+$(this).find("td").eq(1).html()+'</td>'+
                                       '<td>'+$(this).find("td").eq(2).html()+'</td>'+
                                        '<td>'+$(this).find("td").eq(3).html()+'</td>'+
                                        '<td>'+$(this).find("td").eq(4).html()+'</td>'+
                                        '<td>'+$(this).find("td").eq(5).html()+'</td>'+
                                        '</tr>"');
                i++;
                });
            if(i>0)
                $('#eliminarModal').modal();
            });


	$("#confirmacionEliminar").on("click",function() {
      
     
       var dataString = { 
              descuentos : ids,
              _token : '{{ csrf_token() }}'
            };
        $.ajax({
            type: "POST",
            url: "{{ URL::to('filtro/baja/descuento') }}",
            data: dataString,
            dataType: "json",
            cache : false,
            success: function(data){
             
             
              if(data){
                $('#eliminarModal').modal('toggle');
                $.each(ids, function(key,value){
                    $("#"+value).fadeOut();
                });
                
                if($("#tablaDescuentos tbody tr").length>1){
	                $("#success").show(600);		                
	                $("#success").delay(2000).hide(600);
                }else{
                	 $("#success").show(600);
                	 $("#success").delay(2000).hide(600);
                	 $("#tablaDescuentos").hide();
                	 $("#vacio").show(200);
                }     
              } 
          
            } ,error: function(xhr, status, error) {
              alert(error);
            },
        });
    });

		$("#selecTodo").click(function(){
        if($("#selecTodo").prop("checked")){
            $(".select").prop("checked", true);
        }else{
            $(".select").prop("checked", false);
        }
        
    });

	});
</script>
@endsection