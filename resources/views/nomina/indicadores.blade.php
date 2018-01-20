@extends('base')
@section('cabezera','Indicadores')
@section('css')

@stop
@section('content')

@if(Session::has('message'))
	<script type="text/javascript">
		window.onload = function(){ alert("{{Session::get('message')}}");}
	</script>
@endif

<form class="form-horizontal" role="form" method="POST" action="{{ route('indicadores') }}" id="buscar_checada">
	<div class="panel panel-primary">
		<div class="panel-heading"></div>
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

@if(isset($resultados))
<h2>Semana {{$resultados['semana']}}</h2>
<h3>Durante esta semana...</h3>
<div class="row">
	<!--Hombres-->
	<div class="col-sm-2">
		<div class="panel panel-primary" style=" border-color: #337ab7;">
            <div class="panel-heading" style="background:#337ab7; border-color: #337ab7;">
                <div class="row">
                <div class="col-xs-3">
                	<i class="fa fa-male fa-4x"></i>
                </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">{{count($resultados['hombres'])}}</div>
                        <div>Hombres trabajaron</div>
                    </div>
                </div>
            </div>
            <a href="#tabla1" id="hombres">
                <div class="panel-footer" style="color:#337ab7;">
                    <span class="pull-left">Ver lista</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
	</div>

	<!--Mujeres-->
	<div class="col-sm-2">
		<div class="panel panel-primary" style=" border-color: #337ab7;">
            <div class="panel-heading" style="background:#337ab7; border-color: #337ab7;">
                <div class="row">
                <div class="col-xs-3">
                	<i class="fa fa-female fa-4x"></i>
                </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">{{count($resultados['mujeres'])}}</div>
                        <div>Mujeres trabajaron</div>
                    </div>
                </div>
            </div>
            <a href="#tabla2" id="mujeres">
                <div class="panel-footer" style="color:#337ab7;">
                    <span class="pull-left">Ver lista</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
	</div>

	<!--dos dias-->
	<div class="col-sm-2">
		<div class="panel panel-primary" style=" border-color: #337ab7;">
            <div class="panel-heading" style="background:#337ab7; border-color: #337ab7;">
                <div class="row">
                <div class="col-xs-3">
                	<i class="fa fa-users fa-4x"></i>
                </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">{{count($resultados['dosDias'])}}</div>
                        <div>Personas trabajaron 1 o 2 dias</div>
                    </div>
                </div>
            </div>
            <a href="#tabla3" id="dosDias">
                <div class="panel-footer" style="color:#337ab7;">
                    <span class="pull-left">Ver lista</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
	</div>

	<!--tres dias-->
	<div class="col-sm-2">
		<div class="panel panel-primary" style=" border-color: #337ab7;">
            <div class="panel-heading" style="background:#337ab7; border-color: #337ab7;">
                <div class="row">
                <div class="col-xs-3">
                	<i class="fa fa-users fa-4x"></i>
                </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">{{count($resultados['tresDias'])}}</div>
                        <div>Personas trabajaron 3 dias</div>
                    </div>
                </div>
            </div>
            <a href="#tabla4" id="tresDias">
                <div class="panel-footer" style="color:#337ab7;">
                    <span class="pull-left">Ver lista</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
	</div>

	<!--cuatro dias-->
	<div class="col-sm-2">
		<div class="panel panel-primary" style=" border-color: #337ab7;">
            <div class="panel-heading" style="background:#337ab7; border-color: #337ab7;">
                <div class="row">
                <div class="col-xs-3">
                	<i class="fa fa-users fa-4x"></i>
                </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">{{count($resultados['cuatroDias'])}}</div>
                        <div>Personas trabajaron 4 dias o mas</div>
                    </div>
                </div>
            </div>
            <a href="#tabla5" id="cuatroDias">
                <div class="panel-footer" style="color:#337ab7;">
                    <span class="pull-left">Ver lista</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
	</div>

	<!--total-->
	<div class="col-sm-2">
		<div class="panel panel-primary" style=" border-color: #337ab7;">
            <div class="panel-heading" style="background:#337ab7; border-color: #337ab7;">
                <div class="row">
                <div class="col-xs-3">
                	<i class="fa fa-users fa-4x"></i>
                </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">{{count($resultados['hombres']) + count($resultados['mujeres'])}}</div>
                        <div>Personas trabajaron</div>
                    </div>
                </div>
            </div>
            <a href="#tabla6" id="todos">
                <div class="panel-footer" style="color:#337ab7;">
                    <span class="pull-left">Ver lista</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
	</div>
</div>

<div class="tablas">
	<!--hombres-->
	<div id="tabla1" hidden>
		<h3>Hombres</h3>
		<table class="table table-striped table-bordered table-hover dataTable no-footer" border="2" width="100%" rules="rows" style='text-transform:uppercase;  ' id="tabla" >
		    <tcss>
		        <th>ID</th>
		        <th>Nombre</th>
		        <th>CURP</th>
		        <th>IMSS</th>
		        <th>RFC</th>
		    </tcss>

		    <tbody>
			    @foreach($resultados['hombres'] as $empleado) 
			        <tr>
			            <td>{{ $empleado->idEmpleado }}</td>
			            <td style="max-width:250px;">{{ $empleado->ap_paterno}} {{ $empleado->ap_materno}}, {{$empleado->nombres}}</td>
			            <td >{{ $empleado->curp}}</td>
			            <td>@if($empleado->imss != null) {{$empleado->imss}} @else N/A @endif</td>
			            <td>{{$empleado->rfc}}</td>
			        </tr>
			    @endforeach
		    </tbody>
		</table>
	</div>

	<!--mujeres-->
	<div id="tabla2" hidden>
		<h3>Mujeres</h3>
		<table class="table table-striped table-bordered table-hover dataTable no-footer" border="2" width="100%" rules="rows" style='text-transform:uppercase;  ' id="tabla" >
		    <tcss>
		        <th>ID</th>
		        <th>Nombre</th>
		        <th>CURP</th>
		        <th>IMSS</th>
		        <th>RFC</th>
		    </tcss>

		    <tbody>
			    @foreach($resultados['mujeres'] as $empleado) 
			        <tr>
			            <td>{{ $empleado->idEmpleado }}</td>
			            <td style="max-width:250px;">{{ $empleado->ap_paterno}} {{ $empleado->ap_materno}}, {{$empleado->nombres}}</td>
			            <td >{{ $empleado->curp}}</td>
			            <td>@if($empleado->imss != null) {{$empleado->imss}} @else N/A @endif</td>
			            <td>{{$empleado->rfc}}</td>
			        </tr>
			    @endforeach
		    </tbody>
		</table>
	</div>

	<!--2dias-->
	<div id="tabla3" hidden>
		<h3>Dos dias o menos</h3>
		<table class="table table-striped table-bordered table-hover dataTable no-footer" border="2" width="100%" rules="rows" style='text-transform:uppercase;  ' id="tabla" >
		    <tcss>
		        <th>ID</th>
		        <th>Nombre</th>
		        <th>CURP</th>
		        <th>IMSS</th>
		        <th>RFC</th>
		    </tcss>

		    <tbody>
			    @foreach($resultados['dosDias'] as $empleado) 
			        <tr>
			            <td>{{ $empleado['empleado']->idEmpleado }}</td>
			            <td style="max-width:250px;">{{ $empleado['empleado']->ap_paterno}} {{ $empleado['empleado']->ap_materno}}, {{$empleado['empleado']->nombres}}</td>
			            <td >{{ $empleado['empleado']->curp}}</td>
			            <td>@if($empleado['empleado']->imss != null) {{$empleado['empleado']->imss}} @else N/A @endif</td>
			            <td>{{$empleado['empleado']->rfc}}</td>
			        </tr>
			    @endforeach
		    </tbody>
		</table>
	</div>

	<!--3dias-->
	<div id="tabla4" hidden>
		<h3>Tres dias</h3>
		<table class="table table-striped table-bordered table-hover dataTable no-footer" border="2" width="100%" rules="rows" style='text-transform:uppercase;  ' id="tabla" >
		    <tcss>
		        <th>ID</th>
		        <th>Nombre</th>
		        <th>CURP</th>
		        <th>IMSS</th>
		        <th>RFC</th>
		    </tcss>

		    <tbody>
			    @foreach($resultados['tresDias'] as $empleado) 
			        <tr>
			            <td>{{ $empleado['empleado']->idEmpleado }}</td>
			            <td style="max-width:250px;">{{ $empleado['empleado']->ap_paterno}} {{ $empleado['empleado']->ap_materno}}, {{$empleado['empleado']->nombres}}</td>
			            <td >{{ $empleado['empleado']->curp}}</td>
			            <td>@if($empleado['empleado']->imss != null) {{$empleado['empleado']->imss}} @else N/A @endif</td>
			            <td>{{$empleado['empleado']->rfc}}</td>
			        </tr>
			    @endforeach
		    </tbody>
		</table>
	</div>

	<!--4dias-->
	<div id="tabla5" hidden>
		<h3>Cuatro dias o mas</h3>
		<table class="table table-striped table-bordered table-hover dataTable no-footer" border="2" width="100%" rules="rows" style='text-transform:uppercase;  ' id="tabla" >
		    <tcss>
		        <th>ID</th>
		        <th>Nombre</th>
		        <th>CURP</th>
		        <th>IMSS</th>
		        <th>RFC</th>
		    </tcss>

		    <tbody>
			    @foreach($resultados['cuatroDias'] as $empleado) 
			        <tr>
			            <td>{{ $empleado['empleado']->idEmpleado }}</td>
			            <td style="max-width:250px;">{{ $empleado['empleado']->ap_paterno}} {{ $empleado['empleado']->ap_materno}}, {{$empleado['empleado']->nombres}}</td>
			            <td >{{ $empleado['empleado']->curp}}</td>
			            <td>@if($empleado['empleado']->imss != null) {{$empleado['empleado']->imss}} @else N/A @endif</td>
			            <td>{{$empleado['empleado']->rfc}}</td>
			        </tr>
			    @endforeach
		    </tbody>
		</table>
	</div>

	<!--total-->
	<div id="tabla6" hidden>
		<h3>Total</h3>
		<table class="table table-striped table-bordered table-hover dataTable no-footer" border="2" width="100%" rules="rows" style='text-transform:uppercase;  ' id="tabla" >
		    <tcss>
		        <th>ID</th>
		        <th>Nombre</th>
		        <th>CURP</th>
		        <th>IMSS</th>
		        <th>RFC</th>
		    </tcss>

		    <tbody>
			    @foreach($resultados['mujeres'] as $empleado) 
			        <tr>
			            <td>{{ $empleado->idEmpleado }}</td>
			            <td style="max-width:250px;">{{ $empleado->ap_paterno}} {{ $empleado->ap_materno}}, {{$empleado->nombres}}</td>
			            <td >{{ $empleado->curp}}</td>
			            <td>@if($empleado->imss != null) {{$empleado->imss}} @else N/A @endif</td>
			            <td>{{$empleado->rfc}}</td>
			        </tr>
			    @endforeach
			    @foreach($resultados['hombres'] as $empleado) 
			        <tr>
			            <td>{{ $empleado->idEmpleado }}</td>
			            <td style="max-width:250px;">{{ $empleado->ap_paterno}} {{ $empleado->ap_materno}}, {{$empleado->nombres}}</td>
			            <td >{{ $empleado->curp}}</td>
			            <td>@if($empleado->imss != null) {{$empleado->imss}} @else N/A @endif</td>
			            <td>{{$empleado->rfc}}</td>
			        </tr>
			    @endforeach
		    </tbody>
		</table>
	</div>
</div>



@endif

@stop

@section('js')
<script type="text/javascript">
	$('#hombres').click(function(){
		$('#tabla1').show();
		$('#tabla2').hide();
		$('#tabla3').hide();
		$('#tabla4').hide();
		$('#tabla5').hide();	
		$('#tabla6').hide();
	});
	$('#mujeres').click(function(){
		$('#tabla1').hide();
		$('#tabla2').show();
		$('#tabla3').hide();
		$('#tabla4').hide();
		$('#tabla5').hide();	
		$('#tabla6').hide();
	})
	$('#dosDias').click(function(){
		$('#tabla1').hide();
		$('#tabla2').hide();
		$('#tabla3').show();
		$('#tabla4').hide();
		$('#tabla5').hide();	
		$('#tabla6').hide();
	})
	$('#tresDias').click(function(){
		$('#tabla1').hide();
		$('#tabla2').hide();
		$('#tabla3').hide();
		$('#tabla4').show();
		$('#tabla5').hide();	
		$('#tabla6').hide();
	})
	$('#cuatroDias').click(function(){
		$('#tabla1').hide();
		$('#tabla2').hide();
		$('#tabla3').hide();
		$('#tabla4').hide();
		$('#tabla5').show();		
		$('#tabla6').hide();	
	})
	$('#todos').click(function(){		
		
		$('#tabla1').hide();
		$('#tabla2').hide();
		$('#tabla3').hide();
		$('#tabla4').hide();
		$('#tabla5').hide();	
		$('#tabla6').show();
	})
</script>
@endsection
