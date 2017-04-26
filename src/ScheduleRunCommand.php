<?php

namespace Brisum\Lib\Console;

// copy of \Illuminate\Console\Scheduling\ScheduleRunCommand
class ScheduleRunCommand extends Command
{
	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'schedule:run';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Run the scheduled commands';

	/**
	 * The schedule instance.
	 *
	 * @var \Illuminate\Console\Scheduling\Schedule
	 */
	protected $schedule;

	/**
	 * Create a new command instance.
	 *
	 * @param Application $app
	 * @param  \Illuminate\Console\Scheduling\Schedule $schedule
	 */
	public function __construct(Application $app, Schedule $schedule)
	{
		$this->laravel = $app;
		$this->schedule = $schedule;

		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function handle()
	{
		/** @var Event[] $events */
		$events = $this->schedule->dueEvents($this->laravel);

		$eventsRan = 0;

		foreach ($events as $event) {
			if (! $event->filtersPass($this->laravel)) {
				continue;
			}

			$this->line('<info>Running scheduled command(' . date('Y-m-d H:m:i') . '):</info> '.$event->getSummaryForDisplay());

			$event->run();

			++$eventsRan;
		}

		if (count($events) === 0 || $eventsRan === 0) {
			$this->info('No scheduled commands are ready to run(' . date('Y-m-d H:m:i') . ').');
		}
	}
}
