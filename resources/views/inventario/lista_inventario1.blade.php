@extends('layouts.dashboard')
@section('page_heading','Lista de Inventario')
@section('head')

<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script> <!-- Agregado -->
<script src="{{ asset('assets/scripts/barcode/JsBarcode.all.js') }}"></script>
<script type="text/javascript">
 function codigo(id, codigo){
 	JsBarcode("#barcode"+id,codigo );
 }
	
</script>
@stop
@section('section')
           
<div class="container-fluid">
	<div class="row">
		<div class="panel-body">
		@if ( empty ( $inventario ) ) 
			<div class="alert alert-info alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong>¡Informacion!</strong> No hay Inventario Registrado<br><br> 
				
			</div>
		@else
		<div class="row">
					<div class="col-sm-6">
						<input id="buscar" class="form-control" placeholder="Busqueda">
					</div>
				</div>
				<br>
		<div class="tabla">
			<table class="table table-striped table-bordered table-hover dataTable no-footer" border="2" width="100%" rules="rows" style='text-transform:uppercase' id="exportTable">
				<thead>
				    <tr>
				        <th>ID</th>
				        <th>Codigo</th>
				        <th>Nombre</th>
				        <th>Modelo</th>
				        <th>Marca</th>
				        <th>Descripcion</th>
				        <th><center>Unidades</center></th>
				        <th><center>Acciones</center></th>
				    </tr>
		    	</thead>
		    	<tbody>
			    @foreach($inventario as $material) 
			        <tr>
			            <td>{{$material->id}}</td>
			            <td ><img id="barcode{{$material->id}}"/><script type="text/javascript"> codigo({{$material->id}},{{$material->codigoBarras}});</script></td>
			            <td >{{$material->nombre}}</td>
			            <td >{{$material->modelo}}</td>
			            <td>{{$material->marca}}</td>
			            <td>{{$material->descripcion}}</td>
			            <td>{{$material->unidades}}</td>
			            <td><center>
			        
			            	<a href="{{route('eliminar_inventario',$material->id)}}" class="btn btn-danger" title="eliminar"><i class="fa fa-trash"></i></a>
			            </center></td>
		            </tr>
			    @endforeach
			    </tbody>
			</table>
		</div>

		<br /><br />
		<button onclick="imprimir();" class="btn btn-primary">Exportar a PDF</button>

		<!-- SECCION DE  -->

		<script type="text/javascript">
		function imprimir(){
			
			//var columns = ["#", "FACTURA", "PROVEEDOR","CONCEPTO", "WEEK", "ISSUE DATE", "DUE DATE", "CARGO", "ABONO", "SALDO","PROG DE PAGO","FECHA DE PAGO","#CHEQUE"];
			var columns = [
			    {title: "ID", dataKey: "id"},
			    {title: "FACTURA", dataKey: "factura"}, 
			    
			    {title: "CONCEPTO", dataKey: "concepto"},
			    {title: "WEEK", dataKey: "week"},
			    {title: "ISSUE DATE", dataKey: "issue"},
			    {title: "DUE DATE", dataKey: "due"},
			    {title: "CARGO", dataKey: "cargo"},
			    {title: "ABONO", dataKey: "abono"},
			    {title: "SALDO", dataKey: "saldo"},
			    {title: "PROG DE PAGO", dataKey: "progdepago"},
			    {title: "FECHA DE PAGO", dataKey: "fechapago"},
			    {title: "CHEQUE", dataKey: "cheque"}
			   
			];

			var datos=[];
			var cargos=[];
			var rows = [];
			var i=1;
			@foreach ($material1['material'] as $material)
					rows.push( {"id": i, "factura" : "{{$transaccion->factura}}", "concepto": "{{$transaccion->concepto}}", "week": "{{$transaccion->semana}}", "issue":"{{$transaccion->fecha_captura}}", "due":"{{$transaccion->fecha_agendada}}", "cargo":"$ {{number_format($transaccion->cargo,2)}}","abono":"$ {{number_format($transaccion->abono,2)}}","saldo":"$ {{number_format($transaccion->saldo,2)}}","progdepago":"{{$transaccion->fecha_programada}}","fechapago":"{{$transaccion->fecha_traspaso}}","cheque":"{{$transaccion->cheque}}"});
					i= i+1;
					
			@endforeach
			rows.push( {"id": "", "factura" : "", "concepto": "", "week": "", "issue":"", "due":"TOTAL", "cargo":"$ {{number_format($parametros['total_cargo'],2)}}","abono":"$ {{number_format($parametros['total_abono'],2)}}","saldo":"$ {{number_format($parametros['total_saldo'],2)}}","progdepago":"","fechapago":"","cheque":""});

		    
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
$( document ).ready(function() {

var $rows = $('#tabla tbody tr');
	$('#buscar').keyup(function() {
	    var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
	    
	    $rows.show().filter(function() {
	        var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
	        return !~text.indexOf(val);
	    }).hide();
	});

});
		</script>


		@endif
		</div>
	</div>
</div>

@stop