<?php

namespace Brisum\Lib\Console;

use Illuminate\Console\Scheduling\Schedule as SchedulingSchedule;
use Symfony\Component\Process\PhpExecutableFinder;
use Symfony\Component\Process\ProcessUtils;

class Schedule extends SchedulingSchedule {
	/**
	 * Add a new Artisan command event to the schedule.
	 *
	 * @param  string  $command
	 * @param  array  $parameters
	 * @return \Illuminate\Console\Scheduling\Event
	 */
	public function command($command, array $parameters = [])
	{
		$binary = ProcessUtils::escapeArgument((new PhpExecutableFinder)->find(false));

		if (defined('HHVM_VERSION')) {
			$binary .= ' --php';
		}

		if (defined('ARTISAN_BINARY')) {
			$artisan = ProcessUtils::escapeArgument(ARTISAN_BINARY);
		} else {
			$artisan = 'console.php';
		}

		return $this->exec("{$binary} {$artisan} {$command}", $parameters);
	}

	/**
	 * Add a new command event to the schedule.
	 *
	 * @param  string  $command
	 * @param  array  $parameters
	 * @return \Illuminate\Console\Scheduling\Event
	 */
	public function exec($command, array $parameters = [])
	{
		if (count($parameters)) {
			$command .= ' '.$this->compileParameters($parameters);
		}

		$this->events[] = $event = new Event($command);

		return $event;
	}
}
