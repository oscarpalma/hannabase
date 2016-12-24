<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use App\Empleado;
use App\Checada;
use DateTime;
use App\Notificacion;

class bajaEmpleado extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'bajaEmpleado'; 

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Convierte empleado a candidato despues de 8 dias de inactividad.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	

	public function handle()
	{
		//obtener la fecha actual
		$fecha = new DateTime('now');
		$empleadosInactivos = array();
		$diasTolerancia = 8; //los dias que un empleado puede aparecer como inactivo sin ser convertido en candidato
		$cont = 0; //un contador con el numero de empleados inactivos que fueron convertidos en candidatos

		foreach(Empleado::where('estado', 'empleado')->where('contratable', true)->get() as $empleado){
			//obtiene la checada mas reciente del empleado
			$checada = Checada::where('idEmpleado', $empleado->idEmpleado)->orderBy('fecha','desc')->first();

			//si no existe checada, verificar si ha habido actividad durante los ultimos 8 dias
			if($checada === null){
				if($fecha->diff(new DateTime($empleado->updated_at))->format('%a') >= $diasTolerancia) {
					//modifica el empleado a candidato y lo guarda en la base de datos
					$empleado->estado = 'candidato';
					$empleado->save();
					$cont++;
				}
				continue;
			}

			//obtiene la cantidad de dias entre hoy y la ultima checada registrada del empleado
			if($fecha->diff(new DateTime($checada->fecha))->format('%a') >= $diasTolerancia){ 
				//modifica el empleado a candidato y lo guarda en la base de datos
				$empleado->estado = 'candidato';
				$empleado->save();
				$cont++;

			}
		
		}
		if ($cont > 0){
		

		$usuarios_area = User::where('role','administrador')->get();
			foreach ($usuarios_area as $usuario) {
			$notificacion = new Notificacion();
		    $notificacion->destinatario = $usuario->id;
		    $notificacion->mensaje = 'Un total de '. $cont .' empleados sin actividad en 8 dias se convirtieron a candidatos';
			$notificacion->fecha = (new DateTime('now'))->format('Y-m-d H:i:s');
			$notificacion->remitente = 'Sistema';
			$notificacion->asunto = 'Empleado(s) a Candidato(s)';
			$notificacion->save();
			 } 
	}
		$this->info('Los empleados sin actividad en 8 dias se convirtieron a candidatos');

	}

}
