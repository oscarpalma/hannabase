@extends('base')
@section('cabezera','Actualizar Formato KPI')
@section('css')
  
<!-- Modal CSS -->
    <link href="/static/css-modal/modal.css" rel="stylesheet">
   <link href="/static/cssKpi/kpi.css" rel="stylesheet">

@endsection
@section('content')

<!-- alerta que se muestra en caso de que no se encuentre algun resultado -->
<div class="alert alert-info alert-dismissible" role="alert" hidden="" id="error">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong><span class="glyphicon glyphicon-info" aria-hidden="true"></span></strong> No hay formato de KPI para el área especificada
				
	</div>
<form class="form-horizontal" method="POST" action="" id="buscar_kpi">
	<div class="panel panel-primary">
		<div class="panel-heading"></div>
		<div class="panel-body">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">	
			<div class="row-sm">					
				<p>Campos marcados con <text style="color:red">*</text> son obligatorios.</p>
			</div>
			<div class="row">
				<div class="col-sm-4">
					<label class="control-label">Area <text style="color:red">*</text></label>
					<div>
						<select class="form-control" name="area" id="area" required>
							<!--en caso de no especificar ninguno-->
							<option value="">Seleccione</option>
							@foreach($areas as $area)
								<option value="{{$area->idAreaKpi}}" style="text-transform:uppercase">{{$area->nombre}}</option>
							@endforeach
						</select>
					</div>
				</div>

								
			</div>

			<div class="row">
				

				
					<br>
				   <div class="form-actions">

						<button type="button"  class="btn btn-primary" id="buscar">
							Buscar
						</button>
					</div>
				

			</div>
		</div>
	</div>
	<!-- El boton esta oculto debido a que se mostrara después de realizar la 
	busqueda de forma satisfactoria, esto con el fin de ocultar el panel de busqueda
	para una mejor visualización -->
	<div id="mostrar" hidden>
		<a class="btn btn-primary" role="button" data-toggle="collapse" href=".resultados" aria-expanded="false" aria-controls="resultados">
	  		Mostrar KPI
		</a>
	</div>
</form>


	<!-- Dentro de el siguiente div se encuentran los elementos correspondientes
	a los resultados de la busqueda, es decir la tabla con el formato de kpi de la semana
	solicitada -->
	<div id="kpi">
	<!-- Este div contiene la clase collapse que permite que el panel se pueda 
	ocultar al dar clic en el boton siguiente "Buscar" -->
	 <div class="resultados collapse">
	<!-- El siguiente boton se utiliza para mostrar el panel de busqueda
	en caso de que se necesite realizar una nueva busqueda -->
	<a class="btn btn-primary" role="button" data-toggle="collapse" href="#buscar_kpi" aria-expanded="false" aria-controls="buscar_checada" id="mostrar">
  		Buscar
	</a>
	<br><br>
	<br>
	<!-- El siguiente div se utiliza para hacer descender el scrollbar hasta este punto
	una vez que se muestran los resultados -->
	<div id="resultados">
	<!-- La siguiente alerta se encuentra oculta debido a que solo se mostrará cuando 
	se guarde exitosamente -->
	<div class="alert alert-success alert-dismissible" role="alert" hidden="" id="success">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></strong> Cambios guardados
				
	</div>

	<!--Tabla con los resultados de la busqueda-->
	<div class="panel panel-primary">
          <div class="panel-heading">
          		<span class="glyphicon glyphicon-dashboard"></span> KPI <span id="area_tabla"></span>
                    <div class="pull-right action-buttons">
                        <div class=" pull-right">
                         <button type="button" class="btn btn-success btn-xs dropdown-toggle" id="add" title="Agregar">
                          <span class="glyphicon glyphicon-plus"></span>
                        
                        </button>
                        <button type="button" class="btn btn-success btn-xs dropdown-toggle" id="edit" title="Editar Código HTML">
                          <span class="fa fa-code"></span>
                        
                        </button>
                           <button type="button" class="btn btn-success btn-xs dropdown-toggle" id="save" title="Guardar">
                          <span class="glyphicon glyphicon-floppy-disk"></span>
                        
                        </button>

                            
                        </div>
                    </div>
          </div> 
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                          
    <div class="tabla">
		
	</div>
	</div>
	</div>
	</div>
	</div>
	</div>
	
 
 <!-- Modales -->


 <!-- Modal editar. Se utiliza para mostrar el código html de la tabla para permitir 
 realizar los cambios correspondientes, directamente en el código.-->
<div class="modal fade" id="editarModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                               
                                <!-- Contenido modal editar -->
                                <div class="modal-dialog" >
                                    <div class="modal-content">
                                        <div class="modal-header modal-header-success">
                                            <h4 class="modal-title">Editar Código HTML</h4>
                                          </div>
                                          <div class="modal-body">
                                            <p><strong>Código HTML</strong></p>
                                          	<textarea id="codigoHtml" class="form-control" cols="100" rows="20"></textarea>
                                          	<br>
                                            <div class="row">
                                                <div class="col-12-xs text-center">
                                                    <button class="btn btn-success btn-m" id="aplicar">Aplicar</button>
                                                    
                                                </div>
                                            </div>
                                          </div>
                                    <!-- /.modal-content -->
                                </div> </div>
                                <!-- /.modal-dialog editar-->

                            </div>
                            <!-- /.modal -->
            <!-- /.Modal editar -->

    <!-- Modal modificar. Permite agregar un nuevo tipo de KPI, solo basta ingresar la cantidad de logros
    que contendrá el nuevo tipo de KPI -->
<div class="modal fade" id="agregarKpiModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                               
                                <!-- Contenido modal editar -->
                                <div class="modal-dialog" >
                                    <div class="modal-content">
                                        <div class="modal-header modal-header-success">
                                            <h4 class="modal-title">Agregar Tipo de KPI</h4>
                                          </div>
                                          <div class="modal-body">
                                          <!-- Esta comentado por que en un principio se solicitaba que se ingresara el
                                          nombre del nuevo tipo de KPI, la unidad y los logros, pero se descartó debido a que se 
                                          puede hacer directamente en la tabla -->
                                           <!-- <label>Tipo de KPI </label>
                                            <input type="text" class="form-control" name="tipokpi">
                                            <label>Unidad </label>
                                            <input type="text" class="form-control" name="unidad">
                                            <hr>
                                          	<label>Logro </label>
                                          	<div id="logros">
                                          	<div id="fila_1">
                                            <input type="text" class="form-control" name="logro[]">
                  							</div>
                  							</div>
                  							<br>
                  							<div class="row">
												<div class="col-sm-4">
													
													<div>
														<a href="#" class="btn btn-sm btn-success" id="mas" title="Agregar turno"><span class="glyphicon glyphicon-plus"></span>  </a>
														<a href="#" class="btn btn-sm btn-danger" id="menos" title="Eliminar turno"><span class="glyphicon glyphicon-minus"></span>  </a>
													</div>
												</div>
											</div>-->
											<label>Cantidad de logros </label>
                                            <input type="number" id="cantidadLogros" class="form-control">  						
                                          	<br>
                                            <div class="row">
                                                <div class="col-12-xs text-center">
                                                    <button class="btn btn-success btn-m" id="agregar">Agregar</button>
                                                    
                                                </div>
                                            </div>

                                          </div>
                                    <!-- /.modal-content -->
                                </div> </div>
                                <!-- /.modal-dialog editar-->

                            </div>
                            <!-- /.modal -->
            <!-- /.Modal editar -->

  
@endsection
@section('js')
<!-- se cargan los dos archivos de javascript con el código necesario
para poder editar la tabla y hacer los promedios -->
<script src="{{ asset("static/js/tabla-excel.js") }}" type="text/javascript"></script>
<script src="{{ asset("static/js/tabla-excel-numeros.js") }}" type="text/javascript"></script>
<script type="text/javascript">



	$(document).ready(function() {
	//Variable utilizada de manera global para almacenar
	//los datos del area	
	var area = "";
	
	//Función para realizar la busqueda del formato de KPI
	$('#buscar').click(function() {
        			//Se obtienen los valores de los campos y se almacenan en la variables
        			area = $("#area").val();
        			semana = $("#semana").val();
        			year = $("#year").val();
        			var dataString = { 
		              area : area,
		              semana : semana,
		              year : year             
		            };
		        $.ajax({
		            type: "GET",
		            url: "{{ URL::to('kpi/obtener_tabla_ajax') }}",
		            data: dataString,
		            dataType: "json",
		            cache : false,
		            success: function(data){
		              //Se verifica que el valor de data no sea null
		              if(data != null){
		              		//si data no es null entonces se carga el formato de la 
		              		//tabla el div con la clase tabla
			              	$(".tabla").html(data);
			              	//se obtiene el combobox del area
			              	var combo = document.getElementById("area");
							// se obtiene el nombre del área seleccionada y se agrega al titulo del panel
			              	$("#area_tabla").html(combo.options[area].text);
							/* se agrega la clase collapse al panel de busqueda para que se oculte */
							$( "#buscar_kpi" ).addClass( "collapse" );
							/* se muestra el boton del panel de busqueda
							que se encontraba oculto, para poder visualizar de nuevo el panel de 
							busqueda*/
							$("#mostrar").show();
							/* se llama la funcione de tablaEditable
							para poder editar la tabla */
							$('#table').tablaEditable();
							/* se mustra el div con la clase resultados */
							$('.resultados').collapse('show');
							/* se obtiene la posicion del div con id resultados */
							var posicion = $("#resultados").offset().top;
							//hacemos scroll hasta los resultados
							$("html, body").animate({scrollTop:posicion+"px"});
						}else{
							/*si data es null, entonces se muestra el mensaje que informa que no se
							encontro ningun resultado y luego se oculta*/
							$("#error").show(600);
		                
                      		$("#error").delay(2000).hide(600);
						}
					} ,error: function(xhr, status, error) {
		              
		            },
		        });
    });	
	/* la siguiente funcion permite detectar cuando el panel de busqueda
	se muestra para ocultar el div de resultados */
	$('#buscar_kpi').on('show.bs.collapse', function () {
  				$('.resultados').collapse('hide');
			});
	/* la siguiente funcion permite detectar cuando el div de resultados 
	se mustra para ocultar el panel de busqueda */
			$('.resultados').on('show.bs.collapse', function () {
  				
  				$('#buscar_kpi').collapse('hide');

			});
	//funcion para guardar los cambios en la tabla
	$('#save').click(function() {
		//obtenemos el código html de la tabla
		var tabla = $(".tabla").html();
		//arreglo con los datos que seran enviados al controlador
		var dataString = { 
		              tabla : tabla,
		              area : area,
		              
		              _token : '{{ csrf_token() }}'            
		            };
		        //funcion ajax para almacenar los cambios      
		        $.ajax({
		            type: "POST",
		            url: "{{ URL::to('kpi/actualizar/formato') }}",
		            data: dataString,
		            dataType: "json",
		            cache : false,
		            success: function(data){
		              
		              //se evalua que los datos se guardaron de forma correcta
		              if (data) {
		              	/* se muestra el mensaje que confirma que se guardo de 
		              	forma satisfactoria y se oculta posteriormente después del
		              	tiempo especificado */
		              	$("#success").show(600);
		                
                      	$("#success").delay(2000).hide(600);
		              }
		              	
					} ,error: function(xhr, status, error) {
		              
		            },
		        });

	});
	/* funcion que muestra un modal donde se puede editar
	el código html de la tabla */
	$('#edit').click(function() {
		//se obtiene el código html de la tabla
		var tabla = $(".tabla").html();
		//se agrega el código html al textarea del modal
		$("#codigoHtml").val(tabla);
		//se muestra el modal
		$('#editarModal').modal();
	});
	// funcion para mostrar el modal que permite agregar un nuevo tipo de KPI
	$('#add').click(function() {
		
		$('#agregarKpiModal').modal();
	});
	/* funcion que permite aplicar los cambios en el código html */
	$('#aplicar').click(function() {
		//se obtiene el código html del textarea del modal para editar
		var tabla = $("#codigoHtml").val();
		//se inserta el código html al div con clase tabla
		//esto sustituye la actual
		$(".tabla").html(tabla);
		//se vuelve a llamar la función de tablaEditable para 
		//permitir editar las nuevas filas agregadas
		$('#table').tablaEditable();
		//se oculta el modal
		$('#editarModal').modal('toggle');
	});

	$('#agregar').click(function() {
		/* este código esta comentado debido a que era parte del modal 
		para agregar un nuevo tipo de KPI, ingresando nombre de nuevo tipo de KPI,
		unidad y los logros. Se mantiene para futuras referencias */
		/*var rowspan = $('input[name^="logro"]').length;
		var i = 0;
		var fila;
		$('input[name^="logro"]').each(function() {
		if (i==0){
			fila = '<tr>'+ 
					'<td rowspan="'+rowspan+'">'+$('input[name=tipokpi]').val()+'</td>'+
					'<td rowspan="'+rowspan+'">'+$('input[name=unidad]').val()+'</td>'+
					'<td>'+$(this).val()+'</td>'+
					'<td></td>'+
					'<td></td>'+
					'<td></td>'+
					'<td></td>'+
					'<td></td>'+
					'<td></td>'+
					'<td></td>'+
					'<td></td>'+
					'</tr>';
		}else{
			fila += '<tr>'+
					'<td>'+$(this).val()+'</td>'+
					'<td></td>'+
					'<td></td>'+
					'<td></td>'+
					'<td></td>'+
					'<td></td>'+
					'<td></td>'+
					'<td></td>'+
					'<td></td>'+
					'</tr>';
		} 
		i++;
	});
		$('#table tr:last').after(fila);
		$('#table').tablaEditable().numericInputExample().find('td:first').focus();*/
		//Se obtiene la cantidad de logros ingresados
		var rowspan = $("#cantidadLogros").val();
		/* se crea una variable para almacenar el código html
		del nuevo tipo de KPI a ingresar. Aquí solo se crea el código de la fila
		que contendrá el tipo de KPI, unidad y el primer logro. Se le agrega rowspan
		para que abarque el numero de filas equivalentes al numero de logros a ingresar*/
		var fila = '\n<tr>'+ 
					'\n<td rowspan="'+rowspan+'"></td>'+
					'\n<td rowspan="'+rowspan+'"></td>'+
					'\n<td></td>'+
					'\n<td></td>'+
					'\n<td></td>'+
					'\n<td></td>'+
					'\n<td></td>'+
					'\n<td></td>'+
					'\n<td></td>'+
					'\n<td></td>'+
					'\n<td></td>'+
					'\n</tr>';
		/* En caso de que se haya ingresado una cantidad mayor a 1,
		se crea un for para crear el código html para la cantidad de logros solicitados*/
		for(var i=1; i<rowspan; i++){
			/* se concatena lo que ya se tiene en fila con el codigo html para 
			las nuevas filas dependiendo de la cantidad de logros que se ha ingresado*/
			fila += '\n<tr>'+
					'\n<td></td>'+
					'\n<td></td>'+
					'\n<td></td>'+
					'\n<td></td>'+
					'\n<td></td>'+
					'\n<td></td>'+
					'\n<td></td>'+
					'\n<td></td>'+
					'\n<td></td>'+
					'\n</tr>';
		}
		//Se agrega la nueva fila al final de la tabla
		$('#table tr:last').after(fila);
		//Se vuelve a llamar la funcion tablaEditable para permitir editar la tabla
		$('#table').tablaEditable();
		//Se oculta el modal
		$('#agregarKpiModal').modal('toggle');
	});
	//Código que no se utiliza al momento
	/*var filas=1;
		$("#mas").click(function (e) {
			e.preventDefault();
			if(filas<5){
				$("#logros").append('<div id="fila_'+(filas+1)+'"><br> <input type="text" class="form-control" name="logro[]"></div>');
	            filas++;
        	}
		});

		$("#menos").click(function (e) {
			e.preventDefault();
			if (filas>1) {
				$("#fila_"+filas).remove();
				filas--;
			};
		});*/

});
	



</script>


@stop