<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\AreaCt;
use App\tipoKpi;
class KpiController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function alta_tipoKpi_get()
	{
		$areas = AreaCt::all();
		return view('kpi/alta_tipoKpi')->with('areas',$areas);
	}

	public function alta_tipoKpi_post(Request $request)
	{
		$tipoKpi = new tipoKpi([
				'nombre' => strtoupper($request->input('nombre')),
				'unidad' => strtoupper( $request->input('unidad')),
				'pk_idAreaCt' => $request->input('area'),
				]);
		$tipoKpi->save();

		return redirect('kpi/alta/tipo')->with('success','Guardado exitosamente!');
	}

	public function alta_logro_get()
	{	
		$areas = AreaCt::all();
		return view('kpi/alta_logro')->with('areas',$areas);
	}

	public function alta_logro_post()
	{
		//
	}



	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
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
