@extends('layouts.plane')

@section('body')
 <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top barra" role="navigation" style="margin-bottom: 0; ">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ url ('') }}">Centro de Trabajo</a>
                <a class="navbar-brand" href="{{route('mostrar_empleados')}}" id="empleados">Empleados Activos: </a>
            </div>
           
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">


            <!--correos-->
           
                    <li class="dropdown messages-menu" id="mensajes">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success" id='cantidad' style="position: absolute;
    top: 9px;
    right: 7px;
    text-align: center;
    font-size: 9px;
    padding: 2px 3px;
    line-height: .9;"></span>
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

                

                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> {{ Auth::user()->nombre }}   <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="{{route('usuario')}}"><i class="fa fa-user fa-fw"></i>Perfil</a>
                        </li>
                       
                        <li class="divider"></li>
                        <li><a href="{{ route('logout') }}"><i class="fa fa-sign-out fa-fw"></i>Salir</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation" style="">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <!-- Acciones de Filtro if (Auth::user()->nombre == 'admin' ) -->
                       
                        <!--los roles que pueden utilizar cada opcion se agregan en el if correspondiente-->
                        @if(in_array(Auth::user()->role,['filtro','administrador','recepcion','enfermeria','supervisor']))
                            <li>
                                <a href="#" ><i class="fa fa-eye" ></i> Filtro<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    @if(in_array(Auth::user()->role, ['administrador','recepcion','filtro']))
                                        <li >
                                            <a href="{{route('filtro_verificacion')}}"><i class="fa fa-binoculars"></i> Verificacion de Prospectos</a>
                                        </li>
                                    @endif

                                    @if(Auth::user()->role == 'enfermeria' || Auth::user()->role == 'administrador')
                                        <li >
                                            <a href="{{route('filtro_examen_medico')}}"><i class="fa fa-heartbeat" ></i> Examen Medico</a>
                                        </li>
                                    @endif

                                    @if(in_array(Auth::user()->role, ['administrador','recepcion','supervisor']))
                                        <li >
                                            <a href="{{route('filtro_credencial')}}"><i class="fa fa-credit-card" ></i> Generar Credencial</a>
                                        </li>
                                        <li >
                                            <a href="{{route('foto-credencial')}}"><i class="fa fa-file-image-o" ></i> Subir Fotografia</a>
                                        </li>
                                        <li >
                                            <a href="{{route('tomar-foto')}}"><i class="fa fa-instagram" ></i> Tomar Fotografia</a>
                                        </li>
                                    @endif

                                    @if(in_array(Auth::user()->role,['administrador','supervisor','recepcion','contabilidad']))
                                        <li>
                                            <a href="{{route('filtro_descuentos')}}"> <i class="fa fa-sort-amount-desc" ></i> Descuentos</a>
                                        </li>
                                    @endif

                                    @if(in_array(Auth::user()->role, ['administrador','recepcion','contabilidad']))
                                         <li>
                                            <a href="{{route('filtro_reembolsos')}}"> <i class="fa fa-money" ></i> Reembolsos</a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif
                       
                       
                        <!-- Acciones con Candidatos  -->
                        <li >
                            <a href="#"><i class="fa fa-male"></i> Candidatos<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                @if(in_array(Auth::user()->role,['administrador','supervisor','recepcion']))
                                    <li >
                                        <a href="{{route('registro_empleado')}}"><i class="fa fa-user-plus"></i> Alta de Candidatos</a>
                                    </li>
                                @endif

                                @if(in_array(Auth::user()->role, ['administrador', 'supervisor','contabilidad','recepcion']))
                                    <li >
                                        <a href="{{route('mostrar_candidatos')}}"><i class="fa fa-list" ></i> Listado de Candidatos</a>
                                    </li>
                                @endif
                                <li>
                                    <a href="{{route('lista_negra')}}"> <i class="fa fa-user-times" ></i> No Contratable</a>
                                </li>
                            </ul>
                        </li>
                        <!-- Empleados Directos -->
                        @if(in_array(Auth::user()->role,['administrador','supervisor','recepcion','contabilidad']))
                            <li>
                                <a href="#"><i class="fa fa-users"></i> Empleados<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="{{route('mostrar_empleados')}}"> <i class="fa fa-list" ></i> Listado de Empleados</a>
                                    </li>

                                    <li>
                                        <a href="{{route('buscar_empleados')}}" ><i class="fa fa-filter"></i> Consultas</a>
                                    </li> 

                                    @if(in_array(Auth::user()->role,['administrador','supervisor']))
                                    <li>
                                        <a href="{{route('nuevaChecada')}}"> <i class="fa fa-plus" ></i> Agregar Checadas</a>
                                    </li>
                                    <li>
                                        <a href="{{route('nuevaChecadaGrupal')}}"><i class="fa fa-tasks" ></i> Agregar Checadas Grupales</a>
                                    </li>
                                    <li>
                                        <a href="{{route('lista_asistencia')}}"><i class="fa fa-list-alt" ></i> Generar Lista de Asistencia</a>
                                    </li>
                                    @endif

                                    @if(in_array(Auth::user()->role, ['administrador','supervisor','contabilidad']))
                                    <li>
                                        <a href="{{route('reporte')}}"> <i class="fa fa-bar-chart" ></i> Generar Reporte</a>
                                    </li>
                                    <li>
                                        <a href="{{route('buscar_comedores')}}"> <i class="fa fa-cutlery" ></i> Ver descuentos de comedor</a>
                                    </li> 
                                    @endif

                                    @if(in_array(Auth::user()->role,['administrador','supervisor']))
                                    <li>
                                        <a href="{{route('buscar_checadas')}}"><i class="fa fa-search" ></i> Buscar Checadas</a>
                                    </li>         
                                    <li>
                                        <a href="{{route('comedores')}}"> <i class="fa fa-cutlery" ></i> Descuentos de comedor</a>
                                    </li> 
<li>
                                        <a href="{{route('buscar_descuentos')}}"><i class="fa fa-search" ></i> Buscar Descuentos</a>
                                    </li>  
                                    @endif
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                        @endif
                        <!-- Personal de oficina -->

                        @if(in_array(Auth::user()->role, ['administrador','recepcion','contabilidad']))
                            <li>
                                <a href="#"><i class="fa fa-home"></i><i class="fa fa-child"></i>Empleados Oficina<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li >
                                        <a href="{{route('registro_empleado_ct')}}"><i class="fa fa-user-plus"></i> Alta de Empleados</a>
                                    </li>
                                    <li>
                                        <a href="{{route('mostrar_empleados_ct')}}"> <i class="fa fa-list" ></i> Listado de Empleados</a>
                                    </li>

                                    <li >
                                        <a href="{{route('foto-ct')}}"><i class="fa fa-file-image-o" ></i> Subir Fotografia</a>
                                    </li>

                                    @if(in_array(Auth::user()->role, ['administrador','contabilidad','recepcion']))
                                        <li>
                                            <a href="{{route('agregar_checada_ct')}}"> <i class="fa fa-plus" ></i> Agregar Checadas</a>
                                        </li>
                                        <li>
                                            <a href="{{route('checada_grupal_ct')}}"><i class="fa fa-tasks" ></i> Agregar Checadas Grupales</a>
                                        </li>
                                        <li>
                                            <a href="{{route('reporte_ct')}}"> <i class="fa fa-bar-chart" ></i> Generar Reporte</a>
                                        </li>
                                        <li>
                                            <a href="{{route('buscar_checada_ct')}}"><i class="fa fa-search" ></i> Buscar Checadas</a>
                                        </li> 
                                        <li>
                                            <a href="{{route('descuento-empleado')}}"><i class="fa fa-sort-amount-desc" ></i> Descuento</a>
                                        </li>
                                         <li>
                                            <a href="{{route('prestamo-empleado')}}"><i class="fa fa-money" ></i> Prestamo</a>
                                        </li>    
                                    @endif        
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                        @endif
                        <!-- Clientes -->
                        @if(Auth::user()->role == 'administrador')
                            <li>
                                <a href="#"><i class="fa fa-suitcase"></i> Clientes<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li {{ (Request::is('*blank') ? 'class="active"' : '') }}>
                                        <a href="{{route('mostrar_clientes')}}"><i class="fa fa-list" ></i> Listado de Clientes</a>
                                    </li>

                                    <li {{ (Request::is('*blank') ? 'class="active"' : '') }}>
                                        <a href="{{route('agregar_cliente')}}"><i class="fa fa-plus"></i> Agregar Clientes</a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                            <!--opciones para manejar usuarios de la plataforma-->
                        @if(in_array(Auth::user()->role, ['administrador','contabilidad']))
                            <!--proveedores-->
                            <li>   
                                <a href="#"><i class="fa fa-truck"></i> Proveedores<span class="fa arrow"></span></a>
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

                            <li>
                                <a href="#"><i class="fa fa-wrench"></i> Administracion<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    @if(Auth::user()->role == 'administrador')
                                        <li {{ (Request::is('*blank') ? 'class="active"' : '') }}>
                                            <a href="{{route('lista_usuarios')}}"><i class="fa fa-user" ></i> Administrar usuarios</a>
                                        </li>
                                    @endif
                                    
                                    <li {{ (Request::is('*blank') ? 'class="active"' : '') }}>
                                        <a href="{{route('mensaje')}}"><i class="fa fa-paper-plane" ></i> Enviar mensaje</a>
                                    </li>
                                </ul>
                            </li>                  
                        @endif
 @if(in_array(Auth::user()->role, ['administrador','contabilidad']))
 <li>
                                <a href="#"><i class="fa fa-calculator"></i> Nomina<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                   
                                        <li {{ (Request::is('*blank') ? 'class="active"' : '') }}>
                                            <a href="{{route('exportar_nomina')}}"><i class="fa fa-file-text-o" ></i> Exportar Base de Datos</a>
                                        </li>
                                        <li {{ (Request::is('*blank') ? 'class="active"' : '') }}>
                                            <a href="{{route('indicadores')}}"><i class="fa fa-pie-chart" ></i> Indicadores</a>
                                        </li>
                                   
                                    
                                    
                                </ul>
                            </li>    
 @endif 
                    </ul>
                    <!-- /. navbar-collapse -->
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
			 <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">@yield('page_heading')</h1>
                </div>
                <!-- /.col-lg-12 -->
           </div>
			<div class="row">  
				@yield('section')

            </div>
            <!-- /#page-wrapper -->
        </div>
    </div>
@stop