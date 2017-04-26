<?php

namespace Brisum\Lib\Console;

use \Illuminate\Console\Scheduling\Event as SchedulingEvent;
use Symfony\Component\Process\Process;

class Event extends SchedulingEvent
{
	public function run()
	{
		(new Process(
			trim($this->buildCommand(), '& '), CONSOLE_ROOT_DIR, null, null, null
		))->run();
	}
}
