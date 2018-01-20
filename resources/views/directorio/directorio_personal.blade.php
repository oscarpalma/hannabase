@extends('base')
@section('cabezera','Directorio Interno')
@section('css')
<style type="text/css">
.glyphicon-lg
{
    font-size:5em
}
.info-block
{
    border-right:5px solid #E6E6E6;margin-bottom:25px
}
.info-block .square-box
{
    width:100px;min-height:110px;margin-right:22px;text-align:center!important;background-color:#676767;padding:20px;
}
.info-block.block-info
{
    border-color:#20819e
}
.info-block.block-info .square-box
{
    background-color:#20819e;color:#FFF
}

.tabla{
	font-family:'Helvetica';
	font-size: 13px;
}

</style>
@endsection
@section('content')
           

	<div class="row">
		<div class="col-sm-4">
            <input type="search" class="form-control" id="input-search" placeholder="Buscar" >
        </div>
        
	</div>
	<br>
		<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        <div class="panel panel-primary">
			<div class="panel-heading" role="tab" id="headingOne"><a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Personal de Oficina
        </a></div>
        <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
			<div class="panel-body">
	<div class="tabla">
        <div class="searchable-container">
            @foreach ($directorio as $directorio)

               <div class="items col-xs-12 col-sm-6 col-md-6 col-lg-6 clearfix">
               <div class="info-block block-info clearfix">
                    <div class="square-box pull-left">
                        <span class="glyphicon glyphicon-user glyphicon-lg"></span>
                    </div>
                    
                    <h5><strong>Nombre:</strong> {{$directorio->nombre}}</h5>
                    <strong>Puesto:</strong> {{$directorio->puesto}}
                    <br>
                    <strong>Telefono:</strong> {{$directorio->celular}}
                    <br>
                    <strong>Correo:</strong> {{$directorio->correo}}
                    <br>
                </div>
            </div>
            @endforeach          
           
        </div>
       </div>
        </div>
        </div>
        </div>

         <div class="panel panel-primary">
			<div class="panel-heading" role="tab" id="headingTwo">
			<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Oficinas
        </a></div>
         <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
			<div class="panel-body">
			<div class="tabla">
        <div class="searchable-container">
            @foreach ($directorio_sucursal as $directorio)

               <div class="items col-xs-12 col-sm-6 col-md-6 col-lg-6 clearfix">
               <div class="info-block block-info clearfix">
                    <div class="square-box pull-left">
                        <span class="fa fa-building glyphicon-lg"></span>
                    </div>
                    
                    <h5><strong>Sucursal:</strong> {{$directorio['sucursal']}}</h5>
                   <h5><strong>Área:</strong> {{$directorio['area']}}</h5>
                    <strong>Telefonos:</strong> {{$directorio['telefonos']}}
                   
                   
                </div>
            </div>
            @endforeach

            </div>
            </div>
            </div>
            </div>
            </div>
	</div>


@endsection

@section('js')
<script type="text/javascript">
	$(function() {    
        $('#input-search').on('keyup', function() {
          var rex = new RegExp($(this).val(), 'i');
            $('.searchable-container .items').hide();
            $('.searchable-container .items').filter(function() {
                return rex.test($(this).text());
            }).show();
        });
    });
</script>
@endsection