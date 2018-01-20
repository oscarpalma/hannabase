<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" href="{{ asset('static/imagenes/hana.png') }}">
    <title>@yield('titulo')</title>

    <!-- Bootstrap Core CSS -->
    <link href="/static/bower_components/bootstrap/dist/css/bootstrap.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="/static/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    

    <!-- Custom CSS -->
    <link href="/static/dist/css/sb-admin-2.css" rel="stylesheet">

    

    <!-- Custom Fonts -->
    <link href="/static/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Seccion para agregar hojas de estilo en paginas especificas -->
    @yield('css')
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top barra" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
               
               <a class="" href="/"> <img src="/static/imagenes/logohorizontal.png" alt="logo crtm" class="navbar-brand"></a>
            <a class="navbar-brand" href="{{route('lista_empleados')}}" id="empleadosActivos">Empleados Activos: </a>
            </div>
            <!-- /image/.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                
               
                <li class="dropdown messages-menu" id="mensajes">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success" id='cantidad' style="position: absolute;
                top: 9px;
                right: 7px;
                text-align: center;
                font-size: 9px;
                padding: 2px 3px;
                line-height: .9;">0</span>
            </a>
                    <ul class="dropdown-menu dropdown-messages" value='0' id='notificaciones' style="width:300px; max-height:300px;overflow-y: scroll;">
                        
                       
                        
                        
                        <li class="divider quitar"></li>

                        <li>
                            <a class="text-center quitar" href="#">
                                <strong>Read All Messages</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-messages -->
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> {{Auth::user()->name}}</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="/auth/logout"><i class="fa fa-sign-out fa-fw"></i> Cerrar Sesion</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                    <!-- Acciones de Filtro if (Auth::user()->nombre == 'admin' ) -->
                       
                        <!--los roles que pueden utilizar cada opcion se agregan en el if correspondiente-->
                        @if(in_array(Auth::user()->role,['superusuario','recepcion','coordinador', 'filtro']))
                            <li>
                                <a href="##" ><i class="fa fa-eye" ></i> Filtro<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li >
                                            <a href="{{route('filtro_verificacion')}}"><i class="fa fa-binoculars"></i> Verificacion de Prospectos</a>
                                        </li>
                                         <li >
                                            <a href="{{route('filtro_credencial')}}"><i class="fa fa-credit-card" ></i> Generar Credencial</a>
                                        </li>
                                        
                                        <li >
                                        <li >
                                            <a href="{{route('subir_foto_empleado')}}"><i class="fa fa-file-image-o" ></i> Subir Fotografia</a>
                                        </li>
                                        <li >
                                            <a href="{{route('tomar_foto_empleado')}}"><i class="fa fa-instagram" ></i> Tomar Fotografia</a>
                                        </li>
                                    

                                       <li>
                                            <a href="{{route('descuento_empleado')}}"> <i class="fa fa-sort-amount-desc" ></i> Descuentos</a>
                                        </li>
                                         <li>
                                            <a href="{{route('lista_descuentos')}}"> <i class="fa fa-list" ></i> Ver descuentos</a>
                                        </li>

                                       <li>
                                            <a href="{{route('reembolso_empleado')}}"> <i class="fa fa-money" ></i> Reembolsos</a>
                                        </li>
                                </ul>
                            </li>
                        @endif
                    @if(in_array(Auth::user()->role, ['superusuario', 'administrador', 'coordinador', 'filtro']))
                    <!-- Candidatos -->
                        <li>
                            <a href="##"><i class="fa fa-male"></i> Candidatos<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                
                                    <li>
                                        <a href="{{route('registro_candidato')}}"><i class="fa fa-user"></i> Alta de Candidatos</a>
                                    </li>
                                
                                    <li >
                                        <a href="{{route('lista_candidatos')}}"><i class="fa fa-list" ></i> Listado de Candidatos</a>
                                    </li>
                           
                                <li>
                                    <a href="{{route('lista_negra')}}"> <i class="fa fa-ban" ></i> No Contratable</a>
                                </li>
                            </ul>
                        </li>
                    @endif
                        <!-- Empleados Indirectos -->
                        @if(in_array(Auth::user()->role, ['superusuario', 'administrador', 'gerente', 'coordinador', 'contabilidad', 'recepcion', 'filtro']))
                            <li>
                                <a href="##"><i class="fa fa-users"></i> Empleados<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">

                                    <li>
                                        <a href="{{route('lista_empleados')}}"> <i class="fa fa-list" ></i> Listado de Empleados</a>
                                    </li>
                                    @if(Auth::user()->role != 'filtro')
                                    <li>
                                        <a href="{{route('consultas_empleados')}}" ><i class="fa fa-filter"></i> Consultas</a>
                                    </li> 
                                    @endif

                                    @if(in_array(Auth::user()->role,['superusuario','coordinador']))
                                    <li>
                                        <a href="{{route('get_checada_empleados')}}"> <i class="glyphicon glyphicon-time" ></i> Agregar Checadas</a>
                                    </li>
                                    <li>
                                        <a href="{{route('get_checadaG_empleados')}}"><i class="glyphicon glyphicon-time" ></i> Agregar Checadas Grupales</a>
                                    </li>
                                    <li>
                                        <a href="{{route('buscar_checadas')}}"><i class="fa fa-search" ></i> Buscar Checadas</a>
                                    </li> 
                                    <li>
                                        <a href="{{route('lista_asistencia')}}"><i class="fa fa-list-alt" ></i> Generar Lista de Asistencia</a>
                                    </li>
                                    @endif
                                    @if(in_array(Auth::user()->role,['superusuario','coordinador', 'contabilidad']))
                                            
                                    <li>
                                        <a href="{{route('comedores')}}"> <i class="fa fa-cutlery" ></i> Descuentos de comedor</a>
                                    </li>
                                    
                                    <li>
                                        <a href="{{route('buscar_comedores')}}"><i class="fa fa-search" ></i> Buscar Descuentos</a>
                                    </li>    
                                    @endif

                                    @if(in_array(Auth::user()->role, ['superusuario','administrador','gerente','coordinador','contabilidad']))
                                    <li>
                                        <a href="{{route('reporte_checadas')}}"> <i class="fa fa-bar-chart" ></i> Generar Reporte</a>
                                    </li>
                                    @endif

                                    
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                        @endif
                        <!-- Personal de oficina -->

                        @if(in_array(Auth::user()->role, ['superusuario', 'administrador', 'gerente', 'contabilidad']))
                            <li>
                                <a href="##"><i class="fa fa-institution"></i>Empleados Oficina<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    @if(in_array(Auth::user()->role, ['superusuario', 'administrador', 'gerente']))
                                    <li >
                                        <a href="{{route('registro_empleado_crtm')}}"><i class="fa fa-user"></i> Alta de Empleados</a>
                                    </li>
                                    <li>
                                        <a href="{{route('lista_empleados_crtm')}}"> <i class="fa fa-list" ></i> Listado de Empleados</a>
                                    </li>
                                    <li >
                                        <a href="{{route('subir_foto_empleados_crtm')}}"><i class="fa fa-file-image-o" ></i> Subir Fotografia</a>
                                    </li>

                                    <li>
                                        <a href="{{route('consultas_empleados_crtm')}}" ><i class="fa fa-filter"></i> Consultas</a>
                                    </li> 
                                        <li>
                                            <a href="{{route('descuento_empleados_crtm')}}"><i class="fa fa-sort-amount-desc" ></i> Descuento</a>
                                        </li>
                                         <li>
                                            <a href="{{route('prestamo_empleados_crtm')}}"><i class="fa fa-money" ></i> Prestamo</a>
                                        </li> 
                                        <li>
                                            <a href="{{route('checada_empleados_crtm')}}"> <i class="glyphicon glyphicon-time" ></i> Agregar Checadas</a>
                                        </li>
                                        <li>
                                            <a href="{{route('checadaG_empleados_crtm')}}"><i class="glyphicon glyphicon-time" ></i> Agregar Checadas Grupales</a>
                                        </li>
                                         <li>
                                            <a href="{{route('buscarC_empleados_crtm')}}"><i class="fa fa-search" ></i> Buscar Checadas</a>
                                        </li>
                                        @endif
                                        <li>
                                            <a href="{{route('reporte_empleados_crtm')}}"> <i class="fa fa-bar-chart" ></i> Generar Reporte</a>
                                        </li>
                                       

                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                        @endif
                        <!-- Personal para proyectos -->

                        @if(in_array(Auth::user()->role, ['superusuario', 'administrador', 'gerente', 'contabilidad', 'filtro', 'coordinador']))
                            <li>
                                <a href="##"><i class="fa fa-institution"></i>Empleados Proyectos<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    @if(in_array(Auth::user()->role, ['superusuario', 'administrador', 'gerente', 'coordinador', 'filtro']))
                                    <li >
                                        <a href="{{route('alta_empleado_proyecto')}}"><i class="fa fa-user"></i> Alta de Empleados</a>
                                    </li>
                                    <li>
                                        <a href="{{route('lista_empleados_proyecto_get')}}"> <i class="fa fa-list" ></i> Listado de Empleados</a>
                                    </li>
                                   @endif
                                   @if(in_array(Auth::user()->role, ['superusuario', 'administrador', 'gerente', 'coordinador', 'contabilidad']))
                                    
                                        <li>
                                            <a href="{{route('alta_checada_proyecto')}}"> <i class="glyphicon glyphicon-time" ></i> Agregar Checadas</a>
                                        </li>
                                        
                                         <li>
                                            <a href="{{route('buscar_checadas_proyecto')}}"><i class="fa fa-search" ></i> Buscar Checadas</a>
                                        </li>
                                        
                                        <li>
                                            <a href="{{route('generar_reporte_proyecto')}}"> <i class="fa fa-bar-chart" ></i> Generar Reporte</a>
                                        </li>
                                      @endif 

                                </ul>
                                
                            </li>
                        @endif 
                        <!-- Clientes -->
                        @if(in_array(Auth::user()->role, ['superusuario', 'administrador', 'gerente']))
                            <li>
                                <a href="##"><i class="fa fa-suitcase"></i> Clientes<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    

                                    <li {{ (Request::is('*blank') ? 'class="active"' : '') }}>
                                        <a href="{{route('alta_cliente')}}"><i class="fa fa-plus"></i> Agregar Clientes</a>
                                    </li>
                                    <li {{ (Request::is('*blank') ? 'class="active"' : '') }}>
                                        <a href="{{route('lista_cliente')}}"><i class="fa fa-list" ></i> Listado de Clientes</a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        <!-- Clientes Proyecto -->
                        @if(in_array(Auth::user()->role, ['superusuario', 'administrador', 'gerente']))
                            <li>
                                <a href="##"><i class="fa fa-suitcase"></i> Clientes Proyecto<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    

                                    <li {{ (Request::is('*blank') ? 'class="active"' : '') }}>
                                        <a href="{{route('alta_cliente_proyecto')}}"><i class="fa fa-plus"></i> Agregar Clientes</a>
                                    </li>
                                    <li {{ (Request::is('*blank') ? 'class="active"' : '') }}>
                                        <a href="{{route('lista_cliente_proyecto')}}"><i class="fa fa-list" ></i> Listado de Clientes</a>
                                    </li>
                                </ul>
                            </li>
                        @endif 

                        <!-- Links no módificados  -->
                        @if(in_array(Auth::user()->role, ['superusuario', 'administrador', 'gerente', 'contabilidad']))
                        <!--proveedores-->
                            <li>   
                                <a href="##"><i class="fa fa-truck"></i> Proveedores<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li {{ (Request::is('*blank') ? 'class="active"' : '') }}>
                                        <a href="{{route('nuevo_proveedor')}}"><i class="fa fa-plus"></i> Agregar Proveedor</a>
                                    </li>

                                    <li {{ (Request::is('*blank') ? 'class="active"' : '') }}>
                                        <a href="{{route('lista_proveedores')}}"><i class="fa fa-list-ul"></i> Listado de proveedores</a>
                                    </li>

                                    <li {{ (Request::is('*blank') ? 'class="active"' : '') }}>
                                        <a href="{{route('proveedores_transaccion')}}"><i class="fa fa-usd"></i> Agregar transaccion</a>

                                    <li {{ (Request::is('*blank') ? 'class="active"' : '') }}>
                                        <a href="{{route('transacciones')}}"><i class="fa fa-usd"></i> Ver transacciones</a>
                                    </li>
                                    <li {{ (Request::is('*blank') ? 'class="active"' : '') }}>
                                        <a href="{{route('proveedores/reporte')}}"><i class="fa fa-bar-chart"></i> Reporte</a>
                                    </li>
                                    <li {{ (Request::is('*blank') ? 'class="active"' : '') }}>
                                        <a href="{{route('proveedores/subirTransaccion')}}"><i class="fa fa-upload" aria-hidden="true"></i> Subir Archivo</a>
                                    </li>
                                </ul>
                            </li>
                            @endif

                            <li>
                                <a href="##"><i class="fa fa-calculator"></i> Nomina<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                   
                                        <li {{ (Request::is('*blank') ? 'class="active"' : '') }}>
                                            <a href="{{route('exportar_nomina')}}"><i class="fa fa-file-text-o" ></i> Exportar Base de Datos</a>
                                        </li>
                                        <li {{ (Request::is('*blank') ? 'class="active"' : '') }}>
                                            <a href="{{route('indicadores')}}"><i class="fa fa-pie-chart" ></i> Indicadores</a>
                                        </li>
                                   
                                    
                                    
                                </ul>
                            </li> 
                        @if(in_array(Auth::user()->role, ['superusuario', 'administrador','contabilidad']))
                            <!-- Inventario -->
                            <li>   
                                <a href="##"><i class="glyphicon glyphicon-list"></i> Inventario<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li {{ (Request::is('*blank') ? 'class="active"' : '') }}>
                                        <a href="{{route('inventario_alta')}}"><i class="glyphicon glyphicon-plus"></i> Alta</a>
                                    </li>
                                     <li {{ (Request::is('*blank') ? 'class="active"' : '') }}>
                                        <a href="{{route('inventario_administrar')}}"><i class="glyphicon glyphicon-cog"></i> Administrar</a>
                                    </li>
                                     <li {{ (Request::is('*blank') ? 'class="active"' : '') }}>
                                        <a href="{{route('inventario_cantidad')}}"><i class="glyphicon glyphicon-edit"></i> Actualizar Cantidad</a>
                                    </li>
                                     <li {{ (Request::is('*blank') ? 'class="active"' : '') }}>
                                        <a href="{{route('inventario_lista')}}"><i class="glyphicon glyphicon-list"></i> Listado de Inventario</a>
                                    </li>    
                                    
                                </ul>
                            </li> 
                        @endif 

                            <!-- Fin links no modificados -->

                    @if(in_array(Auth::user()->role, ['superusuario', 'administrador', 'gerente']))
                        <li>
                                <a href="##"><i class="fa fa-wrench"></i> Administracion<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    @if(in_array(Auth::user()->role, ['superusuario', 'administrador']))
                                        <li {{ (Request::is('*blank') ? 'class="active"' : '') }}>
                                            <a href="{{route('lista_usuarios')}}"><i class="fa fa-user" ></i> Administrar usuarios</a>
                                        </li>
                                     @endif
                                        <li {{ (Request::is('*blank') ? 'class="active"' : '') }}>
                                        <a href="{{route('mensaje')}}"><i class="fa fa-paper-plane" ></i> Enviar mensaje</a>
                                        </li>
                                        <li {{ (Request::is('*blank') ? 'class="active"' : '') }}>
                                        <a href="{{route('kpi_alta_registro')}}"><i class="glyphicon glyphicon-plus"></i> Alta KPI</a>
                                    </li>
                                    <li {{ (Request::is('*blank') ? 'class="active"' : '') }}>
                                        <a href="{{route('kpi_actualizar_formato')}}"><i class="glyphicon glyphicon-refresh"></i> Actualizar Formato KPI</a>
                                    </li>
                                        <li>
                                        <a href="{{route('directorio_empleados_crtm')}}"> <i class="glyphicon glyphicon-phone-alt" ></i> Directorio</a>
                                    </li>
                                   
                                    
                                    
                                </ul>
                            </li> 
                        @endif    
                        
                        
                        
                        
                        
                        
                        
                        
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
<!-- cabezera para las secciones  -->
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">@yield('cabezera')</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="container-fluid">
            @yield('content')
            </div>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="/static/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="/static/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="/static/bower_components/metisMenu/dist/metisMenu.min.js"></script>

    

    <!-- Custom Theme JavaScript -->
    <script src="/static/dist/js/sb-admin-2.js"></script>
  

<script type="text/javascript">

$.get('/ajax-empleadosActivos', function(data) {
                    //console.log(data);

                    //Muestra los turnos segun el cliente que se ha seleccionado
                   $('#empleadosActivos').append(data.empleados);
           
              });
    var i=0;
    function get_messages() {
        $.ajax({
               type: "get",
               url: "/ajax-notificacion/",
               data: {},
               dataType: "json",
                success: function (json) {

            var cantidad=$('#notificaciones').attr('value');
            //var cantidad=0;
            
            if (cantidad<json.cantidad || i==0){
            // add messages
            //alert(json.idEmpleado);
            $('#cantidad').html(json.cantidad);
            $('#notificaciones').attr('value',json.cantidad);
            $('.quitar').remove();
            $.each(json.notificacion, function(i,m){

                //esta validacion se agrega para que solo se muestre una vista previa de cada mensaje
                var mensaje = "";
                var count = Object.keys(m.mensaje).length;
                if(count > 40){
                // si el mensaje es mayor a 75 caracteres recortarlo a 72...
                
                    for(var x=0; x < 40; x++){
                        mensaje = mensaje + m.mensaje[x];
                    }
                    //... y concatenar tres puntos al final
                    mensaje = mensaje + "...";
                }

                else{
                    //si no es mayor a 75 caracteres, mostrarlo completo
                    mensaje = m.mensaje;
                }
               //Mostrando solo fecha horas:minutos 
                var fecha = "";
                for(var x=0; x < 16; x++){
                        fecha = fecha + m.fecha[x];
                    }
            $('#notificaciones').append('<li class="quitar"><a href="/ver-mensaje-' + m.idNotificaciones +'/"><div><strong>'+m.asunto+'</strong><span class="pull-right text-muted"><em>'+fecha+'</em> </span></div><div><br>'+mensaje+' </div></a></li><li class="divider quitar"></li>');
            
            } );

            $('#notificaciones').append('<li class="quitar"><a class="text-center" href="/ver-mensajes/"><strong>Ver todos los mensajes</strong>       <i class="fa fa-angle-right"></i></a></li>');

            //i=0;
            if(i>0){
            show();
                } 
        }
            i=i+1;   
          
            
            
           
                
        }        
    });
    
    // espera un tiempo para buscar nuevas notificaciones
    setTimeout("get_messages()", 10000);
}
function show(){       
var title = "Notificaciones"
            , options = {
            body: "Tiene nuevas notificaciones",
            icon: "/static/imagenes/hana.png"
        };

        if (!("Notification" in window)) {
            alert("Sorry for this message");
        }
        else if (Notification.permission === "granted") {
            $('<audio id="audio_fb"><source src="{{ asset("static/sonidos/notificacion_windows_10.mp3") }}" type="audio/mpeg"></audio>').appendTo("body");
            var n = new Notification(title, options);
            n.onshow=function(){
                  setTimeout(n.close.bind(n), 10000); 
            }
            n.onclick = function () {
                var a = document.createElement("a");
                a.target = "_blank";
                a.href = "ver-mensajes";
                a.click();
                n.close();
            };
            $('#audio_fb')[0].play();
        }
        else if (Notification.permission !== 'denied') {
            Notification.requestPermission(function (permission) {
                if (permission === "granted") {
                    var n = new Notification(title, options);
                }
            });
        }

}
get_messages();

/* Inicia la funcion get_messages  */
$( document ).ready(function() {




$("#mensajes").click(function() {
    $.ajax({
               type: "get",
               url: "/ajax-visto/",
               data: {},
               dataType: "json",
        success: function (json) {
                          
            $('#cantidad').html(json.cantidad);
            $('#notificaciones').attr('value',json.cantidad);
        }        
    });
});





});

</script>
<script type="text/javascript">
    var $rows = $('.tabla tbody tr');
    $('#buscar').keyup(function() {
        var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
        
        $rows.show().filter(function() {
            var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
            return !~text.indexOf(val);
        }).hide();
    });

   

</script>
    <!-- Seccion para agregar scripts en paginas especificas -->
    @yield('js')
</body>

</html>