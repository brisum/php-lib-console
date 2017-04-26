<?php

namespace Brisum\Lib\Console;

use Brisum\Lib\ObjectManager;
use Symfony\Component\Console\Application as SymfonyApplication;

class Application  extends SymfonyApplication
{
	public function __construct(
		$name,
		$version,
		array $commands,
		array $scheduleTasks,
		ObjectManager $objectManager
	) {
		parent::__construct($name, $version);

		$objectManager->invoke($this, 'initCommands', ['commands' => $commands]);
		$objectManager->invoke($this, 'initSchedule', ['scheduleTasks' => $scheduleTasks]);
	}

	public function isDownForMaintenance()
	{
		return false;
	}

	public function environment()
	{
		return [];
	}

	public function initCommands(ObjectManager $objectManager, array $commands = [])
	{
		$this->add($objectManager->create(
			'Brisum\Lib\Console\ScheduleRunCommand',
			[
				'app' => $this,
				'schedule' => $objectManager->get('Brisum\Lib\Console\Schedule')
			]
		));

		foreach ($commands as $command) {
			$this->add($objectManager->create($command));
		}
	}

	public function initSchedule(Schedule $schedule, array $scheduleTasks = [])
	{
		foreach ($scheduleTasks as $command => $time) {
			$schedule->command($command)->cron($time);
		}
	}
}
