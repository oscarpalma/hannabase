<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Reporte Inventario</title>
<link rel="stylesheet" type="text/css" href="static/cssPdf/pdf.css">
<link href="/static/bower_components/bootstrap/dist/css/bootstrap.css" rel="stylesheet">

</head>
<body>

<div class="col-md-12">
<img src="static/imagenes/crtmlogo.png" width="90px">
<p class="fecha"><strong><?=  $date; ?></strong></p>
<center><h1>Reporte de inventario</h1></center>

              <div class="box">
				
                
                <div class="box-body">
              <!--  <div class="contenedor-tabla">
                  <div class="contenedor-fila">
                      <div class="contenedor-columna">
                           <strong>Nuevos Materiales: </strong><?= $altas ?>
                       </div>

                      

                      <div class="contenedor-columna">
                            <strong>Total Actual: </strong><?= number_format($total_actual,2) ?>
                      </div>
                      <div class="contenedor-columna">
                            <strong>Total Semana <?= $semana_corte ?>: </strong><?= number_format($total_anterior,2) ?>
                      </div>
                  </div>
                  <div class="contenedor-fila">
                      <div class="contenedor-columna">
                           <strong>Bajas: </strong><?= $bajas ?>
                      </div>
                      
                      
                  </div>
                </div> -->
               <center><h3>Resumen general</h3></center> 
              <table class="table table-striped table-bordered table-hover">
                  <thead>
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
                  <center><h3>Resumen por área</h3></center>  
              <table class="table table-striped table-bordered table-hover">
                  <thead>
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
                 
                </div><!-- /.box-body -->
                
                <div class="box-footer clearfix">
                  
                </div>
              </div><!-- /.box -->
              <br><br><br>
               <?php foreach($inventario as $inventario){ ?>
                <center><h2><?= $inventario['area'] ?></h2></center>
              <table class="table table-striped table-bordered table-hover">
                  <thead>
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
                  <?php  } ?>
              
            </div>


	
</body>
</html>


