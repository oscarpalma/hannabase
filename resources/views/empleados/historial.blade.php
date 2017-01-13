@extends('layouts.dashboard')
@section('page_heading','Historial de empleado')
@section('head')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="{{ asset('assets/scripts/barcode/JsBarcode.all.js') }}"></script>
<script>
		Number.prototype.zeroPadding = function(){
			var ret = "" + this.valueOf();
			return ret.length == 1 ? "0" + ret : ret;
		};
	</script>

	<style>
 
  
  #load { height: 100%; width: 100%; }
  #load {
    position    : fixed;
    z-index     : 99999; /* or higher if necessary */
    top         : 0;
    left        : 0;
    overflow    : hidden;
    text-indent : 100%;
    font-size   : 0;
    opacity     : 0.6;
    background  : #E0E0E0  url({!! asset('imagenes/load.gif') !!}) center no-repeat;
  }
  
  .RbtnMargin { margin-left: 5px; }
  
  /* Timeline */
.timeline,
.timeline-horizontal {
  list-style: none;
  padding: 20px;
  position: relative;
}
.timeline:before {
  top: 40px;
  bottom: 0;
  position: absolute;
  content: " ";
  width: 3px;
  background-color: #eeeeee;
  left: 50%;
  margin-left: -1.5px;
}
.timeline .timeline-item {
  margin-bottom: 20px;
  position: relative;
}
.timeline .timeline-item:before,
.timeline .timeline-item:after {
  content: "";
  display: table;
}
.timeline .timeline-item:after {
  clear: both;
}
.timeline .timeline-item .timeline-badge {
  color: #fff;
  width: 54px;
  height: 54px;
  line-height: 52px;
  font-size: 22px;
  text-align: center;
  position: absolute;
  top: 18px;
  left: 50%;
  margin-left: -25px;
  background-color: #7c7c7c;
  border: 3px solid #ffffff;
  z-index: 100;
  border-top-right-radius: 50%;
  border-top-left-radius: 50%;
  border-bottom-right-radius: 50%;
  border-bottom-left-radius: 50%;
}
.timeline .timeline-item .timeline-badge i,
.timeline .timeline-item .timeline-badge .fa,
.timeline .timeline-item .timeline-badge .glyphicon {
  top: 2px;
  left: 0px;
}
.timeline .timeline-item .timeline-badge.primary {
  background-color: #1f9eba;
}
.timeline .timeline-item .timeline-badge.info {
  background-color: #5bc0de;
}
.timeline .timeline-item .timeline-badge.success {
  background-color: #59ba1f;
}
.timeline .timeline-item .timeline-badge.warning {
  background-color: #d1bd10;
}
.timeline .timeline-item .timeline-badge.danger {
  background-color: #ba1f1f;
}
.timeline .timeline-item .timeline-panel {
  position: relative;
  width: 46%;
  float: left;
  right: 16px;
  border: 1px solid #c0c0c0;
  background: #ffffff;
  border-radius: 2px;
  padding: 20px;
  -webkit-box-shadow: 0 1px 6px rgba(0, 0, 0, 0.175);
  box-shadow: 0 1px 6px rgba(0, 0, 0, 0.175);
}
.timeline .timeline-item .timeline-panel:before {
  position: absolute;
  top: 26px;
  right: -16px;
  display: inline-block;
  border-top: 16px solid transparent;
  border-left: 16px solid #c0c0c0;
  border-right: 0 solid #c0c0c0;
  border-bottom: 16px solid transparent;
  content: " ";
}
.timeline .timeline-item .timeline-panel .timeline-title {
  margin-top: 0;
  color: inherit;
}
.timeline .timeline-item .timeline-panel .timeline-body > p,
.timeline .timeline-item .timeline-panel .timeline-body > ul {
  margin-bottom: 0;
}
.timeline .timeline-item .timeline-panel .timeline-body > p + p {
  margin-top: 5px;
}
.timeline .timeline-item:last-child:nth-child(even) {
  float: right;
}
.timeline .timeline-item:nth-child(even) .timeline-panel {
  float: right;
  left: 16px;
}
.timeline .timeline-item:nth-child(even) .timeline-panel:before {
  border-left-width: 0;
  border-right-width: 14px;
  left: -14px;
  right: auto;
}
.timeline-horizontal {
  list-style: none;
  position: relative;
  padding: 20px 0px 20px 0px;
  display: inline-block;
}
.timeline-horizontal:before {
  height: 3px;
  top: auto;
  bottom: 26px;
  left: 56px;
  right: 0;
  width: 100%;
  margin-bottom: 20px;
}
.timeline-horizontal .timeline-item {
  display: table-cell;
  height: 280px;
  width: 20%;
  min-width: 320px;
  float: none !important;
  padding-left: 0px;
  padding-right: 20px;
  margin: 0 auto;
  vertical-align: bottom;
}
.timeline-horizontal .timeline-item .timeline-panel {
  top: auto;
  bottom: 64px;
  display: inline-block;
  float: none !important;
  left: 0 !important;
  right: 0 !important;
  width: 100%;
  margin-bottom: 20px;
}
.timeline-horizontal .timeline-item .timeline-panel:before {
  top: auto;
  bottom: -16px;
  left: 28px !important;
  right: auto;
  border-right: 16px solid transparent !important;
  border-top: 16px solid #c0c0c0 !important;
  border-bottom: 0 solid #c0c0c0 !important;
  border-left: 16px solid transparent !important;
}
.timeline-horizontal .timeline-item:before,
.timeline-horizontal .timeline-item:after {
  display: none;
}
.timeline-horizontal .timeline-item .timeline-badge {
  top: auto;
  bottom: 0px;
  left: 43px;
}

  </style>
@stop
@section('section')


<div id="load">Espere un momento ...</div>
<div class="container-fluid">
<div class="row">
	
			<div class="row">
					<div class="col-lg-4">
					    <div class="input-group">
					      <input type="text" class="form-control" placeholder="Numero de empleado" id="idBuscar">
					      <span class="input-group-btn">

					        <button class="btn btn-default" type="button" id="buscar"><span class="glyphicon glyphicon glyphicon-search" aria-hidden="true"></span></button>
					      </span>
					    </div>
  					</div>
			</div>

					
	<br>
</div>
	<div class="row">
	<div class="alert alert-info alert-dismissible" role="alert" id="mensajeInicial">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong><span class="glyphicon glyphicon glyphicon-info-sign" aria-hidden="true"></span></strong> Ingrese el numero de empleado 
				
			</div>
		<div class="alert alert-danger alert-dismissible" role="alert" id="error" hidden="">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span></strong> El numero de empleado ingresado no coincide con ningun empleado registrado! 
				
			</div>
		  <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title">Informacion personal</h3>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-3 col-lg-3 " align="center"> <img alt="" src="{{ asset('imagenes/user2.png') }}" class="img-circle img-responsive" id="fotografia"> </div>
                
                
                <div class=" col-md-4 col-lg-4 "> 
                  <table class="table table-user-information">
                    <tbody>
                      <tr>
                        <td><strong>Numero de empleado:</td>
                        <td id="numeroE"></td>
                      </tr>
                      <tr>
                        <td><strong>Nombre:</td>
                        <td id="nombre"></td>
                      </tr>
                      <tr>
                        <td><strong>Fecha de ingreso:</td>
                        <td id="fechaI"></td>
                      </tr>
                                            
                        
                      <tr>
                        <td><strong>Fecha de nacimiento</strong></td>
                        <td id="fecha"></td>
                      </tr>
                      <tr>
                        <td><strong>Estado de nacimiento:</strong></td>
                        <td id="estado">
                        </td>
                           
                      </tr>
                      
                      <tr>
                        <td><strong>CURP:</strong></td>
                        <td id="curp"></td>
                      </tr>
                      <tr>
                        <td><strong>IMSS:</strong></td>
                        <td id="imss"></td>
                      </tr>
                      <tr>
                        <td><strong>RFC:</strong></td>
                        <td id="rfc"></td>
                      </tr>
                      <tr>
                        <td><strong>Perfil:</strong></td>
                        <td id="perfil"></td>
                      </tr>
                     <tr>
                        <td><strong>Visa:</strong></td>
                        <td id="visa"></td>
                      </tr>
                    </tbody>
                  </table>
                  
                </div>
                <div class=" col-md-9 col-lg-4 "> 
                  <table class="table table-user-information">
                    <tbody >
                      
                   <tr>
                        <td><strong>Direccion:</strong></td>
                        <td id="direccion"></td>
                      </tr>
                      <tr>
                        <td><strong>Telefono(s):</strong></td>
                        <td id="telefono"></td>
                      </tr>
                      <tr>
                        <td><strong>En caso de emergencia:</strong></td>
                        <td id="contacto"></td>
                      </tr>
                      
                     
                    </tbody>
                  </table>
                  
                  
                  </div>
              </div>
            </div>
            <div class="panel-heading">
              <h3 class="panel-title">Historial Laboral</h3>
            </div>
            <div class="panel-body">
              <div class="row">
               <div class=" col-md-9 col-lg-4 "> 
                  <table class="table table-user-information">
                  <thead>
                    <tr>
                      <th>
                        Empresa
                      </th>
                      <th>
                        Dias Trabajados
                      </th>
                    </tr>
                  </thead>
                    <tbody id="empresas" >
                      
                  
                      
                     
                    </tbody>
                  </table>
                  
                  
                  </div>
                   <div class=" col-md-7 col-lg-7 "> 
                    <canvas id="clines"></canvas>
                    </div>
              </div>
         
      
					
				</div>
            </div>
            
            
            
          </div>
	</div>
</div>



@section('scripts')


<script type="text/javascript">
  
  

$(document).ready(function(){

    $("#load").hide();

$( "#idBuscar" ).keypress(function( event ) {
  if ( event.which == 13 ) {
     event.preventDefault();
     buscar();
  }
});

   $("#buscar").click(function(){

        buscar();
        
            
            }); 

    function buscar(){
      var idBuscar = $.trim($("#idBuscar").val());
      
      if (idBuscar!=""){
           $( "#load" ).show();

           
       var dataString = { 
              id : idBuscar,
              _token : '{{ csrf_token() }}'
            };
        $.ajax({
            type: "POST",
            url: "{{ URL::to('empleados/historial') }}",
            data: dataString,
            dataType: "json",
            cache : false,
            success: function(data){
                           
              if(data){
                $( "#load" ).hide();
                $("#nombre").html(data.nombre);
                $("#numeroE").html(data.id);
                $("#fecha").html(data.fecha);
                $("#estado").html(data.estado);
                $("#curp").html(data.curp);
                $("#imss").html(data.imss);
                $("#cuenta").html(data.cuenta);
                $("#rfc").html(data.rfc);
                $("#perfil").html(data.perfil);
                $("#visa").html(data.visa);
                $("#telefono").html(data.telefono);
                $("#direccion").html(data.direccion);
                $("#contacto").html(data.contacto);
                
                if(data.foto!=null)
                  $("#fotografia").attr("src","/"+data.foto);
                else
                  $("#fotografia").attr("src","/imagenes/user2.png");
                $("#empresas").html("");
                if (!data.sinChecada){
                  $("#fechaI").html(data.fechaI);
                  $.each(data.empresas,function(index,empresa){

                   $("#empresas").append("<tr>"+
                          "<td>"+empresa.nombre.nombre+"</td>"+
                          "<td>"+empresa.dias+"</td>"+
                        "</tr>")
                  });

                  /*$("#empresas").append('<div class="col-xs-3 col-sm-3 col-md-2 col-lg-2">'+
                  '<div class="panel price panel-red">'+
                  '<div class="panel-heading  text-center">'+
                  '<h3>'+empresa.nombre.nombre+'</h3></div>'+           
                  '<ul class="list-group list-group-flush text-center">'+
                  '<li class="list-group-item"><i class="icon-ok text-danger"></i>'+empresa.dias+" Dias Trabajados"+
                  '</li></ul></div></div>');
                });*/
                }else{
                  $("#fechaI").html("No ha laborado");
                  $("#empresas").html("El empleado aun no ha laborado en ninguna empresa");
                }
                              
              } 
          
            } ,error: function(xhr, status, error) {
              alert(error);
            },
        });
        }
    }

var lineChartData = {
    labels : ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"],
    datasets : [
        
        {
            label: "My Second dataset",
             fillColor: "rgba(151,187,205,0.2)",
            strokeColor: "rgba(151,187,205,1)",
            pointColor: "rgba(151,187,205,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill : "#fff",
            pointHighlightStroke : "rgba(244, 204, 11, 1)",
            data : [28,48,40,19,86,27,90]
        }
    ]

}


    var cline = document.getElementById("clines").getContext("2d");
    new Chart(cline).Line(lineChartData, {
        responsive: true
    });

  });

</script>

    @stop
@stop