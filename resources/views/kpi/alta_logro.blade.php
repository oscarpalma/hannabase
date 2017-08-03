@extends('layouts.dashboard')
@section('page_heading','Logros')
@section('head')

@stop
@section('section')

@if(Session::has('success'))
	

<div class="alert alert-success alert-dismissible" role="alert" id="success">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span></strong> {{Session::get('success')}}
				
			</div>
@endif
<form class="form-horizontal" role="form" method="POST" action="{{ route('logro') }}" >
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
						
					</center>
				</div>

			</div>
		</div>
	</div>
</form>



 

<script>



    $(document).ready(function () {
       

	$('#area').on('change', function(e){
    
    var idAreaCt = e.target.value;
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

   
</script>




@stop