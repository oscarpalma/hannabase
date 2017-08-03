<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Proveedor;
use App\Transaccion;
use Auth;
use DateTime;
use DateInterval;
use Illuminate\Http\Request;

class ProveedorController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		if(Auth::guest())
			return redirect()->route('login');

		else if(in_array(Auth::user()->role, ['administrador','contabilidad'])){

		return view('proveedores/agregar');

		}
		else
			return view('errors/restringido');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Request $request)
	{
		//
		if(Auth::guest())
			return redirect()->route('login');

		else if(in_array(Auth::user()->role, ['administrador','contabilidad'])){

		$proveedor = new Proveedor([
			'nombre' => $request->input('nombre'),
			'contacto' => $request->input('contacto'),
			'telefono' => $request->input('telefono'),
			'email' => $request->input('email'),
			'credito' => $request->input('credito')
			]);

		$proveedor->save();

		return redirect()->route('nuevo_proveedor')->withInput()->with('mensaje','Registro exitoso');

		}
		else
			return view('errors/restringido');	
	}



	public function transaccion()
	{
		if(Auth::guest())
			return redirect()->route('login');

		else if(in_array(Auth::user()->role, ['administrador','contabilidad'])){

		return view('proveedores/nueva_transaccion')->with('proveedores',Proveedor::all());
		}
		else
			return view('errors/restringido');	
	}

	public function guardarTransaccion(Request $request)
	{
		if(Auth::guest())
			return redirect()->route('login');

		else if(in_array(Auth::user()->role, ['administrador','contabilidad'])){
		$proveedor = Proveedor::find($request->input('proveedor'));
		$transaccion = new Transaccion([
			'factura' => $request->input('factura'),
			'proveedor' => $proveedor->id,
			'concepto' => $request->input('concepto'),
			'categoria' => $request->input('categoria'),
			'subcategoria' => $request->input('subcategoria'),
			'codigo' => $request->input('codigo'),
			'semana' => $request->input('semana'),
			'fecha_captura' => $request->input('fecha_captura'),
			'fecha_agendada' => $request->input('fecha_agendada'),
			'cargo' => $request->input('cargo'),
			'abono' => $request->input('abono'),
			'saldo' => $request->input('saldo'),
			'fecha_programada' => $request->input('fecha_programada'),
			'fecha_traspaso' => $request->input('fecha_traspaso'),
			'cheque' => $request->input('cheque'),
			]);

		$transaccion->save();

		return redirect()->route('proveedores_transaccion')->withInput()->with('mensaje','Registro exitoso');

		}
		else
			return view('errors/restringido');	
	}


	public function listaProveedores()

	{
		if(Auth::guest())
			return redirect()->route('login');

		else if(in_array(Auth::user()->role, ['administrador','contabilidad'])){

		return view('proveedores/lista_proveedores')->with('proveedores',Proveedor::all());

		}
		else
			return view('errors/restringido');
	}

	public function editar($id)

	{
		if(Auth::guest())
			return redirect()->route('login');

		else if(in_array(Auth::user()->role, ['administrador','contabilidad'])){

		return view('proveedores/editar')->with('proveedor',Proveedor::find($id));
		}
		else
			return view('errors/restringido');
	}

	public function actualizarProveedor($id, Request $request)
	{
		if(Auth::guest())
			return redirect()->route('login');

		else if(in_array(Auth::user()->role, ['administrador','contabilidad'])){
		$proveedor = Proveedor::find($id);
		$proveedor->nombre = $request->input('nombre');
		$proveedor->contacto = $request->input('contacto');
		$proveedor->telefono = $request->input('telefono');
		$proveedor->email = $request->input('email');
		$proveedor->credito = $request->input('credito');

		$proveedor->save();
		return redirect()->route('lista_proveedores');

		}

		else
			return view('errors/restringido');
	}

	public function eliminar($id)
	{
		return view('proveedores/eliminar')->with('proveedor',Proveedor::find($id));
	}

	public function buscar()
	{
		if(Auth::guest())
			return redirect()->route('login');

		else if(in_array(Auth::user()->role, ['administrador','contabilidad'])){
		return view('proveedores/lista_transacciones')->with('proveedores',Proveedor::all());

		}

		else
			return view('errors/restringido');
	}


	public function mostrar(Request $request)
	{
		if(Auth::guest())
			return redirect()->route('login');

		else if(in_array(Auth::user()->role, ['administrador','contabilidad'])){
		if($request->input('proveedor') != 'todos'){
			$proveedor = Proveedor::find($request->input('proveedor'));
			$transacciones = Transaccion::where('proveedor',$proveedor->id)->get();
		}
		else{
			$transacciones = Transaccion::all();
		}

		//enviar un array en el que se asocie cada id de proveedor con su nombre
		$proveedores = array();
		foreach(Proveedor::all() as $prov){
			$proveedores[$prov->id] = $prov->nombre;
		}

		return view('proveedores/lista_transacciones')->with('transacciones',$transacciones)->with('lista_proveedores',$proveedores)->with('proveedores',Proveedor::all());

		}

		else
			return view('errors/restringido');
	}


	//confirmar que se quiere eliminar
	public function borrarTransaccion($id)
	{
		if(Auth::guest())
			return redirect()->route('login');

		else if(in_array(Auth::user()->role, ['administrador','contabilidad'])){
			$transaccion = Transaccion::find($id);
			$proveedor = Proveedor::find($transaccion->proveedor);
		return view('proveedores/eliminar_transaccion')->with('transaccion',$transaccion)->with('proveedor',$proveedor);

		}

		else
			return view('errors/restringido');
	}

	//eliminar la transaccion
	public function eliminarTransaccion($id)
	{
		if(Auth::guest())
			return redirect()->route('login');

		else if(in_array(Auth::user()->role, ['administrador','contabilidad'])){		
		$transaccion = Transaccion::find($id);
		$transaccion->delete();

		return redirect()->route('transacciones');

		}

		else
			return view('errors/restringido');
	}


	public function buscarReporte()
	{
		

		if(Auth::guest())
			return redirect()->route('login');

		else if(in_array(Auth::user()->role, ['administrador','contabilidad'])){		
			$proveedores = Proveedor::all();
			

			$parametros = ['proveedores' => $proveedores]; //parametros para filtrar la busqueda
			return view('proveedores/reporte')->with('parametros', $parametros);
		}

		else
			return view('errors/restringido');
	}

	public function generarReporte(Request $request)
	{
	if(Auth::guest())
			return redirect()->route('login');

		else if(in_array(Auth::user()->role, ['administrador','contabilidad'])){		
			$proveedor = $request->input('proveedor');
			$forma = $request->input('por');


			//queryFechas se encarga de delimitar el periodo de tiempo
			if($forma == 'semana')
				$queryFechas = "semana = '" . $request->input('valor') . "'";

			elseif($forma == 'mes'){
				$fechaActual = new DateTime('now');
				$fecha1 = new DateTime();
				$fecha2 = new DateTime();
				//el primer dia del mes dado
				$fecha1->setDate($fechaActual->format('Y'),$request->input('valor'),1); 
				
				//el primer dia del siguiente mes
				if($request->input('valor') == 12)
					//si es diciembre, tomar enero como el siguiente dia
					$fecha2 = setDate(($fechaActual->format('Y')+1), 1, 1);
				
				else
					$fecha2->setDate($fechaActual->format('Y'),($request->input('valor')+1),1); 

				//restar un dia a la segunda fecha para que sea el ultimo dia del mes
				$fecha2->sub(new DateInterval('P1D'));


			$queryFechas = "fecha_captura BETWEEN CAST('" . $fecha1->format('Y-m-d') . "' AS DATE) AND CAST('" . $fecha2->format('Y-m-d') . "' AS DATE)";
			}

			else {//año
				$fecha1 = new DateTime();
				$fecha2 = new DateTime();
				$year = $request->input('valor');

				$fecha1->setDate($year,1,1); //primer dia del año
				$fecha2->setDate($year,12,31); //ultimo dia del año
				
				$queryFechas = "fecha_captura BETWEEN CAST('" . $fecha1->format('Y-m-d') . "' AS DATE) AND CAST('" . $fecha2->format('Y-m-d') . "' AS DATE)";
			}

			//si no especifica proveedor, ignorar del query
			if($proveedor == 'todos'){
				$queryProveedor = "";
			}

			else
				$queryProveedor = " AND proveedor = '" . $request->input('proveedor') . "'";

			

			$transacciones = Transaccion::whereRaw($queryFechas.$queryProveedor)->	orderBy('semana')->get();


			$total_cargo=0;
			$total_abono=0;
			$total_saldo=0;
			
			foreach ($transacciones as $transaccion) {
				$total_cargo += $transaccion->cargo;
				$total_abono += $transaccion->abono;
				$total_saldo += $transaccion->saldo;
			}

			###### Consulta directa a la base de datos que trae los codigos de expensa #####
			$codigo = \DB::table('transacciones')
				->select(\DB::raw('count(id) count, codigo, categoria, subcategoria, semana'))
				->whereRaw($queryFechas)
				->groupBy('codigo')
				->orderBy('semana')
				->get();

			$proveedores = Proveedor::all();
			$proveedor = Proveedor::where('id', $proveedor)->first();
			$parametros = ['proveedores' => $proveedores, 'transacciones'=>$transacciones,'total_abono'=>$total_abono, 'total_cargo'=>$total_cargo, 'total_saldo'=>$total_saldo, 'proveedor'=>$proveedor, 'codigo'=>$codigo]; //parametros para filtrar la busqueda
			return view('proveedores/reporte')->with('parametros', $parametros);
		}

		else
			return view('errors/restringido');

		
	}

	public function detalleReporte(Request $request)
	{
		

		
	}

	

public function editarT($id){

if(Auth::guest())
			return redirect()->route('login');

		else if(in_array(Auth::user()->role, ['administrador','contabilidad'])){

				$transaccion = Transaccion::find($id);
				
				
					$proveedor = Proveedor::find($transaccion->proveedor);
					$transaccion['proveedor']=$proveedor->id;

					$proveedores = Proveedor::all();
				

				return view('proveedores/editar_transaccion')->with('transaccion',$transaccion)->with('proveedores',$proveedores);
				

			}

		else
			return view('errors/restringido');

	}

####################### Metodos para Cambiar Saldo a Abono ##############################################

	public function MostrarSaldo($id)
	{
		if(Auth::guest())
			return redirect()->route('login');

		else if(Auth::user()->role == 'administrador'){

			$transaccion = Transaccion::find($id);
			return view('proveedores/mostrar_saldos')->with('transaccion',$transaccion);
		}
		else
			return view('errors/restringido');
	}

	public function ConvertirSaldo(Request $request, $id)
	{

		
		if(Auth::guest())
				return redirect()->route('login');

		else if(in_array(Auth::user()->role, ['administrador','contabilidad'])){

			$transaccion = Transaccion::find($id);
			$transaccion->abono = $request->input('saldo');
			$transaccion->saldo = 0;

			$transaccion->save();
			return redirect()->route('transacciones')->withInput()->with('mensaje','Abono Guardado');
		}
		
		else
			return view('errors/restringido');
	}

########################################################################################################

	public function guardarCambios(Request $request, $id){

if(Auth::guest())
			return redirect()->route('login');

		else if(in_array(Auth::user()->role, ['administrador','contabilidad'])){

			$transaccion = Transaccion::find($id);
			$transaccion->factura = $request->input('factura');
			$transaccion->proveedor=$request->input('proveedor');
			$transaccion->concepto= $request->input('concepto');
			$transaccion->categoria = $request->input('categoria');
			$transaccion->subcategoria = $request->input('subcategoria');
			$transaccion->codigo = $request->input('codigo');
			$transaccion->semana = $request->input('semana');
			$transaccion->fecha_captura = $request->input('fecha_captura');
			$transaccion->fecha_agendada = $request->input('fecha_agendada');
			$transaccion->cargo = $request->input('cargo');
			$transaccion->abono = $request->input('abono');
			$transaccion->saldo = $request->input('saldo');
			$transaccion->fecha_programada = $request->input('fecha_programada');
			$transaccion->fecha_traspaso = $request->input('fecha_traspaso');
			$transaccion->cheque = $request->input('cheque');

			$transaccion->save();

			return redirect()->route('transacciones');

			}

		else
			return view('errors/restringido');

	}

public function subirArchivo(){
	return view('proveedores/subirTransaccion');
}
	public function subirTransacciones(Request $request){
		//Se obtiene el archivo para guardar
		$archivo = $request->file('archivo');
       $nombre_original=$archivo->getClientOriginalName();
	   $extension=$archivo->getClientOriginalExtension();
	   $storage = \Storage::disk('archivos');
	   //se borran los archivos guardados para no consumir espacio
	   \File::cleanDirectory(storage_path('archivos'));
	   //Guardando el archivo
       $r1=\Storage::disk('archivos')->put($nombre_original,  \File::get($archivo) );
       //Obtener ruta del archivo para poder leerlo
       $ruta  =  storage_path('archivos') ."/". $nombre_original;

       $guardados=0;
	   $noGuardados=0;
       //Cargando el archivo
		\Excel::load($ruta,function($archivo){
			$result=$archivo->get();
			
			
			
			foreach ($result as $value) {
				
				$fecha=$value->issue_date ; // fecha.

				#separas la fecha en subcadenas y asignarlas a variables
				#relacionadas en contenido, por ejemplo dia, mes y anio.

				$dia   = substr($fecha,0,2);
				$mes = substr($fecha,3,2);
				$anio = substr($fecha,6,4);  
				$semana = date('W',  strtotime($fecha));
				
				try{
				$transaccion = new Transaccion([
					'factura' => $value->factura,
					'fecha_captura' => $value->issue_date,
					'fecha_agendada' => $value->due_date,
					'concepto' => $value->concepto,
					'cheque' => $value->no_cheque,
					'cargo' => $value->importe_pesos,
                                        'saldo' => $value->importe_pesos,
                                        'semana'=> $value->semana,
					'proveedor'=>Proveedor::where('nombre','like','%'.$value->proveedor.'%')->first()->id,
					
					'fecha_programada'=>$value->due_date,
					'fecha_traspaso'=>$value->fecha_de_pago,
					]);
				
				$transaccion->save();
				

            	} catch (\Illuminate\Database\QueryException $e) {
        // something went wrong with the transaction, rollback
            	echo $e;	
    } catch (\Exception $e) {
        // something went wrong elsewhere, handle gracefully
      
    }
  
				
	}			
			
		})->get();
		
			$mensaje = "Registros Guardados";
		return view('proveedores/subirTransaccion')->with('message',$mensaje);
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
		if(Auth::guest())
			return redirect()->route('login');

		else if(in_array(Auth::user()->role, ['administrador','contabilidad'])){
		$proveedor = Proveedor::find($id);
		$proveedor->delete();

		return redirect()->route('lista_proveedores');

		}

		else
			return view('errors/restringido');
	}

}