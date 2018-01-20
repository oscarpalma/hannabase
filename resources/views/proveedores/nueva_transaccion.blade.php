@extends('base')
@section('cabezera','Agregar Transaccion')
@section('css')
<link href="/static/select2/select2.css" rel="stylesheet">
@endsection
@section('content')

@if(Session::has('mensaje'))
<div class="alert alert-success alert-dismissible" role="alert" id="success">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></strong> {{Session::get('mensaje')}}
				
	</div>
    
@endif


<form class="form-horizontal" role="form" method="POST" action="{{route('proveedores_transaccion')}}" >
<input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="panel panel-primary">
		<div class="panel-heading"><strong>Datos</strong></div>
		<div class="panel-body">
			<div class="row-sm">					
				<p>Campos marcados con <text style="color:red">*</text> son obligatorios.</p>
				<center><label>Semana Actual {{date("W")}}</label></center>
			</div>
			<div class="row">
				<div class="col-sm-4">
					<label class="control-label">Factura <text style="color:red">*</text></label>
					<input class="form-control" name="factura">
				</div>

				<div class="col-sm-4">
					<label class="control-label">Proveedor <text style="color:red">*</text></label>
					<select class="form-control" name="proveedor">
						@foreach($proveedores as $proveedor)
							<option value="{{$proveedor->id}}">{{$proveedor->nombre}}</option>
						@endforeach
					</select>
				</div>

				<div class="col-sm-4">
					<label class="control-label">Concepto <text style="color:red">*</text></label>
					<input class="form-control" name="concepto" required="">
				</div>
			</div>

			<div class="row">
				<div class="col-sm-4">
				<label class="control-label">Categoria<text style="color:red">*</text></label>
					<div>
						<select class="form-control" name="categoria" id="categoria"  required="">
							<option value="">Seleccionar</option>
							<option value="Recursos Humanos">Recursos Humanos</option>
							<option value="Logistica">Logistica</option>
							<option value="Servicios Generales">Servicios Generales</option>
							<option value="Sistemas">Sistemas</option>
							<option value="Reclutamiento">Reclutamiento</option>
							<option value="Contabilidad">Contabilidad</option>
							<option value="Ingresos">Ingresos</option>
							<option value="Reembolsos a los Clientes">Reembolsos a los Clientes</option>
						</select>	
					</div>
				</div>
				<div class="col-sm-4">
					<label class="control-label">SubCategoria<text style="color:red">*</text></label>
					<input class="form-control" name="subcategoria" id="subcategoria"  value="" required="">
				</div>
				<div class="col-sm-4">
					<label class="control-label">Codigo<text style="color:red">*</text></label>
					<input class="form-control" name="codigo" id="codigo" value="" required="">
				</div>
			</div>

			<div class="row">
				<div class="col-sm-4">
					<label class="control-label">Semana <text style="color:red">*</text></label>
					<select class="form-control" name="semana">
						@for($i = 1; $i < 53; $i++)
							<option value="{{$i}}" @if ($i == date("W")) selected="" @endif>Semana {{$i}}</option>
						@endfor
					</select>
				</div>

				<div class="col-sm-4">
					<label class="control-label">Fecha captura <text style="color:red">*</text></label>
					<input class="form-control" name="fecha_captura" required="" type="date">
				</div>				

				<div class="col-sm-4">
					<label class="control-label">Fecha agendada <text style="color:red">*</text></label>
					<input class="form-control" name="fecha_agendada" required="" type="date">
				</div>
			</div>

			<div class="row">
				<div class="col-sm-4">
					<label class='control-label'>Cargo <text style="color:red">*</text></label>
					<input class="form-control" name="cargo" required="">
				</div>

				<div class="col-sm-4">
					<label class='control-label'>Abono</label>
					<input class="form-control" name="abono">
				</div>

				<div class="col-sm-4">
					<label class="control-label">Saldo</label>
					<input class="form-control" name="saldo">
				</div>
			</div>

			<div class="row">
				<div class="col-sm-4">
					<label class="control-label">Fecha programada</label>
					<input class="form-control" name="fecha_programada" type="date">
				</div>

				<div class="col-sm-4">
					<label class="control-label">Fecha de traspaso</label>
					<input class="form-control" name="fecha_traspaso" type="date">
				</div>

				<div class="col-sm-4">
					<label class="control-label">Cheque</label>
					<input class="form-control" name="cheque">
				</div>
			</div>

			<br>
			<center>
				<button class="btn btn-primary" type="submit">Guardar</button>
			</center>		
		</div>
	</div>
</form>
@endsection

@section('js')
<script src="{{ asset("static/select2/select2.js") }}" type="text/javascript"></script>
<script type="text/javascript">
	 $(document).ready(function () {
    	
    	$("#proveedor").select2();
    	$("#success").delay(2000).hide(600);
    });
</script>
@endsection
