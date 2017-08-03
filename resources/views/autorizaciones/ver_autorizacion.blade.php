@extends('layouts.dashboard')
@section('page_heading','Autorizacion')
@section('section')

<form class="form-horizontal" role="form" method="GET" action="{{ route ('verautorizacion' , $autorizacion->idAutorizacion) }}" >
<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="panel panel-primary">
		<div class="panel-heading"><strong> Datos Generales </strong></div>
			<div class="panel-body">
				<div class="row">
					<div class="panel-body">
						<div class="col-sm-4">
							<label class="control-label"> Solicita </label>
								<div>
									<input type="text" class="form-control" value="{{$autorizacion->solicitante}}" readonly="">
								</div>
						</div>
						<div class="col-sm-4">
							<label class="control-label"> Fecha </label>
								<div>
									<input type="text" class="form-control" value="{{$autorizacion->fecha}}" readonly="">
								</div>
						</div>
						<div class="col-sm-4">
							<label class="control-label"> Area </label>
								<div>
									<input type="text" class="form-control" value="{{$autorizacion->idarea}}" readonly="">
								</div>
						</div>
						<div class="col-sm-4">
							<label class="control-label"> Responsable </label>
								<div>
									<input type="text" class="form-control" value="{{$autorizacion->responsable}}" readonly="">
								</div>
						</div>
						<div class="col-sm-4">
							<label class="control-label"> Concepto </label>
								<div>
									<input type="text" class="form-control" value="{{$autorizacion->concepto}}" readonly="">
								</div>
						</div>
						<div class="col-sm-4">
							<label class="control-label"> Tipo de Pago</label>
								<input type="text" class="form-control" value="{{$autorizacion->tipo_pago}}" readonly="">
						</div>
					</div>
				</div>
			</div>

			<form>
			<div class="panel-primary">
				<div class="panel-heading"><strong> Proveedores </strong></div>
					<div class="panel-body">
						<div class="col-sm-4">
							<label class="control-label"> Proveedor </label>
								<div>
									<input type="text" class="form-control" value="{{$autorizacion->idproveedor}}" readonly="">
								</div>
						</div>
						<div class="col-sm-4">
							<label class="control-label"> Descripcion </label>
								<div>
									<input type="text" class="form-control" value="{{$autorizacion->descripcion}}" readonly="">
								</div>
						</div>
						<div class="col-sm-4">
							<label class="control-label"> Precio Unitario </label>
								<div>
									<input type="text" class="form-control" value="{{$autorizacion->precio_unitario}}" readonly="">
								</div>
						</div>
						<div class="col-sm-4">
							<label class="control-label"> Cantidad </label>
								<div>
									<input type="text" class="form-control" value="{{$autorizacion->cantidad}}" readonly="">
								</div>
						</div>
						<div class="col-sm-4">
							<label class="control-label"> Total </label>
								<div>
									<input type="text" class="form-control" value="{{$autorizacion->total}}" readonly="">
								</div>
						</div>
					</div>
			</div>
		</form>
	</div>
</form>


			


		



@stop