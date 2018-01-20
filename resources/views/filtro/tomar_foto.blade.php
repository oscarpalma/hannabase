@extends('base')
@section('titulo','Tomar Foto')
@section('cabezera','Tomar Foto')
@section('css')
<meta name="_token" content="{!! csrf_token() !!}" />
 

 
 
<style type="text/css">
 
#webcam, #canvas {
	/*width: 320px;
	height: 240px;*/
	width: 360px;
	height: 280px;
	border:20px solid #333;
	background:#eee;
	-webkit-border-radius: 20px;
	-moz-border-radius: 20px;
	border-radius: 20px;
}
 
#webcam {
	position:relative;
	margin-top:20px;
	margin-bottom:50px;
	margin-left:60px;
}
 
#webcam > span {
	z-index:2;
	position:absolute;
	color:#eee;
	font-size:10px;
	bottom: -16px;
	left:152px;
}
 
#webcam > img {
	z-index:1;
	position:absolute;
	border:0px none;
	padding:0px;
	bottom:-40px;
	left:89px;
}
 
#webcam > div {
	border:5px solid #333;
	position:absolute;
	right:-90px;
	padding:5px;
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
	border-radius: 8px;
	cursor:pointer;
}
 
#webcam a {
	background:#000000;
	font-weight:bold;
}
 
#webcam a > img {
	border:0px none;
}
 
#canvas {
	border:20px solid #ccc;
	background:#eee;

}
 
#flash {
	position:absolute;
	top:0px;
	left:0px;
	z-index:5000;
	width:100%;
	height:500px;
	background-color:#c00;
	display:none;
}
 
object {
	display:block; /* HTML5 fix */
	position:relative;
	z-index:1000;
	width: 320px;
	height: 240px;
	
}
 
</style>
<link rel="stylesheet" href="/static/select2/select2.css" async/>
@stop
@section('content')

		<div class="panel panel-primary">
			<div class="panel-heading"></div>
			<div class="panel-body">
			@if (count($errors) > 0)
			<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong>¡Alerta!</strong> Hubo problemas para guardar los datos<br><br>
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
			@endif
			<!--<img src='{{url(Auth::user()->foto)}}' class='img-responsive' style='max-width: 150px' />-->
			
				
					<div class="row">
					<div class="col-sm-6">
							<div class="panel-body">
							<label class="control-label">Empleado </label>
								<div >
									<select name="idEmpleado" id="empleado" class="form-control" style='text-transform:uppercase'>
										<option value="">Seleccione</option>
										@foreach($empleado as $empleado)
											<option value="{{$empleado->idEmpleado}}">{{$empleado->idEmpleado}}  -  {{$empleado->ap_paterno}} {{$empleado->ap_materno}}, {{$empleado->nombres}}</option>
										@endforeach
									</select>
								</div>
							</div>
					</div>
				    
					
					
				</div>
				<div class="row">
					<div class="col-sm-6">
							<div class="panel-body">
							 <label class="control-label" style="margin-left:60px">     Camara </label>
							 	<div id="webcam">
								</div>
							</div>
					</div>
					<div class="col-sm-6">
					<div class="panel-body">
							 <label class="control-label">     Resultado </label>
					<div>
					<br>
					<canvas id="canvas" height="240" width="320"></canvas>
					</div>
					</div>
					</div>
				</div>
				
				<div class="form-actions">
						<button type="button" class="btn btn-primary" value="validate" style="margin-right: 15px;" onclick="javascript:webcam.capture();void(0);">
							Guardar
						</button>
					</div>
				</div>
				
			
			</div>
		     

@stop

@section('js')
<script type="text/javascript">
	$(document).ready(function() {
		
		$("#empleado").select2();
		$("#success").delay(2000).hide(600);

		$(function() {

    var pos = 0, ctx = null, saveCB, image = [];

    var canvas = document.createElement("canvas");
    canvas.setAttribute('width', 320);
    canvas.setAttribute('height', 240);
    
    if (canvas.toDataURL) {

        ctx = canvas.getContext("2d");
        
        image = ctx.getImageData(0, 0, 320, 240);
    
        saveCB = function(data) {
            
            var col = data.split(";");
            var img = image;

            for(var i = 0; i < 320; i++) {
                var tmp = parseInt(col[i]);
                img.data[pos + 0] = (tmp >> 16) & 0xff;
                img.data[pos + 1] = (tmp >> 8) & 0xff;
                img.data[pos + 2] = tmp & 0xff;
                img.data[pos + 3] = 0xff;
                pos+= 4;
            }

            if (pos >= 4 * 320 * 240) {
                ctx.putImageData(img, 0, 0);
                 $('<audio id="sonido_camara"><source src="{{ asset("static/sonidos/shutter.mp3") }}" type="audio/mpeg"></audio>').appendTo("body");
                  $('#sonido_camara')[0].play();
                var canvass = document.getElementById('canvas');
				var dataURL = canvass.toDataURL();
				
				 $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
				var empleado = $("#empleado").val();

                $.post("/filtro/tomar-foto", {type: "data", image: dataURL, empleado:empleado});
                pos = 0;
            }
        };

    } else {

        saveCB = function(data) {
            image.push(data);
            
            pos+= 4 * 320;
            
            if (pos >= 4 * 320 * 240) {
                $.post("/filtro/tomar-foto", {type: "pixel", image: image.join('|'),empleado:$('#empleado')});
                pos = 0;
            }
        };
    }


var pos = 0;
var ctx = null;
var cam = null;
var image = null;
 
var filter_on = false;
var filter_id = 0;
 
function changeFilter() {
	if (filter_on) {
		filter_id = (filter_id + 1) & 7;
	}
}
 
function toggleFilter(obj) {
	if (filter_on =!filter_on) {
		obj.parentNode.style.borderColor = "#c00";
	} else {
		obj.parentNode.style.borderColor = "#333";
	}
}
 
 
jQuery("#webcam").webcam({
 
	width: 320,
	height: 240,
	mode: "callback",
    microphone: false,
	swffile: "{{ asset("static/js/jscam_canvas_only.swf") }}",
 
	onTick: function(remain) {
 
		if (0 == remain) {
			jQuery("#status").text("Cheese!");
		} else {
			jQuery("#status").text(remain + " seconds remaining...");
		}
	},
 
	onSave: saveCB,
 
		
 
	onCapture: function () {
 
		//alert("test");
		webcam.save();
 
		jQuery("#flash").css("display", "block");
		jQuery("#flash").fadeOut(100, function () {
			jQuery("#flash").css("opacity", 1);
		});
	},
 
	debug: function (type, string) {
		jQuery("#status").html(type + ": " + string);
	},
 
	onLoad: function () {
 
		var cams = webcam.getCameraList();
		for(var i in cams) {
			jQuery("#cams").append("<li>" + cams[i] + "</li>");
		}
	}
});
 
function getPageSize() {
 
	var xScroll, yScroll;
 
	if (window.innerHeight && window.scrollMaxY) {
		xScroll = window.innerWidth + window.scrollMaxX;
		yScroll = window.innerHeight + window.scrollMaxY;
	} else if (document.body.scrollHeight > document.body.offsetHeight){ // all but Explorer Mac
		xScroll = document.body.scrollWidth;
		yScroll = document.body.scrollHeight;
	} else { // Explorer Mac...would also work in Explorer 6 Strict, Mozilla and Safari
		xScroll = document.body.offsetWidth;
		yScroll = document.body.offsetHeight;
	}
 
	var windowWidth, windowHeight;
 
	if (self.innerHeight) { // all except Explorer
		if(document.documentElement.clientWidth){
			windowWidth = document.documentElement.clientWidth;
		} else {
			windowWidth = self.innerWidth;
		}
		windowHeight = self.innerHeight;
	} else if (document.documentElement && document.documentElement.clientHeight) { // Explorer 6 Strict Mode
		windowWidth = document.documentElement.clientWidth;
		windowHeight = document.documentElement.clientHeight;
	} else if (document.body) { // other Explorers
		windowWidth = document.body.clientWidth;
		windowHeight = document.body.clientHeight;
	}
 
	// for small pages with total height less then height of the viewport
	if(yScroll < windowHeight){
		pageHeight = windowHeight;
	} else {
		pageHeight = yScroll;
	}
 
	// for small pages with total width less then width of the viewport
	if(xScroll < windowWidth){
		pageWidth = xScroll;
	} else {
		pageWidth = windowWidth;
	}
 
	return [pageWidth, pageHeight];
}
 
window.addEventListener("load", function() {
 
	jQuery("body").append("<div id=\"flash\"></div>");
 
	var canvas = document.getElementById("canvas");
 
	if (canvas.getContext) {
		ctx = document.getElementById("canvas").getContext("2d");
		ctx.clearRect(0, 0, 320, 240);
 
		var img = new Image();
		img.src = "/static/logo.gif";
		img.onload = function() {
			ctx.drawImage(img, 129, 89);
		}
		image = ctx.getImageData(0, 0, 320, 240);
	}
 
	var pageSize = getPageSize();
	jQuery("#flash").css({ height: pageSize[1] + "px" });
 
}, false);
 
window.addEventListener("resize", function() {
 
	var pageSize = getPageSize();
	jQuery("#flash").css({ height: pageSize[1] + "px" });
 
}, false);
 });
	});

</script>
<script src="{{ asset("static/select2/select2.js") }}" type="text/javascript"></script>

<script type="text/javascript" src="{{ asset("static/js/jquery.webcam.min.js") }}"></script>

@stop