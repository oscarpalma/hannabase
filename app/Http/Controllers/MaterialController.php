<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Modelos\Inventario;
use App\Modelos\BajasInventario;
use App\Modelos\MaterialSistemas;
use App\Modelos\AreaInventario;
use Auth;
use Validator;
use DateTime;

class MaterialController extends Controller {

	
	public function alta_get()
	{
		
			$areas = AreaInventario::all();
			return view('inventario/alta_inventario')->with('areas',$areas);
			
	}

	
	
	public function alta_post(Request $request)
	{
		
		
			$rules = ['image' => 'image|max:1024*1024*1',];
        $messages = [
            
            'image.image' => 'Formato no permitido',
            'image.max' => 'El máximo permitido es 1 MB',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ($validator->fails()){
            return redirect('inventario/alta')->withErrors($validator);
        }
        else{

        	$area= $request->input('area');
        	$precioUnitario = $request->input('precio');
        	$unidades = $request->input('unidades');
        	$fecha = new DateTime();
			$material = new Inventario([
				'nombre' => strtoupper($request->input('nombre')),
				'marca' => strtoupper( $request->input('marca')),
				'modelo' => strtoupper( $request->input('modelo')),
				'descripcion' => $request->input('descripcion'),
				'accesorios' => $request->input('accesorios'),
				'estado' => $request->input('estado'),
				'unidades' => $unidades,
				'area' => $area,
				'fecha' => $fecha,
				]);
			if($precioUnitario!=""){
				$material->precioUnitario = $precioUnitario;
				$total = $precioUnitario*$unidades;

				$material->precioTotal = $total;
			}

			$material->save();
            $material->codigoBarras = $material->id.$area.$fecha->format('d').$fecha->format('m').$fecha->format('y');
            if($request->file('image')!=null){
	        	//Cambiar nombre de foto para que no se repitan
	            $name = $material->codigoBarras . '-' . $request->file('image')->getClientOriginalExtension();
	            //guardar foto en disco local
	            \Storage::disk('fotosInventario')->put($name,  \File::get($request->file('image')));
	            
	            $material->foto = $name;
        	}
            $material->save();
            
            if($area==7 and $request->input('tipo')=='computadora'){
            	
            	if ($request->input('antivirus')) {
					   $antivirus=1;
					} else {
					   $antivirus=0;
					}
				$materialSistemas = new MaterialSistemas([
						'idMaterial' => $material->id,
						'antivirus' => $antivirus,
						'contrasena' => $request->input('password'),

					]);

				$materialSistemas->save();
			}

			return redirect()->route('inventario_alta')->with('success','Registro exitoso');
        }

			

			
			
	}

	public function administrar_get()
	{
		
			$areas = AreaInventario::all();
			return view('inventario/administrar')->with('areas',$areas);
			
	}

	public function administrar_post(Request $request)
	{
		
			$codigo = $request->input('codigo');
			$material = Inventario::where('codigoBarras',$codigo)->first();
			if ($material){
				$arr['id'] = $material->id;
				$arr['nombre'] = $material->nombre;
				$arr['marca'] = $material->marca;
				$arr['modelo'] = $material->modelo;
				$arr['descripcion'] = $material->descripcion;
				$arr['accesorios'] = $material->accesorios;
				$arr['unidades'] = $material->unidades;
				$arr['precio'] = $material->precioUnitario;
				$arr['estado'] = $material->estado;
				$arr['area'] = $material->area;
				if($material->foto != null)
					$arr['foto'] = "/storage/fotos/inventario/" . $material->foto;
				else
					$arr['foto'] = "/static/imagenes/inventario.png";
				if ($material->area==7){
					$materialSistemas = MaterialSistemas::where('idMaterial',$material->id)->first();
					if($materialSistemas){
						$arr['contrasena'] = $materialSistemas->contrasena;
						$arr['antivirus'] = $materialSistemas->antivirus;
					}else{
						$arr['otros']= true;
					}
				}	
				return json_encode($arr);
			}
			return json_encode(false);
		
	}

	public function cantidad_get()
	{
				
			return view('inventario/modificar_cantidad');
			
	}

	public function cantidad_post(Request $request)
	{
		
			$codigo = $request->input('codigo');
			$cantidad = $request->input('cantidad');
			$opcion = $request->input('opcion');

			$material = Inventario::where('codigoBarras',$codigo)->first();

			if($material){
				$unidades=$material->unidades;
				$precioUnitario = $material->precioUnitario;
				if($opcion=='aumentar'){
					$cantidad+=$unidades;
					$total=$cantidad*$precioUnitario;

					$material->unidades = $cantidad;
					$material->precioTotal = $total;

				}elseif($opcion=='disminuir'){
					if($cantidad<=$unidades){
						$cantidad=$unidades-$cantidad;
						$total=$cantidad*$precioUnitario;

						$material->unidades = $cantidad;
						$material->precioTotal = $total;

						$bajas = BajasInventario::where('semana',date('W'))->where('material',$material->id)->first();
						if($bajas!=null){
							$bajas->bajas = $bajas->bajas + $request->input('cantidad');
							$bajas->save();
						}else{
							BajasInventario::insert(['material' => $material->id, 'bajas' => $request->input('cantidad'), 'semana'=>date('W')]);
						}
					}else{
						$arr['excedente'] = "La cantidad ingresada excede la cantidad existente ".$unidades;
						return json_encode($arr);
					}
				}
				$material->save();

				$arr['nombre'] = $material->nombre;
				$arr['marca'] = $material->marca;
				$arr['cantidad']=$material->unidades;

				return json_encode($arr);
			}else
				return json_encode(false);
			
			return view('inventario/modificar_cantidad');
			
	}

	

	public function mostrarInventario_get()
	{
		return view('inventario/lista_inventario')->with('areas',AreaInventario::all());

	}

	public function mostrarInventario_post(Request $request)
	{
		$area = $request->input('area');

		if($area == 'todas'){
			$inventario1=Inventario::all();
		}else{
			$inventario1=Inventario::where('area',$area)->get();
		}

		## Obtener datos para exportar a excel
		$areas_inventario = AreaInventario::all();

		//Obtener fechas de los dias de la semana anterior
		$fecha_actual = new DateTime();
		$fechaInicioSemana = date('Y-m-d', strtotime($fecha_actual->format('Y') . 'W' . str_pad($fecha_actual->format('W')-1 , 2, '0', STR_PAD_LEFT)));
		$fechas[1] = $fechaInicioSemana;
		$fechas[2] = date('Y-m-d', strtotime($fechaInicioSemana.' 1 day')); //Martes
		$fechas[3] = date('Y-m-d', strtotime($fechaInicioSemana.' 2 day')); //Miercoles
		$fechas[4] = date('Y-m-d', strtotime($fechaInicioSemana.' 3 day')); //Jueves
		$fechas[5] = date('Y-m-d', strtotime($fechaInicioSemana.' 4 day')); //Viernes
		$fechas[6] = date('Y-m-d', strtotime($fechaInicioSemana.' 5 day')); //Sabado

		$inventario= array();
		foreach ($areas_inventario as $area) {
			$inv_area['area']=$area->nombre;
			$inv_area['inventario']=Inventario::where('area',$area->idArea)->get();
			$inv_area['totalArea']=Inventario::where('area',$area->idArea)->sum('precioTotal');
			$inv_area['totalAnterior'] = Inventario::where('fecha','<=',$fechas[6])->where('area',$area->idArea)->sum('precioTotal');
			array_push($inventario, $inv_area);
     	}

     	$altas = 0;
        for ($i=1; $i < 7; $i++) { 
        	$altas += Inventario::whereRaw("CAST( fecha AS DATE) = '". $fechas[$i]."'")->count();
        	
        }
        $total_actual = Inventario::sum('precioTotal');
        $total_anterior = Inventario::where('fecha','<=',$fechas[6])->sum('precioTotal');
        $bajas = BajasInventario::where('semana',date('W')-1)->sum('bajas');
        $semana_corte = $fecha_actual->format('W')-1;
        $date = date('d-m-Y');

		return view('inventario/lista_inventario')->with('inventario1',$inventario1)->with('areas',AreaInventario::all())->with('total_actual',$total_actual)->with('total_anterior',$total_anterior)->with('bajas',$bajas)->with('semana_corte',$semana_corte)->with('date',$date)->with('altas',$altas)->with('inventario',$inventario);

		
	}

	public function eliminar($id)
	{
		return view('inventario/eliminar')->with('inventario',Inventario::find($id));
	}

	public function actualizar_post(Request $request)
	{
		
			$area= $request->input('area');
        	$precioUnitario = $request->input('precio');
        	$unidades = $request->input('unidades');
        	$fecha = new DateTime();
        	$material = Inventario::find($request->input('id'));
			
			$material->nombre = strtoupper($request->input('nombre'));
			$material->marca = strtoupper( $request->input('marca'));
			$material->modelo = strtoupper( $request->input('modelo'));
			$material->descripcion = $request->input('descripcion');
			$material->accesorios = $request->input('accesorios');
			$material->estado = $request->input('estado');
			$material->unidades = $unidades;
			$material->area = $area;
				
			
			if($precioUnitario!=""){
				$material->precioUnitario = $precioUnitario;
				$total = $precioUnitario*$unidades;

				$material->precioTotal = $total;
			}


        	

            $material->save();
           //$material->codigoBarras = $material->id.$area.$fecha->format('d').$fecha->format('m').$fecha->format('y');
            //$material->save();
            if($area==7 and $request->input('tipo')=='computadora'){
            	
            	if ($request->input('antivirus')) {
					   $antivirus=1;
					} else {
					   $antivirus=0;
					}
				$materialSistemas = MaterialSistemas::where('idMaterial',$material->id)->first();
				if($materialSistemas){
					
							$materialSistemas->idMaterial = $material->id;
							$materialSistemas->antivirus = $antivirus;
							$materialSistemas->contrasena = $request->input('password');

						
				}else{
					$materialSistemas = new MaterialSistemas([
							'idMaterial' => $material->id,
							'antivirus' => $antivirus,
							'contrasena' => $request->input('password'),

						]);
				}

				$materialSistemas->save();

				
			}
			return json_encode(true);
			
			
			
	}
	

	
	public function destroy($id)
	{
		//
		$inventario=Inventario::find($id);
		$inventario->delete();
		return redirect()->route('inventario_lista')->with('success','material eliminado');
	}
	## CREAR PDF ##
	public function crearPDF($datos,$vistaurl,$tipo)
    {

        $data = $datos;
        $date = date('d-m-Y');
        ## Obtener cantidad de articulos dados de alta la semana anterior
        $fecha_actual = new DateTime();
    	$fechaInicioSemana = date('Y-m-d', strtotime($fecha_actual->format('Y') . 'W' . str_pad($fecha_actual->format('W')-1 , 2, '0', STR_PAD_LEFT)));
        $fechas[1] = $fechaInicioSemana;
        $fechas[2] = date('Y-m-d', strtotime($fechaInicioSemana.' 1 day')); //Martes
		$fechas[3] = date('Y-m-d', strtotime($fechaInicioSemana.' 2 day')); //Miercoles
		$fechas[4] = date('Y-m-d', strtotime($fechaInicioSemana.' 3 day')); //Jueves
		$fechas[5] = date('Y-m-d', strtotime($fechaInicioSemana.' 4 day')); //Viernes
		$fechas[6] = date('Y-m-d', strtotime($fechaInicioSemana.' 5 day')); //Sabado
		
        $altas = 0;
        for ($i=1; $i < 7; $i++) { 
        	$altas += Inventario::whereRaw("CAST( fecha AS DATE) = '". $fechas[$i]."'")->count();
        	
        }
        $total_actual = Inventario::sum('precioTotal');
        $total_anterior = Inventario::where('fecha','<=',$fechas[6])->sum('precioTotal');
        $bajas = BajasInventario::where('semana',date('W')-1)->sum('bajas');
        $semana_corte = $fecha_actual->format('W')-1;
        $view =  \View::make($vistaurl, compact('data', 'date', 'altas', 'total_actual', 'total_anterior', 'bajas', 'semana_corte'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->setPaper('letter', 'portrait');
        $pdf->loadHTML($view);
        
        if($tipo==1){return $pdf->stream('reporte inventario.pdf');}
        if($tipo==2){return $pdf->download('reporte inventario.pdf'); }
    }


    public function crear_reporte_inventario($tipo){

		$vistaurl="inventario.reporte_pdf";
		$areas_inventario = AreaInventario::all();

		//Obtener fechas de los dias de la semana anterior
		$fecha_actual = new DateTime();
		$fechaInicioSemana = date('Y-m-d', strtotime($fecha_actual->format('Y') . 'W' . str_pad($fecha_actual->format('W')-1 , 2, '0', STR_PAD_LEFT)));
		$fechas[1] = $fechaInicioSemana;
		$fechas[2] = date('Y-m-d', strtotime($fechaInicioSemana.' 1 day')); //Martes
		$fechas[3] = date('Y-m-d', strtotime($fechaInicioSemana.' 2 day')); //Miercoles
		$fechas[4] = date('Y-m-d', strtotime($fechaInicioSemana.' 3 day')); //Jueves
		$fechas[5] = date('Y-m-d', strtotime($fechaInicioSemana.' 4 day')); //Viernes
		$fechas[6] = date('Y-m-d', strtotime($fechaInicioSemana.' 5 day')); //Sabado

		$inventario= array();
		foreach ($areas_inventario as $area) {
			$inv_area['area']=$area->nombre;
			$inv_area['inventario']=Inventario::where('area',$area->idArea)->get();
			$inv_area['totalArea']=Inventario::where('area',$area->idArea)->sum('precioTotal');
			$inv_area['totalAnterior'] = Inventario::where('fecha','<=',$fechas[6])->where('area',$area->idArea)->sum('precioTotal');
			array_push($inventario, $inv_area);
     	}

     	$altas = 0;
        for ($i=1; $i < 7; $i++) { 
        	$altas += Inventario::whereRaw("CAST( fecha AS DATE) = '". $fechas[$i]."'")->count();
        	
        }
        $total_actual = Inventario::sum('precioTotal');
        $total_anterior = Inventario::where('fecha','<=',$fechas[6])->sum('precioTotal');
        $bajas = BajasInventario::where('semana',date('W')-1)->sum('bajas');
        $semana_corte = $fecha_actual->format('W')-1;
        $date = date('d-m-Y');
        $view =  \View::make($vistaurl, compact('inventario', 'date', 'altas', 'total_actual', 'total_anterior', 'bajas', 'semana_corte'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->setPaper('letter', 'portrait');
        $pdf->loadHTML($view);
        
        if($tipo==1){return $pdf->stream('reporte inventario.pdf');}
        if($tipo==2){return $pdf->download('reporte inventario.pdf'); }

    }

}