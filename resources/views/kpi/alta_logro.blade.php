@extends('layouts.dashboard')
@section('page_heading','Logros')
@section('head')
<link rel="stylesheet" href="{{ asset("assets/stylesheets/select2.css") }}" />
@stop
@section('section')

@if(Session::has('message'))
	<script type="text/javascript">
		window.onload = function(){ alert("{{Session::get('message')}}");}
	</script>
@endif

<form class="form-horizontal" role="form" method="POST" action="{{ route('reporte') }}" id="buscar_checada">
	<div class="panel panel-primary">
		<div class="panel-heading"><strong>Buscar</strong></div>
		<div class="panel-body">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">	
			<div class="row-sm">					
				<p>Campos marcados con <text style="color:red">*</text> son obligatorios.</p>
				
			</div>
			<div class="row">
				<div class="col-sm-3">
					<label class="control-label">Area <text style="color:red">*</text></label>
					<div>
						<select class="form-control" id="area" name="area" >
							<!--en caso de no especificar ninguno-->
							<option value="">Seleccione</option>
							@foreach($areas as $area)
							 <option value="{{$area->idAreaCt}}">{{$area->nombre}}</option>
							 @endforeach 
						</select>
					</div>
				</div>

				<div class="col-sm-3">
					<label class="control-label">Tipo Kpi <text style="color:red">*</text></label>
					<div>
						<select class="form-control" name="tipo" id="tipo">
							<!--en caso de no especificar ninguno-->
							<option value="">Seleccione</option>
							
						</select>
					</div>
				</div>

				<div class="col-sm-3">
					<label class="control-label">Plan <text style="color:red">*</text></label>
					<div>
						<input class="form-control" type="text" name="plan" required="">
					</div>
				</div>
				<div class="col-sm-3">
					<label class="control-label">Actual <text style="color:red">*</text></label>
					<div>
						<input class="form-control" type="text" name="actual" required="">
					</div>
				</div>
			</div>

			<div class="row">
			<div class="col-sm-3">
					<label class="control-label">Fecha <text style="color:red">*</text></label>
					<div>
						<input class="form-control" type="date" name="fecha" required="">
					</div>
				</div>
				<div class="col-sm-3">
					<label class="control-label">Semana <text style="color:red">*</text></label>
					<div>
						<select class="form-control" name="semana" >
							@for($i = 1; $i<=Date('W'); $i++)
								<option value="{{$i}}">Semana {{$i}}</option>
							@endfor
						</select>
					</div>
				</div>

				

				<div class="col-sm-4">
					<br>
				    <center>
						<button type="submit" class="btn btn-primary" value="validate" style="margin-right: 15px;">
							Guardar
						</button>
					</center>
				</div>

			</div>
		</div>
	</div>
</form>



 

<script>

window.onload = function(){
	var cliente = $("#clienteT").attr("value");
	var colores = ['#660099','#FF9933','#F7D708','#097054','#CE0909','#089669','#088596','#005DC1','#DAB900','#BE00A8','#00039B','#B24100','#8F0000','#7D7F00','#00B0AD','#464646','#6BA4A3','#AC7207','#FF755A','#AAC65D','#99FFFF','#66FFCC','#CCCC99','#993333','#CC66CC','#009999','#CC99CC','#CCCC99','#FFCC99','#FF9999'];
	var i=0;
	$("#cliente option").each(function(){
		//alert($(this).text());
   if (cliente== $(this).text()){
		$(".color").attr("style", "background-color: "+colores[i-1]+"; color: #fff");
		
		
	}
	i=i+1;
});
	/*if (cliente=="SSD-PINTURA"){
		$(".color").attr("style", "background-color: "+colores[0]+"; color: #fff");
	}else if (cliente=="SSD-STEAM"){
		$(".color").attr("style", "background-color: "+colores[0]+"; color: #fff");
	}else if (cliente=="SAMEX"){
		$(".color").attr("style", "background-color: "+colores[0]+"; color: #fff");
	}else if (cliente=="WOORI"){
		$(".color").attr("style", "background-color: "+colores[0]+"; color: #fff");
	}*/


}

    $(document).ready(function () {
        $("#btnExport").click(function () {
        	var cliente= "@if(isset($parametros['reporte'])){{$parametros['semana']}} {{$parametros['reporte']['cliente']}}@endif";
        	var worksheet= "@if(isset($parametros['reporte'])){{$parametros['reporte']['cliente']}}@endif"
            $("#tblExport").btechco_excelexport({
                containerid: "tblExport"
               , datatype: $datatype.Table
               , filename: 'semana '+cliente
               , nombre: worksheet
               
            });
        });

         $("#btnCliente").click(function () {
        	var cliente= "@if(isset($parametros['reporte'])){{$parametros['semana']}} {{$parametros['reporte']['cliente']}}@endif";
        	var worksheet= "@if(isset($parametros['reporte'])){{$parametros['reporte']['cliente']}}@endif"
            $("#tblExport").btechco_excelexport({
                containerid: "tablaCliente"
               , datatype: $datatype.Table
               , filename: 'semana '+cliente
               , nombre: worksheet
               
            });
        });
    
 		$("#empleado").select2();
		$("#cliente").select2();

	$('#cliente').on('change', function(e){
    console.log(e);
    var idCliente = e.target.value;
	$("#cliente option[value='null']").hide();
	
    if($("#cliente").val() != "null"){

	    $.get('/ajax-cliente?idCliente=' + idCliente, function(data) {
	    	//console.log(data);

	    	//Muestra los turnos segun el cliente que se ha seleccionado
	       	$('#turno').empty();
	       	$.each(data,function(index,turnosObj){
	       	$('#turno').append('<option value="'+turnosObj.idTurno+'">'+turnosObj.hora_entrada+" - "+turnosObj.hora_salida+'</option>');
	       	});

	    });
	}

	else{
		$('#turno').empty();
	}
});
    });

   
</script>



@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script src="{{ asset("assets/scripts/jquery.btechco.excelexport.js") }}" type="text/javascript"></script>
    <script src="{{ asset("assets/scripts/jquery.base64.js") }}" type="text/javascript"></script>


    @stop
@stop