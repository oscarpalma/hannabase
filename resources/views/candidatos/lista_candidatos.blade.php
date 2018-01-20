@extends('base')
@section('titulo','Lista de Candidatos')
@section('cabezera','Lista de Candidatos')
@section('css')
<style type="text/css">
    
</style>  
<!-- Modal CSS -->
    <link href="/static/css-modal/modal.css" rel="stylesheet">
     
@endsection
@section('content')

      

@if ( empty ( $informacion ) ) 
            <div class="alert alert-info alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></strong> No hay Candidatos Registrados<br><br> 
                    
                </div>
@else
                <div class="row">
                    <div class="col-sm-4">
                        <input id="buscar" class="form-control" placeholder="Busqueda">
                    </div>
                    <div class="form-group right">
                    <div class="pull-right" >
                        <button class="btn btn-success" id="convertir" title="Convertir a empleado" ><i class="fa fa-share"></i></button>
                        <button type="button" class="btn btn-danger" id="lista_negra" title="Enviar a lista negra" >
                         <i class="glyphicon glyphicon-ban-circle"></i> 
                        </button>
                        <button type="button" class="btn btn-danger" id="eliminar" title="Eliminar" style="margin-right: 15px;">
                         <i class="fa fa-trash"></i> 
                        </button>

                        </div>
                    
                </div>
                </div>
                    
                    <br>
            
	

                    <div class="panel panel-primary">
                        <div class="panel-heading"></div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper tabla">

                                <table class="table tables table-striped table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="selecTodo" /></th>
                                            <th>#</th>
                                            <th>Nombre</th>
                                            <th>CURP</th>
                                            <th>IMSS</th>
                                           <th>Perfil</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody >
                                        
                                       @foreach($informacion as $empleado) 
                                
                                <tr id="{{ $empleado['empleado']->idEmpleado }}">
                                <td> <input type="checkbox" name="seleccionado" class="select" /> </td>
                                <td>{{ $empleado['empleado']->idEmpleado }}</td>
                                <td >{{ $empleado['empleado']->ap_paterno}} {{ $empleado['empleado']->ap_materno}} , {{$empleado['empleado']->nombres}}</td>
                                <td >{{ $empleado['empleado']->curp}}</td>
                                <td>@if($empleado['empleado']->imss != null) {{$empleado['empleado']->imss}} @else N/A @endif</td>
                                <td ><div class="form-actions"> {{ $empleado['empleado']->tipo_perfil}}</div></td>
                                <td ><div class="form-actions">
                                                                                                                                     

                                    
                                    <a class="btn btn-primary btn-sm btn-circle" href="{{ route('editar_candidato',$empleado['empleado']->idEmpleado) }}" title="modificar"><i class="fa fa-edit"></i></a>
                                    <button type="button" class="btn btn-primary btn-sm btn-circle verDatos" title="Ver datos del empleado" >
                                         <i class="fa fa-info-circle"></i> 
                                    </button>
                               
                                </div></td>
                            </tr>
                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                            
                        </div>
                        <!-- /.panel-body -->
                    </div> 
                    <!-- /.panel -->
               
   
		@endif
<!-- Modales -->

<!-- Modal Convertir a empleado -->
<div class="modal fade" id="convertirModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                               
                                <!-- Contenido modal convertir a empleado -->
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header modal-header-success">
                                            <h4 class="modal-title">Convertir a Empleado</h4>
                                          </div>
                                          <div class="modal-body">
                                            <p><strong> ¿Desea convertir el(los) siguiente(s) candidato(s) a empleado?</strong></p>
                                           <div class="tabla-modal">
                                           <table class="table table-striped table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nombre</th>
                                            <th>CURP</th>
                                            </tr>
                                    </thead>
                                    <tbody id="infoConvertir">
                                    
                                    </tbody>
                                    </table>
                                    </div>

                                            <div class="row">
                                                <div class="col-12-xs text-center">
                                                    <button class="btn btn-success btn-m" id="confirmacionConvertir">Si</button>
                                                    <button class="btn btn-danger btn-m" data-dismiss="modal">No</button>
                                                </div>
                                            </div>
                                          </div>
                                    <!-- /.modal-content -->
                                </div> </div>
                                <!-- /.modal-dialog convertir a empleado-->

                            </div>
                            <!-- /.modal -->
            <!-- /.Modal Convertir a empleado -->

 <!-- Modal eliminar -->
<div class="modal fade" id="eliminarModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                               
                                <!-- Contenido modal eliminar -->
                                <div class="modal-dialog" >
                                    <div class="modal-content">
                                        <div class="modal-header modal-header-danger">
                                            <h4 class="modal-title">Eliminar Candidatos</h4>
                                          </div>
                                          <div class="modal-body">
                                            <p><strong> ¿Esta seguro de eliminar al(los) siguiente(s) candidato(s)?</strong></p>
                                           <div class="tabla-modal">
                                           <table class="table table-striped table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nombre</th>
                                            <th>CURP</th>
                                            </tr>
                                    </thead>
                                    <tbody id="infoEliminar">
                                    
                                    </tbody>
                                    </table>
                                    </div>

                                            <div class="row">
                                                <div class="col-12-xs text-center">
                                                    <button class="btn btn-success btn-m" id="confirmacionEliminar">Si</button>
                                                    <button class="btn btn-danger btn-m" data-dismiss="modal">No</button>
                                                </div>
                                            </div>
                                          </div>
                                    <!-- /.modal-content -->
                                </div> </div>
                                <!-- /.modal-dialog eliminar-->

                            </div>
                            <!-- /.modal -->
            <!-- /.Modal eliminar -->
       

<!-- Modal enviar a lista negra -->
<div class="modal fade" id="listaNegraModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                                <!-- Contenido Modal Lista Negra -->
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header modal-header-danger">
                                            <h4 class="modal-title">Enviar a Lista Negra</h4>
                                          </div>
                                          <div class="modal-body">
                                            <p><strong> ¿Esta seguro de enviar a lista negra al(los) siguiente(s) candidato(s)?</strong></p>
                                           <div class="tabla-modal">
                                           <table class="table table-striped table-bordered table-hover" id="">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nombre</th>
                                            <th>CURP</th>
                                            </tr>
                                    </thead>
                                    <tbody id="infoListaNegra">
                                    
                                    </tbody>
                                    </table>
                                    </div>

                                            <div class="row">
                                                <div class="col-12-xs text-center">
                                                    <button class="btn btn-success btn-m" id="confirmacionLN">Si</button>
                                                    <button class="btn btn-danger btn-m" data-dismiss="modal">No</button>
                                                </div>
                                            </div>
                                          </div>
                                    <!-- /.modal-content -->
                                </div></div>
                                <!-- /.modal-dialog Lista Negra-->
                               

                            </div>
                            <!-- /.modal Lista negra-->

<!-- Modal Ver Datos -->
<div class="modal fade" id="verDatosModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                                <!-- Contenido Modal Ver Datos -->
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header modal-header-primary">
                                            <h4 class="modal-title">Datos del candidato</h4>
                                          </div>
                                          <div class="modal-body">
                                            <div class="row">
                <div class="col-md-3 col-lg-3 " align="center"> 
                <img alt="foto" src="" class="img-rounded img-responsive"  id="fotografia"> 
                <span id="nombre"></span>
                <br># <span id="numeroE"></span> 
                </div>
                
                
                <div class=" col-md-9 col-lg-9 "> 
                  <table class="table ">
                    <tbody>
                     
                      
                      <tr>
                        <td><strong>Fecha Nac.</strong></td>
                        <td id="fecha"></td>
                      </tr>
                      <tr>
                        <td><strong>Estado Nac.</strong></td>
                        <td id="estado"></td>
                      </tr>
                      <tr>
                        <td><strong>CURP</strong></td>
                        <td id="curp"></td>
                      </tr>
                      <tr>
                        <td><strong>IMSS</strong></td>
                        <td id="imss"></td>
                      </tr>
                      <tr>
                        <td><strong>Cuenta</strong></td>
                        <td id="cuenta"></td>
                      </tr>
                      <tr>
                        <td><strong>Perfil</strong></td>
                        <td id="perfil"></td>
                      </tr>
                      <tr>
                        <td><strong>Visa</strong></td>
                        <td id="visa"></td>
                      </tr>
                      <tr>
                        <td><strong>Telefono(s)</strong></td>
                        <td id="telefono"></td>
                      </tr>
                      <tr>
                        <td><strong>Direccion</strong></td>
                        <td id="direccion"></td>
                      </tr>
                     
                        <tr>
                        <td><strong>En caso de emergencia</strong></td>
                        <td id="contacto"></td>
                      </tr>
                    
                     
                    </tbody>
                  </table>
                  
                 </div>
              </div>

                                            <div class="row">
                                                <div class="col-12-xs text-center">
                                                    
                                                    <button class="btn btn-primary btn-m" data-dismiss="modal">Cerrar</button>
                                                </div>
                                            </div>
                                          </div>
                                    <!-- /.modal-content -->
                                </div></div>
                                <!-- /.modal-dialog Ver Datos-->
                               

                            </div>
                            <!-- /.modal Ver Datos-->

@endsection

@section('js')

    <script>
    $(document).ready(function() {
       
     var ids=[];
     var i=0;
     $("#eliminar").click(function(){
            
            //Vaciar las filas previas de la tabla
            $("#infoEliminar").html("");
            //vaciar arreglo de ids
            ids=[];
            i=0;
            // Obtenemos todos los valores contenidos en los <td> de las fila
            // seleccionadas
            $(".select:checked").parents("tr").each(function(){
               ids[i]=$(this).find("td").eq(1).html();
                $("#infoEliminar").append('<tr>'+
                                       '<td>'+$(this).find("td").eq(1).html()+'</td>'+
                                       '<td>'+$(this).find("td").eq(2).html()+'</td>'+
                                        '<td>'+$(this).find("td").eq(3).html()+'</td>'+
                                        '</tr>"');
                i++;
                });
            if(i>0)
                $('#eliminarModal').modal();
            });

     $("#lista_negra").click(function(){
            
            //Vaciar las filas previas de la tabla
            $("#infoListaNegra").html("");
            //Vaciar el arreglo de ids
            ids=[];
            i=0;
            // Obtenemos todos los valores contenidos en los <td> de las fila
            // seleccionadas
            $(".select:checked").parents("tr").each(function(){
                ids[i]=$(this).find("td").eq(1).html();
                $("#infoListaNegra").append('<tr>'+
                                       '<td>'+$(this).find("td").eq(1).html()+'</td>'+
                                       '<td>'+$(this).find("td").eq(2).html()+'</td>'+
                                        '<td>'+$(this).find("td").eq(3).html()+'</td>'+
                                    '</tr>"');
                i++;
                });
            if(i>0)
                $('#listaNegraModal').modal();
               
        });

      $("#convertir").click(function(){
            
            //Vaciar las filas previas de la tabla
            $("#infoConvertir").html("");
            //Vaciar el arreglo de ids
            ids=[];
            i=0;
            // Obtenemos todos los valores contenidos en los <td> de las fila
            // seleccionadas
            $(".select:checked").parents("tr").each(function(){
                ids[i]=$(this).find("td").eq(1).html();
                $("#infoConvertir").append('<tr>'+
                                       '<td>'+$(this).find("td").eq(1).html()+'</td>'+
                                       '<td>'+$(this).find("td").eq(2).html()+'</td>'+
                                        '<td>'+$(this).find("td").eq(3).html()+'</td>'+
                                    '</tr>"');
                i++;
                });
            if(i>0)
                $('#convertirModal').modal();
               
        });

$(".verDatos").click(function(){

        
        var id;
        $(this).parents("tr").each(function(){
                id=$(this).find("td").eq(1).html();
                
                });   
       var dataString = { 
              id : id,
              _token : '{{ csrf_token() }}'
            };
        $.ajax({
            type: "POST",
            url: "{{ URL::to('candidatos/datos') }}",
            data: dataString,
            dataType: "json",
            cache : false,
            success: function(data){
                           
              if(data){
                $("#nombre").html(data.nombre);
                $("#numeroE").html(data.id);
                $("#fecha").html(data.fecha);
                $("#estado").html(data.estado);
                $("#curp").html(data.curp);
                $("#imss").html(data.imss);
                $("#cuenta").html(data.cuenta);
                $("#perfil").html(data.perfil);
                $("#visa").html(data.visa);
                $("#telefono").html(data.telefono);
                $("#direccion").html(data.direccion);
                $("#contacto").html(data.contacto);
                if(data.foto!=null){
                    $("#fotografia").attr("src",data.foto);
                }
                else{
                    $("#fotografia").attr("src","/static/imagenes/avatar.png");
                }
                $('#verDatosModal').modal();
                
                              
              } 
          
            } ,error: function(xhr, status, error) {
              alert(error);
            },
        });
            
            });

$("#confirmacionLN").on("click",function() {
      
      $( "#load" ).show();
       var dataString = { 
              id : ids,
              _token : '{{ csrf_token() }}'
            };
        $.ajax({
            type: "POST",
            url: "{{ URL::to('candidatos/enviar/lista-negra') }}",
            data: dataString,
            dataType: "json",
            cache : false,
            success: function(data){
              $( "#load" ).hide();
             
              if(data){
                $('#listaNegraModal').modal('toggle');
                $.each(ids, function(key,value){
                    $("#"+value).remove();
                });
                
                              
              } 
          
            } ,error: function(xhr, status, error) {
              alert(error);
            },
        });
    });

$("#confirmacionEliminar").on("click",function() {
      
      $( "#load" ).show();
       var dataString = { 
              id : ids,
              _token : '{{ csrf_token() }}'
            };
        $.ajax({
            type: "POST",
            url: "{{ URL::to('candidatos/baja') }}",
            data: dataString,
            dataType: "json",
            cache : false,
            success: function(data){
              $( "#load" ).hide();
             
              if(data){
                $('#eliminarModal').modal('toggle');
                $.each(ids, function(key,value){
                    $("#"+value).remove();
                });
                              
              } 
          
            } ,error: function(xhr, status, error) {
              alert(error);
            },
        });
    });

$("#confirmacionConvertir").on("click",function() {
      
      $( "#load" ).show();
       var dataString = { 
              id : ids,
              _token : '{{ csrf_token() }}'
            };
        $.ajax({
            type: "POST",
            url: "{{ URL::to('candidatos/convertir') }}",
            data: dataString,
            dataType: "json",
            cache : false,
            success: function(data){
              $( "#load" ).hide();
             
              if(data){
                $('#convertirModal').modal('toggle');
                $.each(ids, function(key,value){
                    $("#"+value).remove();
                });
                
                              
              } 
          
            } ,error: function(xhr, status, error) {
              alert(error);
            },
        });
    });

    $("#selecTodo").click(function(){
        if($("#selecTodo").prop("checked")){
            $(".select").prop("checked", true);
        }else{
            $(".select").prop("checked", false);
        }
        
    });

  });

    </script>

    
@endsection