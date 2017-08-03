<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Inventario;
use App\MaterialSistemas;
use App\AreaInventario;
use Auth;
use Validator;
use DateTime;

class MaterialController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function alta_get()
	{
		if(in_array(Auth::user()->role,['administrador','gerente'])){

			$areas = AreaInventario::all();
			return view('inventario/alta_inventario')->with('areas',$areas);
			}

		else
			return view('errors/restringido');
	}

	
	
	public function alta_post(Request $request)
	{
		
		if(in_array(Auth::user()->role,['administrador','gerente'])){

			$rules = ['image' => 'required|image|max:1024*1024*1',];
        $messages = [
            'image.required' => 'La imagen es requerida',
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


        	//Cambiar nombre de foto para que no se repitan
            $name = str_random(30) . '-' . $request->file('image')->getClientOriginalName();
            //guardar foto en disco local
            \Storage::disk('local')->put($name,  \File::get($request->file('image')));
            //$request->file('image')->move('fotos', $name);
            //guardar ruta en base de datos
            $material->foto = 'fotos/'.$name;

            $material->save();
            $material->codigoBarras = $material->id.$area.$fecha->format('d').$fecha->format('m').$fecha->format('y');
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

		else
			return view('errors/restringido');
	}

	public function administrar_get()
	{
		if(in_array(Auth::user()->role,['administrador','gerente'])){

			$areas = AreaInventario::all();
			return view('inventario/administrar')->with('areas',$areas);
			}

		else
			return view('errors/restringido');
	}

	public function administrar_post(Request $request)
	{
		if(in_array(Auth::user()->role,['administrador','gerente'])){

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
				$arr['foto'] = $material->foto;
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

		else
			return view('errors/restringido');
	}

	public function cantidad_get()
	{
		

		if(in_array(Auth::user()->role,['administrador','gerente'])){

			
			return view('inventario/modificar_cantidad');
			}

		else
			return view('errors/restringido');
	}

	public function cantidad_post(Request $request)
	{
		

		if(in_array(Auth::user()->role,['administrador','gerente'])){

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

		else
			return view('errors/restringido');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */

	public function mostrarInventario_get()
	{
		if(in_array(Auth::user()->role, ['administrador','gerente'])){

		return view('inventario/lista_inventario')->with('areas',AreaInventario::all());

		}
		else
			return view('errors/restringido');
	}

	public function mostrarInventario_post(Request $request)
	{
		if(in_array(Auth::user()->role, ['administrador','gerente'])){
		$area = $request->input('area');

		if($area == 'todas'){
			$inventario=Inventario::all();
		}else{
			$inventario=Inventario::where('area',$area)->get();
		}
		return view('inventario/lista_inventario')->with('inventario',$inventario)->with('areas',AreaInventario::all());

		}
		else
			return view('errors/restringido');
	}

	public function eliminar($id)
	{
		return view('inventario/eliminar')->with('inventario',Inventario::find($id));
	}

	public function actualizar_post(Request $request)
	{
		

		if(in_array(Auth::user()->role,['administrador','gerente'])){

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
			
			
			}else
				return view('errors/restringido');
	}
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
		$inventario=Inventario::find($id);
		$inventario->delete();
		return redirect()->route('inventario_lista')->with('success','material eliminado');
	}

}
