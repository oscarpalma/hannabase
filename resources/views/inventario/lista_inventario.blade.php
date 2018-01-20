@extends('base')
@section('cabezera','Lista de Inventario')
@section('css')

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
@section('content')
           

<form class="form-inline" role="form" method="POST" action="" id="inventario">
	<div class="panel panel-primary">
		<div class="panel-heading"></div>
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
@if(isset($inventario1))
	<div class="row">
		<div class="panel-body">
		@if ( !count ($inventario1) > 0 ) 

				<div class="alert alert-info alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong>¡Informacion!</strong> No hay Inventario Registrado<br><br> 
					
				</div>
			@else
				<div class="row">
					<div class="col-sm-4">
						<input id="buscar" class="form-control" placeholder="Busqueda">
					</div>
					<div class="col-sm-4">
					<div class="dropdown">
						  <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
						    <span class="glyphicon glyphicon-export"></span> Exportar
						    <span class="caret"></span>
						  </button>
						  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
						   <!-- <li><a href="/crear_reporte_inventario/1" target="_blank" >Visualizar PDF</a></li>
						    <li><a href="/crear_reporte_inventario/2" target="_blank" >Descargar PDF</a></li> -->
						    <li><a href="" id="excel" >Descargar Excel</a></li>
						   </ul>
					</div>
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
					@foreach($inventario1 as $material)
					<tr>
						<td>{{$material->id}}</td>
						<td >{{$material->codigoBarras}}</td>
						<td >{{$material->nombre}}</td>
						<td >{{$material->modelo}}</td>
						<td>{{$material->marca}}</td>
						<td>{{$material->descripcion}}</td>
						<td>{{$material->unidades}}</td>
						<td><center>@if($material->foto != null) <img class="img-rounded" id="fotografia" src="/storage/fotos/inventario/{{$material->foto}}" width="130" height="130"/>
						@else 
							<img class="img-rounded" id="fotografia" src="/static/imagenes/inventario.png" width="130" height="130"/>
						@endif
						</center></td>
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
				<!--<button id="exportButton" class="btn btn-primary"><span class="fa fa-file-pdf-o"></span> Exportar a PDF</button>
				-->
				
				
				<!-- ejuarezc -->
			@endif
		</div>
	</div>
<div>
<div id="tablas_inventario" hidden="">
	<br>
              <table class="table table-striped table-bordered table-hover dataTable no-footer" border="2" width="100%">
                  <thead>
                  	<tr>
                  		<th colspan="4"><h3>Resumen general</h3></th>
                  	</tr>
                    <tr>
                      <th>Nuevos Materiales</th>
                      <th>Bajas</th>
                      <th>Total Actual</th>
                      <th>Total Semana <?= $semana_corte ?></th>
                    </tr>
                  </thead>
                    <tbody>
                                 
                    <tr>
                      <td><?= $altas ?></td>
                      <td><?= $bajas ?></td>
                      <td><?= number_format($total_actual,2) ?></td>
                      <td><?= number_format($total_anterior,2) ?></td>
                    </tr>
                                                           
                  </tbody>

                  </table> 
               <br>
              <table class="table table-striped table-bordered table-hover" border="2" width="100%">
                  <thead>
                  	<tr>
                  		<th colspan="4"><h3>Resumen por área</h3></th>
                  	</tr>
                    <tr>
                      <th>Area</th>
                      <th>Total Actual</th>
                      <th>Total Semana <?= $semana_corte ?></th>
                    </tr>
                  </thead>
                    <tbody>
                  <?php foreach( $inventario as $totales){ ?>
                 
                    <tr>
                      <td><?= $totales['area']; ?></td>
                      <td><?= number_format($totales['totalArea'],2) ?></td>
                      <td><?= number_format($totales['totalAnterior'],2) ?></td>
                    </tr>
                    
                    <?php  } ?>
                    
                  </tbody>

                  </table>
                  <br>
                  <?php foreach($inventario as $inventario){ ?>
                
              <table class="table table-striped table-bordered table-hover" border="2" width="100%">
                  <thead>
                  	<tr>
                  		<th colspan="7"><h2><?= $inventario['area'] ?></h2></th>
                  	</tr>
                     <tr>
                      <th >Codigo</th>
                      <th>Nombre</th>
                      <th>Marca</th>
                      <th>Modelo</th>
                      <th >Unidades</th>
                      <th >Precio Unitario</th>
                      <th>Total</th>
                    </tr>
                  </thead>
                    <tbody>
                  <?php foreach( $inventario['inventario'] as $material){ ?>
                 
                    <tr>
                      <td><?= $material->codigoBarras; ?></td>
                      <td><?= $material->nombre; ?></td>
                      <td><?= $material->marca; ?></td>
                      <td><?= $material->modelo; ?></td>
                      <td><span class="badge bg-green"><?= $material->unidades; ?></span></td>
                      <td><?= number_format($material->precioUnitario,2) ?></td>
                      <td><?= number_format($material->precioTotal,2) ?></td>
                    </tr>
                    
                    <?php  } ?>
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td><strong>Total</strong></td>
                      <td><?= number_format($inventario['totalArea'],2) ?></td>
                    </tr>
                  </tbody>

                  </table>
                  <br>
                  <?php  } ?>
</div></div>

@endif
@stop
@section('js')
<script src="{{ asset("static/js/jquery.btechco.excelexport.js") }}" type="text/javascript"></script>
<script src="{{ asset("static/js/jquery.base64.js") }}" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="http://www.shieldui.com/shared/components/latest/css/light/all.min.css" />
				<script type="text/javascript" src="http://www.shieldui.com/shared/components/latest/js/shieldui-all.min.js"></script>
				<script type="text/javascript" src="http://www.shieldui.com/shared/components/latest/js/jszip.min.js"></script>
				<script type="text/javascript">

				
		        $("#excel").click(function (e) {
		        	e.preventDefault();
		        	
		        	var worksheet= "Inventario";
		            $("#tblExport").btechco_excelexport({
		                containerid: "tablas_inventario"
		               , datatype: $datatype.Table
		               , filename: 'Inventario'
		               , nombre: worksheet
		               
		            });
		        });

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
				@endsection