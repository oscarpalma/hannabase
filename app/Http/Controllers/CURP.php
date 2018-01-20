<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modelos\Estado;

class CURP{

	public function generar(Request $request){

		$curp = '';
		$vocales = ['a','e','i','o','u'];
		$consonantes = ['b','c','d','f','g','h','j','k','l','m','n','p','q','r','s','t','v','w','x','y','z'];

		$estado = Estado::find($request->input('id_estados'));
		$ap_paterno = mb_strtolower($request->input('ap_paterno'));
		$ap_paterno = $this->quitarArticulos($ap_paterno);
		$ap_materno = mb_strtolower($request->input('ap_materno'));
		$ap_materno = $this->quitarArticulos($ap_materno);
		if($ap_materno == null){
			$ap_materno = 'xx';
		}
		$nombre = mb_strtolower($request->input('nombres'));
		$nombre = $this->quitarNombresComunes($nombre);
		$nombre = $this->quitarArticulos($nombre);
		$unNombre = explode(" ", $nombre);
		$nombre = $unNombre[0];
		$fecha_nacimiento = (string)$request->input('fecha_nacimiento');


		$curp = $curp . $ap_paterno[0];

		for( $i = 1; $i < strlen($ap_paterno); $i++ ) {
		    if(in_array($ap_paterno[$i], $vocales)){
		    	$curp = $curp . $ap_paterno[$i];
		    	break;
		    }
		    if ($i == (strlen($ap_paterno)-1)){
		    	$curp = $curp . 'x';
		    }
		}

		$curp = $curp . $ap_materno[0];
		$curp = $curp . $nombre[0];
		//Cambiar palabras altisonantes
		$altisonantes = array("baca", "baka", "buei", "buey", 
			"caca", "caco", "caga", "cago", "caka", "cako", "coge", 
			"cogi", "coja", "coje", "coji", "cojo", "cola", "culo", 
			"falo", "feto", "geta", "guei", "guey", "jeta", "joto", 
			"kaca", "kaco", "kaga", "kago", "kaka", "kako", "koge", 
			"kogi", "koja", "koje", "koji", "kojo", "kola", "kulo", 
			"lilo", "loca", "loco", "loka", "loko", "mame", "mamo", 
			"mear", "meas", "meon", "miar", "mion", "moco", "moko", 
			"mula", "mulo", "naca", "naco", "peda", "pedo", "pene", 
			"pipi", "pito", "popo", "puta", "puto", "qulo", "rata", 
			"roba", "robe", "robo", "ruin", "seno", "teta", "vaca", 
			"vaga", "vago", "vaka", "vuei", "vuey", "wuei", "wuey");

		$reemplazo_altisonante = array("bxca", "bxka", "bxei", "bxey", "cxca", "cxco", 
			"cxga", "cxgo", "cxka", "cxko", "cxge", "cxgi", "cxja", 
			"cxje", "cxji", "cxjo", "cxla", "cxlo", "fxlo", "fxto", 
			"gxta", "gxei", "gxey", "jxta", "jxto", "kxca", "kxco", 
			"kxga", "kxgo", "kxka", "kxko", "kxge", "kxgi", "kxja", 
			"kxje", "kxji", "kxjo", "kxla", "kxlo", "lxlo", "lxca", 
			"lxco", "lxka", "lxko", "mxme", "mxmo", "mxar", "mxas", 
			"mxon", "mxar", "mxon", "mxco", "mxko", "mxla", "mxlo", 
			"nxca", "nxco", "pxda", "pxdo", "pxne", "pxpi", "pxto", 
			"pxpo", "pxta", "pxto", "qxlo", "rxta", "rxba", "rxbe", 
			"rxbo", "rxin", "sxno", "txta", "vxca", "vxga", "vxgo", 
			"vxka", "vxei","vxey", "wxei", "wxey");
		$curp = str_replace($altisonantes, $reemplazo_altisonante, $curp);
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
		    if ($i == (strlen($ap_paterno)-1)){
		    	$curp = $curp . 'x';
		    }
		}

		for( $i = 1; $i < strlen($ap_materno); $i++ ) {
		    if(in_array($ap_materno[$i], $consonantes)){
		    	$curp = $curp . $ap_materno[$i];
		    	break;
		    }
		    if ($i == (strlen($ap_materno)-1)){
		    	$curp = $curp . 'x';
		    }
		}

		for( $i = 1; $i < strlen($nombre); $i++ ) {
		    if(in_array($nombre[$i], $consonantes)){
		    	$curp = $curp . $nombre[$i];
		    	break;
		    }
		    if ($i == (strlen($nombre)-1)){
		    	$curp = $curp . 'x';
		    }
		}

		//siguen dos caracteres al azar

		return strtoupper($curp);
		//return strtoupper($nombre);
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
		/* palabras estipuladas en el instructivo normativo para la asignación
		de la CURP que deben ser omitidas en los nombres y apellidos en caso de que estos
		contengan alguna de estas palabras*/
		$palabras = array(" da ", " das ", " de ", " del ", " der ", " di ", " die ", " dd ", " el "," la ", 
			" los ", " las ", " le ", " les ", " mac ", " mc ", " van ", " von ", " y ", " a ");
		/* se le agrega un espacion en blanco al inicio para poder quitar una de las palabras
		anteriores si se encuentra al inicio del apellido o nombre */
		$palabra = " ".$palabra;
		/* se sustituyen cada una de las palabras a omitir por un espacio en blanco
		por si una de las palabras a omitir queda al inicio */
		$palabra = str_replace($palabras, " ", $palabra);
		/* Ya sustituidas las palabras que deben ser omitidas, se quitan los espacios
		en blanco para proceder con la generación de la CURP */
		$palabra = trim($palabra); 
		$palabra=str_replace("ñ",'x',$palabra);
		
		return $palabra; 
	} 

	function quitarNombresComunes($palabra)
	{
		$palabras = array("jose ", "maria ", "ma ", "ma. ", "j ", "j. ");
		$palabra = str_replace($palabras, "", $palabra);
		
		return $palabra;
	}
}
