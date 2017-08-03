@extends('layouts.dashboard')
@section('page_heading','Proveedor(es)')
@section('section')

<form class="form-horizontal" role="form" method="GET" action="{{ route('aprobarcotizacion', $cotizacion->idCotizacion ) }}">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="panel panel-primary">
		<div class="panel-heading"><strong> Proveedor(es) </strong></div>
			<div class="panel-body">
				<div class="row">
					<div class="panel-body">
						
						<div class="col-sm-4">
							<label class="control-label"> Proveedor </label>
								<div>
									<input type="text" class="form-control" value="{{$cotizacion->proveedor}}" readonly="">
								</div>
						</div>
						<div class="col-sm-4">
							<label class="control-label"> Descripcion </label>
								<div>
									<input type="text" class="form-control" value="{{$cotizacion->descripcion}}" readonly="">
								</div>
						</div>
						<div class="col-sm-4">
							<label class="control-label"> Precio Unitario </label>
								<div>
									<input type="text" class="form-control" value="{{$cotizacion->precio_unitario}}" readonly="">
								</div>
						</div>
						<div class="col-sm-4">
							<label class="control-label"> Cantidad </label>
								<div>
									<input type="text" class="form-control" value="{{$cotizacion->cantidad}}" readonly="">
								</div>
						</div>
						<div class="col-sm-4">
							<label class="control-label"> Total </label>
								<div>
									<input type="text" class="form-control" value="{{$cotizacion->total}}" readonly="">
								</div>
						</div>
						<div class="col-sm-4">
							<label class="control-label"> Tipo de Pago </label>
								<div>
									<input type="text" class="form-control" value="{{$cotizacion->tipo_pago}}" readonly="">	
								</div>
						</div>			
								
					</div>
				</div>
			</div>
	</div>				
</form>

<h1> Autorizar Cotizacion </h1>
<br>

<form class="form-horizontal" role="form" method="POST" action="{{ route ('autorizacionguardar')}}">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="panel panel-primary">
		<div class="panel-heading"><strong> Datos Generales </strong></div>
			<div class="panel-body">
				<div class="row">
					<div class="panel-body">
						<div class="col-sm-4">
							<label class="control-label"> Solicita </label>
								<div>
									<input type="text" class="form-control" value="{{$cotizacion->solicitante}}" readonly="" name="solicitante" id="solicitante">
								</div>
						</div>
						<div class="col-sm-4">
							<label class="control-label"> Fecha </label>
								<div>
									<input type="text" class="form-control" value="{{$cotizacion->fecha}}" readonly="" name="fecha" id="fecha">
								</div>
						</div>
						<div class="col-sm-4">
							<label class="control-label"> Area </label>
								<div>
									<input type="text" class="form-control" value="{{$cotizacion->idarea}}" readonly="" name="area" id="area">
								</div>
						</div>
						<div class="col-sm-4">
							<label class="control-label"> Responsable </label>
								<div>
									<input type="text" class="form-control" value="{{$cotizacion->responsable}}" readonly="" name="responsable" id="responsable">
								</div>
						</div>
						<div class="col-sm-4">
							<label class="control-label"> Concepto </label>
								<div>
									<input type="text" class="form-control" value="{{$cotizacion->concepto}}" readonly="" name="concepto" id="concepto">
								</div>
						</div>
						<div class="col-sm-4">
							<label class="control-label"> Tipo de Pago </label>
								<div>
									<select class="form-control" name="tipo_pago" id="tipo_pago" >
										<option value="">SELECCIONAR</option>
										<option value="Transferencia">Transferencia</option>
										<option value="Cheque">Cheque</option>
										<option value="Efectivo">Efectivo</option>
									</select>	
								</div>
						</div>
					</div>

					<form class="form-horizontal" role="form">
						<div class="panel-primary">
							<div class="panel-heading"><strong> Proveedor </strong></div>
								<div class="panel-body">
									<div class="col-sm-3">
										<label class="control-label"> Proveedor </label>
											<div>
												<input type="text" class="form-control" name="proveedor" id="proveedor" value="" >
											</div>
									</div>
									<div class="col-sm-3">
										<label class="control-label"> Descripcion </label>
											<div>
												<input type="text" class="form-control" name="descripcion" id="descripcion" value="" >
											</div>
									</div>
									<div class="col-sm-2">
										<label class="control-label"> Precio Unitario </label>
											<div>
												<input type="text" class="form-control" name="precio_unitario" id="precio_unitario" value="" >
											</div>
									</div>
									<div class="col-sm-2">
										<label class="control-label"> Cantidad </label>
											<div>
												<input type="text" class="form-control" name="cantidad" id="cantidad" value="" >
											</div>
									</div>
									<div class="col-sm-2">
										<label class="control-label"> Total </label>
											<div>
												<input type="text" class="form-control" name="total" id="total" value="" >
											</div>
									</div>
								</div>
								<br>
								<center>
									<div class="row">
										<button type="submit" class="btn btn-primary">
										Autorizar
										</button>
									</div>
								</center>
						</div>
					</form>
				</div>
			</div>
	</div>
</form>


@stop


