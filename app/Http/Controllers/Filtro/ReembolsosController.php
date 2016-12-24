<?php namespace App\Http\Controllers\Filtro;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Empleado;
use App\Reembolso;
use App\TipoDescuento;
use DateTime;
use Auth;

class ReembolsosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if(Auth::guest())
			return redirect()->route('login');

		else if(in_array(Auth::user()->role, ['administrador','recepcion','contabilidad'])){
			$descuentos = TipoDescuento::all();
			$empleados = Empleado::where('contratable',true)->where('estado','empleado')->get();

			//se envian tanto la listas de empleados como de descuentos en un solo array
			$informacion = ['descuentos' => $descuentos, 'empleados' => $empleados];
			return view('filtro/reembolsos')->with('informacion',$informacion);
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
			return redirect()->route('filtro_reembolsos')->withInput()->with('success','La semana no coincide con la fecha ingresada');
		}

		$empleado = Empleado::find($request->input('idEmpleado'));
		$tipo_descuento = TipoDescuento::find($request->input('id_descuento'));
		$reembolso = new Reembolso([
			'empleado'    => $empleado->idEmpleado,
			'descuento'   => $tipo_descuento->id_descuento,
			'fecha'       => $request->input('fecha'),
			'comentario' => $request->input('comentario'),
			'semana'      => $request->input('semana')
			]);

		$reembolso->save();

		return redirect()->route('filtro_reembolsos')->withInput()->with('success','Reembolso registrado con éxito');
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