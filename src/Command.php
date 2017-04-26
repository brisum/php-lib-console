<?php

namespace Brisum\Lib\Console;

use Brisum\Lib\ObjectManager;
use Illuminate\Console\Command as IlluminateCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Command extends IlluminateCommand
{
	/**
	 * Execute the console command.
	 *
	 * @param  \Symfony\Component\Console\Input\InputInterface  $input
	 * @param  \Symfony\Component\Console\Output\OutputInterface  $output
	 * @return mixed
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$result = ObjectManager::getInstance()->invoke($this, 'handle');

		echo "\nMemory peak usage: " . (memory_get_peak_usage()/1048576) . " MB \n\n";

		return $result;
	}
}
