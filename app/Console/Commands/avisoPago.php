<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use App\Transaccion;
use DateTime;
use App\Notificacion;
use App\Proveedor;
use App\User;
class avisoPago extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'avisoPago';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Avisa de pagos pendientes.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	
	public function handle()
	{

		//obtener la fecha actual
		$fecha = new DateTime('now');
		$fecha = $fecha->format('Y-m-d');
		//$query = "fecha_programada = '" . $fecha . "'"; 
		$pagos = Transaccion::where('fecha_programada','=',$fecha)->get();
		$mensaje = 'Se le recuerda que hoy tiene programado los siguientes pagos: <ul>';
		if (count($pagos)>0){
			foreach ($pagos as $pago) {
				$proveedor = Proveedor::where('id',$pago->proveedor)->first() ;
				$mensaje=$mensaje . '<li>' . $proveedor->nombre . '<strong> Monto: </strong>' .  number_format($pago->cargo,2 ). '</li>';
			}
		$mensaje = $mensaje . '</ul>';
		
		$usuarios_area = User::where('role','administrador')->orWhere('role','contabilidad')->get();
			foreach ($usuarios_area as $usuario) {
			$notificacion = new Notificacion();
		    $notificacion->destinatario = $usuario->id;
		    $notificacion->mensaje = $mensaje;
			$notificacion->fecha = (new DateTime('now'))->format('Y-m-d H:i:s');
			$notificacion->remitente = 'Sistema';
			$notificacion->asunto = 'Recordatorio De Pagos';
			$notificacion->save();
		$this->info('Se han enviado los pagos pendientes a los Administradores');
	}
	}else{
		$this->info($fecha->format('Y-m-d'));
	}

	}

}
