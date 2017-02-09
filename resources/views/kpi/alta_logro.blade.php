@extends('layouts.dashboard')
@section('page_heading','Logros')
@section('head')
<link rel="stylesheet" href="{{ asset("assets/stylesheets/select2.css") }}" />
@stop
@section('section')

@if(Session::has('success'))
	

<div class="alert alert-success alert-dismissible" role="alert" id="success">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span></strong> {{Session::get('success')}}
				
			</div>
@endif
<form class="form-horizontal" role="form" method="POST" action="{{ route('logro') }}" id="imprimir">
	<div class="panel panel-primary">
		<div class="panel-heading"><strong></strong></div>
		<div class="panel-body">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">	
			<div class="row-sm">					
				<p>Campos marcados con <text style="color:red">*</text> son obligatorios.</p>
				
			</div>
			<div class="row">
				<div class="col-sm-3">
					<label class="control-label">Area <text style="color:red">*</text></label>
					<div>
						<select class="form-control" id="area" name="area" required="">
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
						<select class="form-control" name="tipo" id="tipo" required="">
							<!--en caso de no especificar ninguno-->
							<option value="">-------</option>
							
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
				

				

				<div class="col-sm-4">
					<br>
				    <center>
						<button type="submit" class="btn btn-primary" value="validate" style="margin-right: 15px;">
							Guardar
						</button>
						<input id="btn-Preview-Image" type="button" value="Preview"/>
    <a id="btn-Convert-Html2Image" href="#">Download</a>
    <br/>
    <h3>Preview :</h3>
    <div id="previewImage">
    </div>
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

	$('#area').on('change', function(e){
    
    var idAreaCt = e.target.value;
	//$("#tipo option[value='null']").hide();
	
    

	   

	     $.ajax({
		            type: "GET",
		            url: "{{ URL::to('kpi/obtenerLogros') }}",
		            data: { id:idAreaCt},
		            dataType: "json",
		            cache : false,
		            success: function(data){
		            	$('#tipo').empty();
		              	if(data.length>0){		              		   	
		       		    	$('#tipo').append('<option value="">Seleccione</option>');
					       	$.each(data,function(index,tiposObj){
					       		$('#tipo').append('<option value="'+tiposObj.idTipoKpi+'">'+tiposObj.nombre+'</option>');
					       		
					       	});
			       		}else{
			       			$('#tipo').append('<option value="">-------</option>');
			       		}
		          
		            } ,error: function(xhr, status, error) {
		              alert(error);
		            },

		        });
	
});
    });
$(function() { 
    $("#btnSave").click(function() { 
        html2canvas($("#widget"), {
            onrendered: function(canvas) {
                theCanvas = canvas;
                document.body.appendChild(canvas);

                // Convert and download as image 
                Canvas2Image.saveAsPNG(canvas); 
                $("#img-out").append(canvas);
                // Clean up 
                //document.body.removeChild(canvas);
            }
        });
    });
}); 
   
</script>



@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script src="{{ asset("assets/scripts/jquery.btechco.excelexport.js") }}" type="text/javascript"></script>
    <script src="{{ asset("assets/scripts/jquery.base64.js") }}" type="text/javascript"></script>
     <script src="{{ asset("assets/scripts/html2canvas.js") }}" type="text/javascript"></script>
<script>
$(document).ready(function(){

	
var element = $("#imprimir"); // global variable
var getCanvas; // global variable
 
    $("#btn-Preview-Image").on('click', function () {
         html2canvas(element, {
         onrendered: function (canvas) {
                $("#previewImage").html(canvas);
                getCanvas = canvas;
                var imgageData = getCanvas.toDataURL("image/png");
    // Now browser starts downloading it instead of just showing it
    var newData = imgageData.replace(/^data:image\/png/, "data:application/octet-stream");
    $("#btn-Preview-Image").attr("download", "your_pic_name.png").attr("href", newData);
             }
         });
          
    });

	$("#btn-Convert-Html2Image").on('click', function () {
    var imgageData = getCanvas.toDataURL("image/png");
    // Now browser starts downloading it instead of just showing it
    var newData = imgageData.replace(/^data:image\/png/, "data:application/octet-stream");
    $("#btn-Convert-Html2Image").attr("download", "your_pic_name.png").attr("href", newData);
	});

});

</script>
    @stop
@stop