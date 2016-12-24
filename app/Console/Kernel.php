<?php namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {

	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [
		'App\Console\Commands\Inspire',
		'App\Console\Commands\bajaEmpleado',
		'App\Console\Commands\avisoPago',
	];

	/**
	 * Define the application's command schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
	 * @return void
	 */
	protected function schedule(Schedule $schedule)
	{
		$schedule->command('inspire')
				 ->hourly();
		/*$schedule->command('bajaEmpleado')
				 ->thursday()->at('09:48')->evenInMaintenanceMode();*/
		$schedule->command('avisoPago')
				 ->dailyAt('08:47')->evenInMaintenanceMode();
	}

}
