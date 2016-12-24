@extends('layouts.dashboard')
@section('page_heading','Exportar Nomina')
@section('head')
<link rel="stylesheet" href="{{ asset("assets/stylesheets/select2.css") }}" />
@stop
@section('section')

@if(Session::has('message'))
	<script type="text/javascript">
		window.onload = function(){ alert("{{Session::get('message')}}");}
	</script>
@endif

<form class="form-horizontal" role="form" method="POST" action="{{ route('exportar_nomina') }}" id="buscar_checada">
	<div class="panel panel-primary">
		<div class="panel-heading"><strong>Buscar</strong></div>
		<div class="panel-body">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">	
			<div class="row-sm">					
				<p>Campos marcados con <text style="color:red">*</text> son obligatorios.</p>
				<center><label>Semana Actual {{date("W")}}</label></center>
			</div>
			<div class="row">				
				<div class="col-sm-4">
					<label class="control-label">Semana <text style="color:red">*</text></label>
					<div>
						<select class="form-control" name="semana" >
							@for($i = 1; $i<=53; $i++)
								<option value="{{$i}}">Semana {{$i}}</option>
							@endfor
						</select>
					</div>
				</div>

				<div class="col-sm-4">
					<label class="control-label">Año <text style="color:red">*</text></label>
					<div>
						<select class="form-control" name="year">
						<!--desde 2013 hasta el anio actual, como en coen-->
							@for($i = date('Y'); $i >= 2013; $i--)
								<option value="{{$i}}">{{$i}}</option>
							@endfor
						</select>
					</div>
				</div>

				<div class="col-sm-4">
					<br>
				    <center>
						<button type="submit" class="btn btn-primary" value="validate" style="margin-right: 15px;">
							Buscar
						</button>
					</center>
				</div>

			</div>
		</div>
	</div>
</form>

@stop