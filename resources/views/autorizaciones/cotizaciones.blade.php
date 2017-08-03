@extends('layouts.dashboard')
@section('page_heading','Cotizaciones')
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
<!-- En esta vista se encuentra un formulario con tres seccion,la primera seccion cuenta con la captura de los datos generales para realizar la cotizacion,el llenado del formulario no lleva ningun orden por lo que es de libre albeldrio empezar desde donde el usuario quiera pero se tienen que llenar los campos marcados con rojo para poder mandar el formulario al correo-->
<form class="form-horizontal" role="form" method="POST" action="{{ route('cotizacion') }}" >
<input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="panel panel-primary">
		<div class="panel-heading"><strong>Generar Cotizacion</strong></div>
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
								@foreach($info['solicitante'] as $solicitante)
									<option value="{{$solicitante->idEmpleadoCt}}">{{$solicitante->nombres}}</option>
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
							<select class="form-control" name="area" id="area">
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
								<option value="">SELECCIONAR</option>
								@foreach($info['solicitante'] as $solicitante)
									<option value="{{$solicitante->idEmpleadoCt}}">{{$solicitante->nombres}}</option>
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
							<option value="Cheque">Cheque</option>
							<option value="Efectivo">Efectivo</option>
						</select>	
					</div>
				</div>

			</div>

<!-- Enseguida una  vez que se llena la primera seccion saltamos a la seccion de proveedores donde capturaremos la informacion del proveedor,descripcion de la cotizacion y el precio total-->
	<form id="testform">
		<div class="panel-primary">
			<div class="panel-heading"><strong>Proveedores</strong></div>
				<div class="panel-body">
					<div id="input1">
						<div class="col-sm-3" >
							<label class="control-label">Proveedor<text style="color:red">*</text></label>
							<div>
								<input type="text"  class="form-control" name="proveedor"  id="proveedor" required="">
							</div>
						</div>

						<div class="col-sm-3">
							<label class="control-label">Descripcion<text style="color:red">*</text></label>
							<div>
								<input type="text"  class="form-control" name="descripcion"  id="descripcion"  required="">
							</div>
						</div>

						<div class="col-sm-2">
							<label class="control-label">Precio Unitario<text style="color:red">*</text></label>
							<div>
								<input type="text"  class="form-control" name="precio_unitario" id="precio_unitario">
							</div>
						</div>

						<div class="col-sm-2">
							<label class="control-label">Cantidad</label>
							<div>
								<input type="text"  class="form-control" name="cantidad"  id="cantidad" >
							</div>
						</div>

						<div class="col-sm-2">
							<label class="control-label">Total<text style="color:red">*</text></label>
							<div>
								<input type="text"  class="form-control" name="total"  id="total"  required="">
							</div>
						</div>

					</div>
				</div>
			<!-- Si se necesita otro prooveedor,lo unico que el usuario debe hacer es presionar el boton Agregar,el cual le brindara otra columna para capturar otro proveedor a si mismo si quiere eleminar un proveedor que no considere necesario solo presiona el boton Eliminar -->
				<center>
				<div class="clonedInput" >
					<button type="button" class="btn btn-primary" id="btnAdd">
						Agregar
					</button>

					<button type="button" class="btn btn-primary" id="btnDel">
						Eliminar
					</button>
				</div>
				</center>
		</div>
	</form>	
<br>

<!-- Cuando se llenan las dos secciones anteriores,no le resta nada mas a l usuario que dirigirse a la ultima seccion la cual captura el asunto que se tratara y el correo al que se enviar dicho formulario con la informacion al presionar el boton Enviar, si algun campo marcado de rojo no se captura no sera posible enviar la informacion hasta que dicho campo contenta informacion dentro -->
		<div class="panel-primary">
			<div class="panel-heading"><strong>Enviar a</strong></div>
				<div class="panel-body">
					<div class="row">

						<div class="col-sm-3">
							<label class="control-label">De</label>
							<input type="text" class="form-control" name="email" id="email" value="{{ Auth::user()->email }}" readonly="">
						</div>

						<div class="col-sm-10">
						<label class="control-label">Asunto<text style="color:red">*</text></label>
				 			<div >
								<input type="text"  class="form-control" name="asunto"  id=""  value="" required="">
							</div>
						</div>
			
						<div class="col-sm-10">
							<label class="control-label">E-Mail</label>
							<input type="email" class="form-control" name="" id="">
						</div>

					</div>
				</div>
		</div>


		</div>

		<br>
				<br>
				    <center>
						<div class="row">
							<button type="submit" class="btn btn-primary">
								Enviar
							</button>
						</div>
					</center>
		</div>
</div>
</form>


<!-- El siguien script realiza la funcion para Agregar o Eliminar los campos que se generan cuando necesitamos de otro proveedor o deseamos eliminarlo -->
<script type="text/javascript">
        $(document).ready(function() {
            $('#btnAdd').click(function() {
                var num     = $('.clonedInput').length;
                var newNum  = new Number(num + 1);

                var newElem = $('#input' + num).clone().attr('id', 'input' + newNum);

                newElem.children(':first').attr('id', 'name' + newNum).attr('name', 'name' + newNum);
                $('#input' + num).after(newElem);
                $('#btnDel').attr('enabled','enabled');

            if (newNum == 5)
                $('#btnAdd').attr('enabled','enabled');
        });

        $('#btnDel').click(function() {
            var num = $('.clonedInput').length;

            $('#input' + num).remove();
            $('#btnAdd').attr('enabled','enabled');

            if (newNum == 1)
                $('#btnDel').attr('enabled','enabled');
        });

        $('#btnDel').attr('enabled','enabled');
    });
</script>
@stop

