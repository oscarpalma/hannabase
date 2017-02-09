@extends('layouts.dashboard')
@section('page_heading','Lista de Inventario')
@section('head')

<script src="{{ asset('assets/scripts/barcode/JsBarcode.all.js') }}"></script>
<script type="text/javascript">
 function codigo(id, codigo){
 	JsBarcode("#barcode"+id,codigo );
 }
	
</script>

<!-- Anadido  -->
<link rel="stylesheet" type="text/css" href="/Content/font-awesome/css/font-awesome.min.css" />
<!-- ejuarezc -->
@stop
@section('section')
           
<div class="container-fluid">
<form class="form-inline" role="form" method="POST" action="" id="inventario">
	<div class="panel panel-primary">
		<div class="panel-heading"><strong>Buscar</strong></div>
		<div class="panel-body">
			
			<input type="hidden" name="_token" value="{{ csrf_token() }}">	
			
				
				<div class="form-group">
			    <label class="control-label">Area:</label>
					
						<select class="form-control" id="area" name="area">
							<!--en caso de no especificar ninguno-->
							<option value="todas">Todas</option>
							 @foreach($areas as $area)
							 <option value="{{$area->idArea}}">{{$area->nombre}}</option>
							 @endforeach 
						</select>
			  </div>
				
				<button type="submit" class="btn btn-primary" value="validate" >Buscar
					</button>
		

			

		</div>
	</div>
</form>
@if(isset($inventario))
	<div class="row">
		<div class="panel-body">
		@if ( !count ($inventario) > 0 ) 

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
			<table id="exportTable" class="table table-striped table-bordered table-hover dataTable no-footer" border="2" width="100%" rules="rows" style='text-transform:uppercase' id='exportTable'> <!-- Se agrega ID exportTable -->
			    <thead>
					<tr>
						<th>ID</th>
						<th>Codigo</th>
						<th>Nombre</th>
						<th>Modelo</th>
						<th>Marca</th>
						<th>Descripcion</th>
						<th><center>Unidades</center></th>
						<th><center>Fotografia</center></th>
						<th><center>Acciones</center></th>
					</tr>
				</thead>
				
				<tbody>
					@foreach($inventario as $material)
					<tr>
						<td>{{$material->id}}</td>
						<td >{{$material->codigoBarras}}</td>
						<td >{{$material->nombre}}</td>
						<td >{{$material->modelo}}</td>
						<td>{{$material->marca}}</td>
						<td>{{$material->descripcion}}</td>
						<td>{{$material->unidades}}</td>
						<td><center><img class="img-rounded" id="fotografia" src="/{{$material->foto}}" width="130" height="130"/></center></td>
						<td><center>
						
						<a href="{{route('eliminar_inventario',$material->id)}}" class="btn btn-danger" title="eliminar"><i class="fa fa-trash"></i></a>
						</center></td>
					</tr>
				<tbody>
			    @endforeach
			</table>
			</div>
			<!-- Anadido  -->
				<br>
				<button id="exportButton" class="btn btn-primary"><span class="fa fa-file-pdf-o"></span> Exportar a PDF</button>

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
				                        Codigo: { type: Number },
				                        Nombre: { type: String },
				                        Modelo: { type: String },
				                        Marca: { type: String },
				                        Descripcion: { type: String },
				                        Unidades: { type: Number }
				                    }
				                }
				            });

				            // when parsing is done, export the data to PDF
				            dataSource.read().then(function (data) {
				                var pdf = new shield.exp.PDFDocument({
				                    author: "Hannabase",
				                    created: new Date()
				                });

				                pdf.addPage("a4", "portrait");

				                pdf.table(
				                    25,
				                    25,
				                    data,
				                    [
				                        { field: "Codigo", title: "Codigo", width: 67 },
				                        { field: "Nombre", title: "Nombre", width: 110 },
				                        { field: "Modelo", title: "Modelo", width: 75 },
				                        { field: "Marca", title: "Marca", width: 75 },
				                        { field: "Descripcion", title: "Descripcion", width: 200 },
				                        { field: "Unidades", title: "#", width: 18 }
				                    ],
				                    {
				                        margins: {
				                            top: 50,
				                            left: 50
				                        }
				                    }
				                );



				                pdf.saveAs({
				                    fileName: "Inventario Exportado"
				                });
				            });
				        });
				    });
				</script>
				<!-- ejuarezc -->
			@endif
		</div>
	</div>
</div>


@endif
@stop