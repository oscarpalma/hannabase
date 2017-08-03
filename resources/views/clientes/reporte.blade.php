@extends('layouts.dashboard')
@section('page_heading','Generar Reporte de Requerimiento')
@section('head')
<link rel="stylesheet" href="{{ asset("assets/stylesheets/select2.css") }}" />
<link rel="stylesheet" href="http://kendo.cdn.telerik.com/2016.2.607/styles/kendo.common.min.css"/>
    <link rel="stylesheet" href="http://kendo.cdn.telerik.com/2016.2.607/styles/kendo.rtl.min.css"/>
    <link rel="stylesheet" href="http://kendo.cdn.telerik.com/2016.2.607/styles/kendo.silver.min.css"/>
    <link rel="stylesheet" href="http://kendo.cdn.telerik.com/2016.2.607/styles/kendo.mobile.all.min.css"/>

    
    
@stop
@section('section')


@if(Session::has('mensaje'))
    <script type="text/javascript">
        window.onload = function(){ alert("{{Session::get('mensaje')}}");}
    </script>
@endif

<!--
<script>
  $(document).ready(function(){
    $(".time_element").timepicki();
  });
</script>
-->

<form class="form-horizontal" role="form" method="POST" action="{{ route('clientes/reporte') }}" id="detalle_reporte" >
<input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="panel panel-primary">
		<div class="panel-heading"><strong>Datos</strong></div>
		<div class="panel-body">
			<div class="row-sm">					
				<p>Campos marcados con <text style="color:red">*</text> son obligatorios.</p>
			</div>
			<div class="row">
			<div class="col-sm-4">
				<label class="control-label">Empresa<text style="color:red">*</text></label>
					<div>
						<select class="form-control" name="cliente" id="clientes" required="">
							<option value="">SELECCIONAR</option>
							@foreach($info['clientes'] as $clientes)
								<option  value="{{$clientes->idCliente}}">{{$clientes->nombre}}</option>
							@endforeach
						</select>	
					</div>
			</div>		
				<div class="col-sm-4">
					<label class="control-label">Por <text style="color:red">*</text></label>
					<div>
						<select class="form-control" name="por" id="por">
							
								<option value="semana">Semana </option>
								<option value="mes">Mes </option>
								<option value="anual">Año</option>
							
						</select>
					</div>
				</div>

				<div class="col-sm-4">
					<label class="control-label" id="etiqueta">Semana <text style="color:red">*</text></label>
					<select class="form-control" name="valor" id="selector">
						@for($s = 1; $s <= 53; $s++)
							<option value="{{$s}}">Semana {{$s}}</option>
						@endfor
					</select>
					<text id="nota"><strong>Nota:</strong> se toma en cuenta solo el año actual</text>
				</div>
			</div>
			
			<br>
		    <center>
				<button type="submit" class="btn btn-primary" value="validate" style="margin-right: 15px;">
					Buscar
				</button>
			</center>

		</div>
	</div>
</form>

<script type="text/javascript">
	$(document).ready(function() {
		$('#por').on('change', function(e){
	        console.log(e);
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


	});
</script>

@if(isset($info['requerimientos']))
@if(count($info['ingreso'])>0)

	<br>
	
	<h1>Reporte </h1>
	
	<br>

	<!--Tabla con los resultados de la busqueda-->
	<div id="dvData" style="overflow:scroll; overflow:auto;">
		<table class="table table-striped table-bordered table-hover dataTable no-footer" border="2" width="100%" rules="rows" style='text-transform:uppercase' id="exportTable">
			<thead >
				

				<tr>
					<th>Cliente</th>
					<th>Fecha de Captura</th>
					<th>Requerimiento</th>
					<th>Ingreso</th>

				</tr>

				<?php
					//convertir las fechas a datetime, para darles el formato necesario
					// $fecha1 = new DateTime($parametros['fecha1']);
					// $fecha2 = new DateTime($parametros['fecha2']);

					//array con las traducciones correspondientes a espanol
					$dias =[
					'Monday' => 'Lunes',
					'Tuesday' => 'Martes',
					'Wensday' => 'Miercoles',
					'Thursday' => 'Jueves',
					'Friday'   => 'Friday',
					'Saturday'  => 'Sabado',
					'Sunday'  => 'Domingo'];
				?>

				
			</thead>

			<tbody>
				
				@foreach($info['requerimientos'] as $requerimiento)
					<tr>
						<td>{{$requerimiento->idcliente}}</td>
						<td>{{$requerimiento->fecha_ingreso}}</td>
						<td>{{$requerimiento->requerimiento}}</td>
						<td>{{$requerimiento->ingreso}}</td>
								
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
       
    
 		$("#proveedor").select2();
		$("#cliente").select2();

	$('#cliente').on('change', function(e){
    console.log(e);
    var idCliente = e.target.value;
	$("#cliente option[value='null']").hide();
	
    if($("#cliente").val() != "null"){

	    $.get('/ajax-cliente?idCliente=' + idCliente, function(data) {
	    	//console.log(data);

	    	//Muestra los turnos segun el cliente que se ha seleccionado
	       	$('#turno').empty();
	       	$.each(data,function(index,turnosObj){
	       	$('#turno').append('<option value="'+turnosObj.idTurno+'">'+turnosObj.hora_entrada+" - "+turnosObj.hora_salida+'</option>');
	       	});

	    });
	}

	else{
		$('#turno').empty();
	}
});


	
//number_format($parametros['total_saldo'],2)
@if(isset($i))
var semanas=[];
var requerimientos=[];

@foreach ($info['requerimientos'] as $requerimiento)
		semanas.push( {"semana": "{{$transaccion->semana}}"});
		requerimientos.push( {"requerimiento": "{{$requerimiento->requerimiento}}"});
@endforeach 
var unicos =$.unique(semanas);
var bdata = {

        labels : semanas.map((el) => el.semana),
        datasets : [
            
            {
            	label: "life expectancy (years)",
               fillColor: "rgba(151,187,205,0.5)",
                strokeColor: "rgba(151,187,205,0.8)",
                highlightFill: "rgba(151,187,205,0.75)",
                highlightStroke: "rgba(151,187,205,1)",
                data : cargos.map((el) => el.cargo)
            }
        ]

    }
    var cbar = document.getElementById("cbar").getContext("2d");
    new Chart(cbar).Bar(bdata, {
            responsive : true,
            scaleShowLabels : true,
        });
    @endif


    });


   
   // function imprimir(){

   // 	var cbarr = document.getElementById("cbar");
   // 	var tabla = document.getElementById("reporte");
   //   var win=window.open();
   //   	//alert(cbarr.toDataURL());

   //      win.document.write("<br><img src='"+cbarr.toDataURL()+"'/>"+tabla);
   //      win.print();
   //      win.location.reload();
   // }

</script>
<link rel="stylesheet" type="text/css" href="http://www.shieldui.com/shared/components/latest/css/light/all.min.css" />
<script type="text/javascript" src="http://www.shieldui.com/shared/components/latest/js/shieldui-all.min.js"></script>
<script type="text/javascript" src="http://www.shieldui.com/shared/components/latest/js/jszip.min.js"></script>

<script type="text/javascript">
    jQuery(function ($) {
        $("#exportButton").click(function () {
            // parse the HTML table element having an id=exportTable
            var dataSource = shield.DataSource.create({
                data: "#exportTable",
                schema: {
                    type: "table",
                    fields: {
                        FACTURA: { type: String },
                        Age: { type: Number },
                        Email: { type: String }
                    }
                }
            });

            // when parsing is done, export the data to PDF
            dataSource.read().then(function (data) {
                var pdf = new shield.exp.PDFDocument({
                    author: "PrepBootstrap",
                    created: new Date()
                });

                pdf.addPage("a4", "portrait");

                pdf.table(
                    50,
                    50,
                    data,
                    [
                        { field: "Name", title: "Person Name", width: 200 },
                        { field: "Age", title: "Age", width: 50 },
                        { field: "Email", title: "Email Address", width: 200 }
                    ],
                    {
                        margins: {
                            top: 50,
                            left: 50
                        }
                    }
                );

                pdf.saveAs({
                    fileName: "PrepBootstrapPDF"
                });
            });
        });
    });

    @if(isset($i))
    function imprimir(){
var cbarr = document.getElementById("cbar");

var imgData = cbarr.toDataURL("");

var doc = new jsPDF('landscape','pt','letter' ,'p');

doc.setFontSize(8);
doc.text(295, 50, "CORE RESOURCES TRADING AND MANAGEMENT S DE RL DE CV",0);
doc.text(305, 60, "ACAD-09 HISTORIAL DE FACTURAS DE PROVEEDORES",0);
doc.text(10, 70, "PROVEEDOR: {{strtoupper($parametros['proveedor']->nombre)}}",0);
doc.text(10, 80, "CONTACTO: {{strtoupper($parametros['proveedor']->contacto)}}",0);
doc.text(10, 90, "TELEFONO: {{strtoupper($parametros['proveedor']->telefono)}}",0);
doc.text(10, 100, "EMAIL: {{strtoupper($parametros['proveedor']->email)}}",0);
doc.text(10, 110, "CREDITO: {{strtoupper($parametros['proveedor']->credito)}}",0);
doc.addImage(imgData, 250, 80, 330, 120);
//var columns = ["#", "FACTURA", "PROVEEDOR","CONCEPTO", "WEEK", "ISSUE DATE", "DUE DATE", "CARGO", "ABONO", "SALDO","PROG DE PAGO","FECHA DE PAGO","#CHEQUE"];
var columns = [
    {title: "ID", dataKey: "id"},
    {title: "REQUERIMIENTO", dataKey: "requerimiento"}, 
    
    {title: "INGRESO", dataKey: "ingreso"},
    {title: "FECHA", dataKey: "fecha_ingreso"},
    {title: "CLIENTE", datakey: "cliente"}
   
];

var datos=[];
var cargos=[];
var rows = [];
var i=1;
@foreach ($info['requerimientos'] as $requerimiento)
		rows.push( {"id": i, "requerimiento" : "{{$requerimiento->requerimiento}}", "ingreso": "{{$requerimiento->ingreso}}", "issue": "{{$requerimiento->fecha_ingreso}}", "cliente":
			"{{$requerimiento->cliente}}" });
		i= i+1;
		
@endforeach
rows.push( {"id": "", "requerimiento" : "", "ingreso": "", "cliente": "", "fecha_ingreso":""});

    
var options ;
doc.autoTable(columns, rows,{
    padding: 3, // Horizontal cell padding
    fontSize: 8,
    lineHeight: 15,
    theme: 'grid',
    renderHeader: function (doc, pageNumber, settings) {}, // Called before every page
    renderFooter: function (doc, lastCellPos, pageNumber, settings) {}, // Called at the end of every page
    renderHeaderCell: function (x, y, width, height, key, value, settings) {
        doc.setFillColor(52, 73, 94); // Asphalt
        doc.setTextColor(255, 255, 255);
        doc.setFontStyle('bold');
        doc.rect(x, y, width, height, 'F');
        y += settings.lineHeight / 2 + doc.internal.getLineHeight() / 2 - 2.5;
        doc.text('' + value, x + settings.padding, y);
    },
    renderCell: function (x, y, width, height, key, value, row, settings) {
        doc.setFillColor(row % 2 === 0 ? 245 : 255);
        doc.rect(x, y, width, height, 'F');
        y += settings.lineHeight / 2 + doc.internal.getLineHeight() / 2 - 2.5;
        doc.text('' + value, x + settings.padding, y);
    },
    margin: {  top: 220 }, // How much space around the table
    startY: false, // The start Y position on the first page. If set to false, top margin is used
    overflow: 'ellipsize', // false, ellipsize or linebreak (false passes the raw text to renderCell)
    overflowColumns: false, // Specify which colums that gets subjected to the overflow method chosen. false indicates all
    avoidPageSplit: false, // Avoid splitting table over multiple pages (starts drawing table on fresh page instead). Only relevant if startY option is set.
    extendWidth: true // If true, the table will span 100% of page width minus horizontal margins.
 });
var columns = [
    {title: "PREPARADO", dataKey: "preparado"},
    {title: "GERENTE GRAL.", dataKey: "gerente"}, 
    
    {title: "DIRECTOR", dataKey: "director"},
    {title: "PRESIDENTE", dataKey: "presidente"},
    
   
];
var rows = [
    { "PREPARADO": "     ",
    "GERENTE GRAL.": " ", 
    
    "DIRECTOR": "  ",
     "PRESIDENTE": "  "},
    
   
];
doc.autoTable(columns, rows,{
    padding: 3, // Horizontal cell padding
    fontSize: 10,
    lineHeight: 30,
    theme: 'grid',
    renderHeader: function (doc, pageNumber, settings) {}, // Called before every page
    renderFooter: function (doc, lastCellPos, pageNumber, settings) {}, // Called at the end of every page
    
    renderCell: function (x, y, width, height, key, value, row, settings) {
        doc.setFillColor(row % 2 === 0 ? 245 : 255);
        doc.rect(x, y, 50, height, 'F');
        y += settings.lineHeight / 2 + doc.internal.getLineHeight() / 2 - 2.5;
        doc.text('' + value, x + settings.padding, y);

    },
    margin: {  top: 500, right: 400 }, // How much space around the table
    startY: false, // The start Y position on the first page. If set to false, top margin is used
    overflow: 'ellipsize', // false, ellipsize or linebreak (false passes the raw text to renderCell)
    overflowColumns: false, // Specify which colums that gets subjected to the overflow method chosen. false indicates all
    avoidPageSplit: false, // Avoid splitting table over multiple pages (starts drawing table on fresh page instead). Only relevant if startY option is set.
    extendWidth: true // If true, the table will span 100% of page width minus horizontal margins.
 });

var columns = [
    {title: "", dataKey: "preparado"},
     {title: "", dataKey: "cantidad"},
    
    
   
];
var rows = [
    { "preparado": "SALDO", "cantidad": "$ {{number_format($parametros['total_saldo'],2)}}"},
    //{"preparado": "LIMITE DE CREDITO", "cantidad": "$ 291,890.23"}, 
    
   // {"preparado": "BALANCE EN CREDITO", "cantidad": "$ 291,890.23"},
     
    
   
];

doc.autoTable(columns, rows,{
    padding: 3, // Horizontal cell padding
    fontSize: 8,
    lineHeight: 15,
    theme: 'plain',
    renderHeader: function (doc, pageNumber, settings) {}, // Called before every page
    renderFooter: function (doc, lastCellPos, pageNumber, settings) {}, // Called at the end of every page
    renderHeaderCell: function (x, y, width, height, key, value, settings) {
        doc.setFillColor(52, 73, 94); // Asphalt
        doc.setTextColor(255, 255, 255);
        doc.setFontStyle('bold');
        doc.rect(x, y, 20, 20, 'F');
        y += settings.lineHeight / 2 + doc.internal.getLineHeight() / 2 - 2.5;
        doc.text('' + value, x + settings.padding, y);
    },
    renderCell: function (x, y, width, height, key, value, row, settings) {
        doc.setFillColor(row % 2 === 0 ? 245 : 255);
        doc.rect(x, y, width, height, 'F');
        y += settings.lineHeight / 2 + doc.internal.getLineHeight() / 2 - 2.5;
        doc.text('' + value, x + settings.padding, y);
        
    },
    margin: {  top: 490, right: 100, left:500 }, // How much space around the table
    startY: false, // The start Y position on the first page. If set to false, top margin is used
    overflow: 'ellipsize', // false, ellipsize or linebreak (false passes the raw text to renderCell)
    overflowColumns: false, // Specify which colums that gets subjected to the overflow method chosen. false indicates all
    avoidPageSplit: false, // Avoid splitting table over multiple pages (starts drawing table on fresh page instead). Only relevant if startY option is set.
    extendWidth: true // If true, the table will span 100% of page width minus horizontal margins.
 });



doc.save('reporte');

	    	
	    }
	    @endif
</script>


@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script src="{{ asset("assets/scripts/jquery.btechco.excelexport.js") }}" type="text/javascript"></script>
    <script src="{{ asset("assets/scripts/jquery.base64.js") }}" type="text/javascript"></script>

<script src="{{ asset("assets/scripts/jspdf.js") }}" type="text/javascript"></script>
<script src="{{ asset("assets/scripts/jspdf.min.js") }}" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/2.0.16/jspdf.plugin.autotable.js"></script>
    @stop

@stop



