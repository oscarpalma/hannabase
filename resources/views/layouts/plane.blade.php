<!DOCTYPE html>

<html lang="en" class="no-js">

<head>
	<meta charset="utf-8"/>
<meta name="google-site-verification" content="F6J7Ji8lhy7PD7MOMWIgpKx9aWUWUP3RibwX8dURRHc" />
	<title>Centro de Trabajo </title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1" name="viewport"/>
	<meta content="" name="description"/>
	<meta content="" name="author"/>
        <link rel="icon" type="image/png" href="{{ asset('imagenes/logo.png') }}">

	<link rel="stylesheet" href="{{ asset('assets/stylesheets/styles.css') }}" async/>
	
   <script src="{{ asset("assets/scripts/jquery1.9.js") }}"></script>
   
    


<style type="text/css">
    
    .tabla {
        max-height:500px;overflow-y: scroll;
    }
</style>
@yield('head')

</head>
<body>

	@yield('body')
	
<script type="text/javascript">

$.get('/ajax-empleadosActivos', function(data) {
                    //console.log(data);

                    //Muestra los turnos segun el cliente que se ha seleccionado
                   $('#empleados').append(data.empleados);
           
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
            animar();
                } 
        }
            i=i+1;   
          
            
            
           
                
        }        
    });
    
    // espera un tiempo para buscar nuevas notificaciones
    setTimeout("get_messages()", 10000);
}


/* Inicia la funcion get_messages  */
$( document ).ready(function() {


function show(){       
var title = "Notificaciones"
            , options = {
            body: "Tiene nuevas notificaciones",
            icon: "/imagenes/logo.png"
        };

        if (!("Notification" in window)) {
            alert("Sorry for this message");
        }
        else if (Notification.permission === "granted") {
            $('<audio id="audio_fb"><source src="{{ asset("assets/sonidos/notificacion_windows_10.mp3") }}" type="audio/mpeg"></audio>').appendTo("body");
            var n = new Notification(title, options);
            n.onshow=function(){
                  setTimeout(n.close.bind(n), 10000); 
            }
            n.onclick = function () {
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

$("#mensajes").click(function() {
    detener();
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

function animar(){
   
    
    /*========================================================*/
    /* Trigger Examples
    /*========================================================*/
    $('#mensajes').jrumble();
    
    
    
    var demoStart = function(){
        $('#mensajes').trigger('startRumble');
        setTimeout(demoStop, 5000);
    };
    
    var demoStop = function(){
        $('#mensajes').trigger('stopRumble');
        //setTimeout(demoStart, 300);
    };
    
    demoStart();        
    
    /*========================================================*/
    /* Source Toggling
    /*========================================================*/
    $('.view-source pre').hide();
    $('.view-source a').toggle(function(){
    $(this).css({'background': '#ddd', 'color': '#666', 'text-shadow': '1px 1px 0 #eee'}).siblings('pre').stop(false, true).slideDown(500);
    $(this).html('Hide Source');
    }, function(){
    $(this).css({'background': '#bbb','color': '#fff', 'text-shadow': '-1px 1px 0px rgba(0,0,0,.2)'}).siblings('pre').stop(false, true).slideUp(500);
    $(this).html('View Source');
    });
}
function detener(){
var demoStop = function(){
        $('#mensajes').trigger('stopRumble');
        //setTimeout(demoStart, 300);
    };
    
    demoStop();    

}

get_messages();

});

</script>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-87908076-1', 'auto');
  ga('send', 'pageview');

</script>

 <script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
<!-- <script src="{{ asset("assets/scripts/jquery.jrumble.1.3.min.js") }}"></script> -->
<script src="{{ asset("assets/scripts/prettify.js") }}"></script>
 @yield('scripts')
 
</body>

</html>