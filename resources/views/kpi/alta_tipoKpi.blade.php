@extends('layouts.dashboard')
@section('page_heading','Tipo de KPI')
@section('head')
<link rel="stylesheet" href="{{ asset("assets/stylesheets/select2.css") }}" />
<link rel="stylesheet" href="http://kendo.cdn.telerik.com/2016.2.607/styles/kendo.common.min.css"/>
    <link rel="stylesheet" href="http://kendo.cdn.telerik.com/2016.2.607/styles/kendo.rtl.min.css"/>
    <link rel="stylesheet" href="http://kendo.cdn.telerik.com/2016.2.607/styles/kendo.silver.min.css"/>
    <link rel="stylesheet" href="http://kendo.cdn.telerik.com/2016.2.607/styles/kendo.mobile.all.min.css"/>

    
    
@stop
@section('section')


@if(Session::has('success'))
    <script type="text/javascript">
        window.onload = function(){ alert("{{Session::get('success')}}");}
    </script>
@endif
<!--
<script>
  $(document).ready(function(){
    $(".time_element").timepicki();
  });
</script>
-->

<form class="form-horizontal" role="form" method="POST" action="{{ route('tipo_kpi') }}" >
<input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="panel panel-primary">
		<div class="panel-heading"><strong>Datos</strong></div>
		<div class="panel-body">
			<div class="row-sm">					
				<p>Campos marcados con <text style="color:red">*</text> son obligatorios.</p>
			</div>
			<div class="row">
			<div class="col-sm-4">
				<label class="control-label">Area<text style="color:red">*</text></label>
					<div>
						<select class="form-control" name="area" id="area" required="">
							<option value="">Seleccionar</option>
							@foreach($areas as $area)
							 <option value="{{$area->idAreaCt}}">{{$area->nombre}}</option>
							 @endforeach 
						</select>	
					</div>
			</div>		
				

				<div class="col-sm-4">
					
					<label class="control-label">Nombre <text style="color:red">*</text></label>
				 	<div >
						<input type="text"  class="form-control" name="nombre"  id="nombre"  value="" required="">
					</div>
				</div>
				<div class="col-sm-4">
					<label class="control-label">Unidad<text style="color:red">*</text></label>
				 	<div >
						<input type="text"  class="form-control" name="unidad"  id="unidad" value="">
					</div>
				
				</div>
				</div>
				<div class="form-group">
				<br>
				    <center>
						<button type="submit" class="btn btn-primary" value="validate" style="margin-right: 15px;">
							Registrar
						</button>
					</center>
				</div>

			</div>

		</div>
	</div>
</form>
@stop




