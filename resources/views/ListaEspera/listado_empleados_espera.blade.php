@extends('layouts.dahsboard')
@section('page_heading','Lista de Empleados Proyecto')
@section('section')

@if(Session::has('error'))
<script> type="text/javascript"
	window.onload = function(){ alert("{{Session::get('error')}}");}
</script>
@endif

<div class="container-fluid">
	<div class="row">
		<div class="panel-body">
			@if (empty ($informacion) )
				<div class="alert alert-info alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong>!Informacion</strong>No hay Candidatos en espera!<br><br>
				</div>
			@else
				<div class="row">
					<div class="col-sm-6">
						<input id="buscar" class="form-control" placeholder="Busqueda">
					</div>
				</div>
				<br>
				<div class="tabla">
				<table class="table table-striped table-bordered table-hover dataTable no-footer" border="2"
				width="100%" rules="rows" style='text-transform: uppercase' id="tabla">
					<thead>
						<th>ID</th>
						<th>Nombre</th>
						<th>CURP</th>
						<th>IMSS</th>
						<th>Telecono</th>
						<th>Status</th>
					</thead>

					<tbody>

					</tbody>

				</table>
			</div>
		@endif
		</div>
	</div>
</div>

<script type="text/javascript">
	var $rows = $('#tabla tbody tr');
	$('#buscar').keyup(function() {
	    var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
	    
	    $rows.show().filter(function() {
	        var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
	        return !~text.indexOf(val);
	    }).hide();
	});
</script>
@stop