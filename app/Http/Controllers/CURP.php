<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Estado;

class CURP{

	public function generar(Request $request){

		$curp = '';
		$vocales = ['a','e','i','o','u'];
		$consonantes = ['b','c','d','f','g','h','j','k','l','m','n','ñ','p','q','r','s','t','v','w','x','y','z'];

		$estado = Estado::find($request->input('id_estados'));
		$ap_paterno = strtolower($request->input('ap_paterno'));
		$ap_paterno = $this->quitarArticulos($ap_paterno);
		$ap_materno = strtolower($request->input('ap_materno'));
		$ap_materno = $this->quitarArticulos($ap_materno);
		if($ap_materno == null){
			$ap_materno = 'xx';
		}
		$nombre = strtolower($request->input('nombres'));
		$nombre = $this->quitarNombresComunes($nombre);
		$nombre = $this->quitarArticulos($nombre);
		$fecha_nacimiento = (string)$request->input('fecha_nacimiento');


		$curp = $curp . $ap_paterno[0];

		for( $i = 1; $i < strlen($ap_paterno); $i++ ) {
		    if(in_array($ap_paterno[$i], $vocales)){
		    	$curp = $curp . $ap_paterno[$i];
		    	break;
		    }
		}

		$curp = $curp . $ap_materno[0];
		$curp = $curp . $nombre[0];

		//agregar fecha de nacimiento en formato AAMMDD
		$curp = $curp . $fecha_nacimiento[2] . $fecha_nacimiento[3] . $fecha_nacimiento[5] . $fecha_nacimiento[6] . $fecha_nacimiento[8] .$fecha_nacimiento[9];

		if($request->input('genero') == 'masculino'){
			$curp = $curp . 'h';
		}
		else{
			$curp = $curp . 'm';
		}

		$curp = $curp . $estado->abreviacion;

		for( $i = 1; $i < strlen($ap_paterno); $i++ ) {
		    if(in_array($ap_paterno[$i], $consonantes)){
		    	$curp = $curp . $ap_paterno[$i];
		    	break;
		    }
		}

		for( $i = 1; $i < strlen($ap_materno); $i++ ) {
		    if(in_array($ap_materno[$i], $consonantes)){
		    	$curp = $curp . $ap_materno[$i];
		    	break;
		    }
		}

		for( $i = 1; $i < strlen($nombre); $i++ ) {
		    if(in_array($nombre[$i], $consonantes)){
		    	$curp = $curp . $nombre[$i];
		    	break;
		    }
		}

		//siguen dos caracteres al azar

		return strtoupper($curp);
	}

	public function validar(Request $request, $curpGenerada){
		$curp = strtoupper($request->input('curp'));
		for( $i = 0; $i < strlen($curpGenerada); $i++){
			if (!($curp[$i] == $curpGenerada[$i] || ($curp[$i] == 'X' && $curpGenerada[$i] == 'N'))){
				return false;
			}
		}
		return true;
	}


	function quitarArticulos($palabra) 
	{ 
		$palabra=str_replace("del ","",$palabra); 
		$palabra=str_replace("las ","",$palabra); 
		$palabra=str_replace("de ","",$palabra); 
		$palabra=str_replace("la ","",$palabra); 
		$palabra=str_replace("y ","",$palabra); 
		$palabra=str_replace("a ","",$palabra); 
		$palabra=str_replace("ñ",'x',$palabra);
		return $palabra; 
	} 

	function quitarNombresComunes($palabra)
	{
		$palabra = str_replace("jose ","",$palabra);
		$palabra = str_replace("maria ", "", $palabra);
		return $palabra;
	}
}
