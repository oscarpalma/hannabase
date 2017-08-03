<?php namespace App\Http\Controllers\Filtro;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Empleado;
use App\Descuento;
use App\TipoDescuento;
use Illuminate\Http\Request;
use DateTime;
use Auth;

class DescuentosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if(Auth::guest())
			return redirect()->route('login');

		else if(in_array(Auth::user()->role, ['administrador','recepcion','supervisor','contabilidad'])){
			$descuentos = TipoDescuento::all();
			$empleados = Empleado::where('contratable',true)->where('estado','empleado')->get();

			//se envian tanto la listas de empleados como de descuentos en un solo array
			$informacion = ['descuentos' => $descuentos, 'empleados' => $empleados];
			return view('filtro/descuentos')->with('informacion',$informacion);
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
		$fecha = new DateTime($request->input('fecha'));

		if($fecha->format("W") != $request->input('semana')){
			return redirect()->route('filtro_descuentos')->withInput()->with('success','La semana no coincide con la fecha ingresada');
		}

		$empleado = Empleado::find($request->input('idEmpleado'));
		$tipo_descuento = TipoDescuento::find($request->input('id_descuento'));
		$descuento = new Descuento([
			'empleado'    => $empleado->idEmpleado,
			'descuento'   => $tipo_descuento->id_descuento,
			'fecha'       => $request->input('fecha'),
			'comentario' => $request->input('comentario'),
			'semana'      => $request->input('semana')
			]);

		$descuento->save();

		return redirect()->route('filtro_descuentos')->withInput()->with('success','Descuento registrado con éxito');
	}

	public function verDescuentos_get()
	{
		

		if(in_array(Auth::user()->role, ['administrador','recepcion','supervisor','contabilidad'])){
			
			return view('filtro/listado_descuentos');
		}

		else
			return view('errors/restringido');
	}

	public function verDescuentos_post(Request $request)
	{
		

		if(in_array(Auth::user()->role, ['administrador','recepcion','supervisor','contabilidad'])){
			$semana = $request->input('semana');
			$descuentos = Descuento::where('semana',$semana)->orderBy('fecha')->get();
			$informacion = array();

			foreach ($descuentos as $descuento) {
				$empleado=Empleado::find($descuento->empleado);
				$tipoDescuento=TipoDescuento::find($descuento->descuento);
				$info['no_empleado']=$descuento->empleado;
				$info['nombre']= $empleado->ap_paterno.' '.$empleado->ap_materno.', '.$empleado->nombres;
				$info['material']=$tipoDescuento->nombre_descuento;
				$info['precio']=$tipoDescuento->precio;
				$info['fecha']=$descuento->fecha;
				$info['id']=$descuento->id_descuentos;
				array_push($informacion,$info);
			}
			return view('filtro/listado_descuentos') -> with ('descuentos',$informacion)-> with ('semana',$semana);
		}

		else
			return view('errors/restringido');
	}

	public function eliminar_descuento($id){
		
		if(in_array(Auth::user()->role, ['administrador','contabilidad','recepcion'])){
			$descuento = Descuento::where('id_descuentos',$id)->first();
			$empleado=Empleado::find($descuento->empleado);
			$tipoDescuento=TipoDescuento::find($descuento->descuento);
			$info['no_empleado']=$descuento->empleado;
			$info['nombre']= $empleado->ap_paterno.' '.$empleado->ap_materno.', '.$empleado->nombres;
			$info['material']=$tipoDescuento->nombre_descuento;
			$info['precio']=$tipoDescuento->precio;
			$info['fecha']=$descuento->fecha;

			return view('filtro/confirmar')->with('descuento',$info)->with('id',$id);
		}

		else
			return view('errors/restringido');
	}

	public function eliminar($id){
		$descuento = Descuento::where('id_descuentos',$id)->first();
		$descuento->delete();

		return redirect()->route('verDescuentos')->with('success','exitoso');
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
	}

}