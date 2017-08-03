<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Cotizacion;

use Illuminate\Http\Request;

class PdfController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}



	 public function invoice() 
    {
        $data = $this->getData();
        $view =  \View::make('PDF/invoice', compact('data', 'date', 'invoice'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view,$data);
        return $pdf->download('invoice.pdf');
    }


    public function getData() 
    {
        $data =  [

            'solicitante' => 'solicitante',
            'fecha' => 'fecha',
            'idarea' => 'area',
            'responsable' => 'responsable',
            'concepto' => 'concepto',
            'tipo_pago' => 'tipo_pago',
            'idproveedor' => 'proveedor',
            'descripcion' => 'descripcion',
            'precio_unitario' => 'precio_unitario',
            'cantidad' => 'cantidad',
            'total' => 'total'

        ];
        return $data;
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
