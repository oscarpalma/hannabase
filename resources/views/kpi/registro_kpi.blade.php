@extends('base')
@section('cabezera','Editar KPI')
@section('css')
  
<!-- Modal CSS -->
    <link href="/static/css-modal/modal.css" rel="stylesheet">
  	<link href="/static/cssKpi/kpi.css" rel="stylesheet">
<!-- Morris Charts CSS -->
    <link href="/static/bower_components/morrisjs/morris.css" rel="stylesheet">
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

				<div class="col-sm-4">
					<label class="control-label">Semana <text style="color:red">*</text></label>
					<div>
						<select class="form-control" name="semana" id="semana" required>
							<!--en caso de no especificar ninguno-->
							<option value="">Seleccione</option>
							@for($i = 1; $i<=date("W"); $i++)
								<option value="{{$i}}">Semana {{$i}}</option>
							@endfor
						</select>
					</div>
				</div>

				<div class="col-sm-4">
					<label class="control-label">Año <text style="color:red">*</text></label>
					<div>
						<select class="form-control" name="year" id="year">
							<!--en caso de no especificar ninguno-->
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
		<div id="prueba">
		
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
          		<span class="glyphicon glyphicon-dashboard"></span> KPI <span id="area_tabla"></span> Semana <span id="no_semana"></span>
                    <div class="pull-right action-buttons">
                        <div class=" pull-right">
                        <!-- boton para guardar los cambios -->
                           <button type="button" class="btn btn-success btn-xs dropdown-toggle" id="save" title="Guardar">
                          <span class="glyphicon glyphicon-floppy-disk"></span>
                        
                        </button>
                        <button type="button" class="btn btn-success btn-xs dropdown-toggle" id="btnExport" title="Exportar">
                          <span class="fa fa-file-excel-o"></span>
                        
                        </button>

                            
                        </div>
                    </div>
          </div> 
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
     <!-- En el siguiente div se cargará la tabla del KPI una vez obtenida -->                     
    <div class="tabla" id="tblExport">
		
	</div>

	</div>
	</div>

	</div>
	</div>
	</div>
	
 
 

  
@endsection
@section('js')
<!-- se cargan los dos archivos de javascript con el código necesario
para poder editar la tabla y hacer los promedios -->
<script src="{{ asset("static/js/tabla-excel.js") }}" type="text/javascript"></script>
<script src="{{ asset("static/js/tabla-excel-numeros.js") }}" type="text/javascript"></script>
<script src="{{ asset("static/js/jquery.btechco.excelexport.js") }}" type="text/javascript"></script>
<script src="{{ asset("static/js/jquery.base64.js") }}" type="text/javascript"></script>


<script type="text/javascript">



	$(document).ready(function() {

		$("#btnExport").click(function () {
            $("#tblExport").btechco_excelexport({
                containerid: "tblExport"
               , datatype: $datatype.Table
               , filename: 'KPI '+$("#area_tabla").html()+" "+$("#no_semana").html()
            });
        });

	//Variables utilizadas de manera global para almacenar
	//los datos del area, semana y año del KPI buscado	
	var area = "";
	var semana = "";
	var year = "";
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
		              	if (data != null){
		              		//si data no es null entonces se carga el formato de la 
		              		//tabla el div con la clase tabla
			              	$(".tabla").html(data);
			              	//se agrega la semana al titulo del panel
			              	$("#no_semana").html(semana);
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
							/* se llaman las funciones de tablaEditable y soloNumeros
							para poder editar la tabla y permitir evaluar que se ingresen solo números */
							$('#table').tablaEditable().soloNumeros().find('td:first').focus();;
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
		              semana : semana,
		              year : year,
		              _token : '{{ csrf_token() }}'            
		            };
		        //funcion ajax para almacenar los cambios  
		        $.ajax({
		            type: "POST",
		            url: "{{ URL::to('kpi/alta/registro') }}",
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

	});
	



</script>


@stop