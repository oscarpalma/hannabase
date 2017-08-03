<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use DateTime;
use DateInterval;
use App\AreaCt;
use App\EmpleadoCt;
use App\Proveedor;
use App\Cotizacion;
use App\Autorizacion;
use App\Temporal;
use Mail;

class AutorizacionController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		
	}


	public function aprobarCotizacion($idCotizacion)
	{
		if(Auth::guest())
			return redirect()->route('login');

		else if(Auth::user()->role == 'administrador'){

			$cotizacion = Cotizacion::find($idCotizacion);
			return view('autorizaciones/cotizacion_aprobar')->with('cotizacion',$cotizacion);
		}

		else
			return view('errors/restringido');
	}

	//Muestra la vista de cotizaciones cargando los Empleados y Areas
	public function HacerCotizacion()
	{
		if(Auth::guest())
			return redirect()->route('login');

		elseif(Auth::user()->role == 'administrador'){

			$areas = AreaCt::all();
			$solicitante = EmpleadoCt::all();
			$info = ['areas'=>$areas, 'solicitante' => $solicitante];
			return view('autorizaciones/cotizaciones')->with('info',$info);
		}
	}



	//Envia correo con el formulario
	public function enviarMensaje(Request $request)
	{	


		Mail::send('emails/enviarCotizacion',$request->all(), function($msj){
            $msj->subject('Cotizaciones de Compra');
            $msj->to('armando@crtmsourcing.com');
        });

		
	}

	public function guardarCotizacion(Request $request)
	{
		if(in_array(Auth::user()->role, ['administrador','contabilidad','supervisor']))
		{
			//Recibe los datos capturados en el formulario y los guarda en la base de datos
			$cotizacion = new Cotizacion([

				'solicitante' => $request->input('solicitante'),
				'fecha' => $request->input('fecha'),
				'idarea' => $request->input('area'),
				'responsable' => $request->input('responsable'),
				'concepto' => $request->input('concepto'),
				'tipo_pago' => $request->input('tipo_pago')

				]);

			$cotizacion->save();

				$proveedor = $request->input('proveedor');
				$descripcion = $request->input('descripcion');
				$precio_unitario = $request->input('precio_unitario');
				$cantidad = $request->input('cantidad');
				$total = $request->input('total');

				for($i=0; $i < count($proveedor); $i++){

					$temporal = new Temporal([

						'idcotizacion' => $cotizacion->idcotizacion,
						'proveedor' => $proveedor[$i],
						'descripcion' => $descripcion[$i],
						'precio_unitario' => $precio_unitario[$i],
						'cantidad' => $cantidad[$i],
						'total' => $total[$i]


					]);

			$temporal->save();

				}

			$this->enviarMensaje($request);

			return redirect()->route('cotizacion')->withInput()->with('mensaje','Enviado y Guardado');
		}
		
		else
			return view('errors/restringido');
	}

	public function listaCotizaciones()

	{
		if(Auth::guest())
			return redirect()->route('login');

		else if(in_array(Auth::user()->role, ['administrador','contabilidad'])){

		return view('autorizaciones/lista_cotizaciones')->with('cotizaciones',Cotizacion::all());

		}
		else
			return view('errors/restringido');
	}

	

	//Muestra el formulario de autorizacion cargando las areas y proveedores
	public function HacerAutorizacion()
	{
		if(Auth::guest())
			return redirect()->route('login');

		elseif(Auth::user()->role == 'administrador'){

			$areas = AreaCt::all();
			$proveedores = Proveedor::all();
			$solicitan = EmpleadoCt::all();
			$info = ['areas'=>$areas, 'proveedores' => $proveedores, 'solicitan' => $solicitan];
			return view('autorizaciones/autorizaciones')->with('info',$info);
		}
	}

	//Toma los elementos de la vista autorizaciones y los guarda en la base de datos
	public function guardarAutorizacion(Request $request)
	{

		$area = AreaCt::where('nombre',$request->input('area'))->first();
		$proveedor = Proveedor::where('nombre',$request->input('proveedor'))->first();

		if(in_array(Auth::user()->role, ['administrador','contabilidad','supervisor']))
		{

			//Recibe los datos capturados en el formulario y los guarda en la base de datos
			$autorizacion = new Autorizacion([

				'solicitante' => $request->input('solicitante'),
				'fecha' => $request->input('fecha'),
				'idarea' => $request->input('area'),
				'responsable' => $request->input('responsable'),
				'concepto' => $request->input('concepto'),
				'tipo_pago' => $request->input('tipo_pago'),
				'idproveedor' => $request->input('proveedor'),
				'descripcion' => $request->input('descripcion'),
				'precio_unitario' => $request->input('precio_unitario'),
				'cantidad' => $request->input('cantidad'),
				'total' => $request->input('total')

				]);



			$autorizacion->save();

			return redirect()->route('aprobarcotizacion')->withInput()->with('mensaje','Compra Autorizada');
		}

		else
			return view('errors/restringido');

	}

	//Toma los elementos guardados en la base de datos y los muestra en una tabla
	public function listaAutorizaciones()

	{
		if(Auth::guest())
			return redirect()->route('login');

		else if(in_array(Auth::user()->role, ['administrador','contabilidad'])){

		return view('autorizaciones/lista_autorizaciones')->with('autorizaciones',Autorizacion::all());

		}
		else
			return view('errors/restringido');
	}

	public function verAutorizacion($idAutorizacion)
	{
		if(Auth::guest())
			return redirect()->route('login');

		else if(Auth::user()->role == 'administrador'){

			$autorizacion = Autorizacion::find($idAutorizacion);
			return view('autorizaciones/ver_autorizacion')->with('autorizacion',$autorizacion);
		}

		else
			return view('errors/restringido');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		
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


	/*if(in_array(Auth::user()->role, ['administrador','contabilidad','supervisor']))
			{

			//Recibe los datos capturados en el formulario y los guarda en la base de datos
			$cotizacion = new Cotizacion([

				'solicitante' => $request->input('solicitante'),
				'fecha' => $request->input('fecha'),
				'idarea' => $request->input('area'),
				'responsable' => $request->input('responsable'),
				'concepto' => $request->input('concepto'),
				'tipo_pago' => $request->input('tipo_pago')

				]);

				$cotizacion->save();

				$proveedor = $request->input('proveedor');
				$descripcion = $request->input('descripcion');
				$precio_unitario = $request->input('precio_unitario');
				$cantidad = $request->input('cantidad');
				$total = $request->input('total');

				for($i=0; $i < count($proveedor); $i++){
				$temporal = new Temporal([

				'idtemporal' => $temporal->idTemporal,
				'proveedor' => $proveedor->[$i],
				'descripcion' => $descripcion[$i],
				'precio_unitario' => $precio_unitario[$i],
				'cantidad' => $cantidad[$i],
				'total' => $total[$i]

				]);

				$temporal->save();
			}

		$this->enviarMensaje($request);

		return redirect()->route('cotizacion')->withInput()->with('mensaje','Enviado y Guardado');

		}

		else
			return view('errors/restringido');