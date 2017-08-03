@extends('layouts.dashboard')
@section('page_heading','Autorizacion')
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
<!--  Este formulario genera la autorizacion una vez que se revisa la cotizacion,los datos que se ingresan en los campos del formulario se guardan en la base de datos y se muestran en la vista lista_autorizaciones  !-->
<form class="form-horizontal" role="form" method="POST" action="{{ route('autorizacion') }}" >
<input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="panel panel-primary">
		<div class="panel-heading"><strong>Generar Autorizacion</strong></div>
		<div class="panel-body">
			<div class="row-sm">					
				<p>Campos marcados con <text style="color:red">*</text> son obligatorios.</p>
			</div>
			<div class="row">
			<div class="panel-body">
				
               <div class="col-sm-4">
                    <label class="control-label">Solicita<text style="color:red">*</text></label>
                        <div>
                            <select class="form-control" name="solicitante" id="solicitante">
                                <option value="">SELECCIONAR</option>
                                @foreach($info['solicitan'] as $solicitan)
                                    <option value="{{$solicitan->idEmpleadoCt}}">{{$solicitan->nombres}}</option>
                                @endforeach
                            </select>
                        </div>
                </div>             

				<div class="col-sm-4">
					<label class="control-label">Fecha <text style="color:red">*</text></label>
					<div >
						<input type="date"  class="form-control" name="fecha" value="<?php echo date('Y-m-d'); ?>" id="" max="<?php echo date('Y-m-d'); ?>">
					</div>
				</div>

				<div class="col-sm-4">
				<label class="control-label">Area<text style="color:red">*</text></label>
					<div>
						<select class="form-control" name="area" id="area" required="">
							<option value="">SELECCIONAR</option>
							@foreach($info['areas'] as $area)
								<option value="{{$area->idAreaCt}}">{{$area->nombre}}</option>
							@endforeach
						</select>	
					</div>
				</div>

                <div class="col-sm-4">
                <label class="control-label">Responsable<text style="color:red">*</text></label>
                    <div>
                        <select class="form-control" name="responsable" id="responsable">
                            <option>SELECCIONAR</option>
                            @foreach($info['solicitan'] as $solicitan)
                                <option value="{{$solicitan->idEmpleadoCt}}">{{$solicitan->nombres}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

				<div class="col-sm-4">
					<label class="control-label">Concepto</text></label>
					<div >
						<input type="text"  class="form-control" name="concepto"  id="concepto" >
					</div>
				</div>

				<div class="col-sm-4">
				<label class="control-label">Tipo de Pago<text style="color:red">*</text></label>
					<div>
						<select class="form-control" name="tipo_pago" id="tipo_pago" >
							<option value="">SELECCIONAR</option>
							<option value="Transferencia">Transferencia</option>
							<option value="Tarjeta">Cheque</option>
							<option value="Efectivo">Efectivo</option>
						</select>	
					</div>
				</div>
			</div>

	<form id="testform">
		<div class="panel-primary">
			<div class="panel-heading"><strong>Proveedores</strong></div>
				<div class="panel-body">
					<div class="row">

						<div class="col-sm-4">
						<label class="control-label">Proveedor<text style="color:red">*</text></label>
							<div>
								<select class="form-control" name="proveedor" id="proveedor" required="">
									<option value="">SELECCIONAR</option>
										@foreach($info['proveedores'] as $proveedor)
										<option value="{{$proveedor->id}}">{{$proveedor->nombre}}</option>
										@endforeach
								</select>	
							</div>
						</div>

						<div class="col-sm-4">
							<label class="control-label">Descripcion<text style="color:red">*</text></label>
							<div>
								<input type="text"  class="form-control" name="descripcion"  id="descripcion" >
							</div>
						</div>

						<div class="col-sm-4">
							<label class="control-label">Precio Unitario</text></label>
							<div>
								<input type="text"  class="form-control" name="precio_unitario"  id="precio_unitario"  value="" required="">
							</div>
						</div>

						<div class="col-sm-4">
							<label class="control-label">Cantidad</label>
							<div>
								<input type="text"  class="form-control" name="cantidad"  id="cantidad"  value="" required="">
							</div>
						</div>

						<div class="col-sm-4">
							<label class="control-label">Total<text style="color:red">*</text></label>
							<div>
								<input type="text"  class="form-control" name="total"  id="total" >
							</div>
						</div>

					</div>
				</div>
		</div>
	</form>	
<br>
		</div>

		<br>
				<br>
				    <center>
						<div class="row">
							<button type="submit" class="btn btn-primary">
								Guardar
							</button>
						</div>
					</center>
	</div>
</div>
</form>

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
@foreach ($parametros['transacciones'] as $transaccion)
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