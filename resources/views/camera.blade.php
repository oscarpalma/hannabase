@extends('layouts.dashboard')
@section('page_heading','Tomar Fotografia')
@section('head')
<meta name="_token" content="{!! csrf_token() !!}" />
 

 
 
<style type="text/css">
 
#webcam, #canvas {
	width: 320px;
	height: 240px;
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
	
}
 
</style>
 

<script type="text/javascript" src="{{ asset("assets/scripts/jquery.webcam.min.js") }}"></script>
@stop
@section('section')
  <div class="container-fluid">
	<div class="row">
		<div class="panel panel-primary">
			<div class="panel-heading"><strong>Agregar Foto</strong></div>
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
			<form class="form-horizontal" role="form" method="POST" action="#" id="registro-form" data-parsley-validate="" enctype='multipart/form-data'>
				<input type="hidden" name="_token" value="{{ csrf_token() }}">	
				<div class="row">
					<div class="col-sm-12">
						<label class="control-label">Seleccione a un empleado y cargue una imagen desde su ordenador.</label>
					</div>
				</div>
					<div class="row">
					<div class="col-sm-6">
							<div class="panel-body">
							<label class="control-label">Empleado </label>
								<div >
									<select name="idEmpleado" id="empleado" class="form-control" style='text-transform:uppercase'>
										@foreach($empleado as $empleado)
											<option value="{{$empleado->idEmpleado}}">{{$empleado->idEmpleado}}  -  {{$empleado->ap_paterno}} {{$empleado->ap_materno}}, {{$empleado->nombres}}</option>
										@endforeach
									</select>
								</div>
							</div>
					</div>
				    
					<div class="col-sm-6">
							<div class="panel-body">
							 <label class="control-label">Foto </label>
							 	<div >
									<p id="status" style="height:22px; color:#c00;font-weight:bold;"></p>
 
	<div id="webcam">
	</div>
								</div>
							</div>
					</div>
					
				</div>
				
				<div class="form-group">
				    <center>
						<button type="submit" class="btn btn-primary" value="validate" style="margin-right: 15px;">
							Guardar
						</button>
					</center>
				</div>
				
			</form>
			<!--Fin de Forma -->
			</div>
		</div>
	</div>
</div>      
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$("#empleado").select2();

	
	});
</script>

 
<div id="wrap">
	<div id="main" style="float:left">
 
	
 
	<!-- <p id="status" style="height:22px; color:#c00;font-weight:bold;"></p>
 
	<div id="webcam">
	</div> -->
 
	<!-- <p style="width:360px;text-align:center; "><a href="javascript:webcam.capture(3);changeFilter();void(0);">Take a picture after 3 seconds</a> | <a href="javascript:webcam.capture();void(0);">Take a picture instantly</a></p> -->
 
	<p><canvas id="canvas" height="240" width="320"></canvas></p>
  <!-- <button onclick="guardar();">ver</button>
	<h3>Available Cameras</h3>
 
	<ul id="cams"></ul> -->
 
<script type="text/javascript">
 




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
                var canvass = document.getElementById('canvas');
				var dataURL = canvass.toDataURL();
				
				 $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
                $.post("/ajax-foto-credencial/", {type: "data", image: dataURL});
                pos = 0;
            }
        };

    } else {

        saveCB = function(data) {
            image.push(data);
            
            pos+= 4 * 320;
            
            if (pos >= 4 * 320 * 240) {
                $.post("/foto-credencial/", {type: "pixel", image: image.join('|')});
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
	swffile: "{{ asset("assets/scripts/jscam_canvas_only.swf") }}",
 
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
</script>
 
</div>
</div>
 
@stop