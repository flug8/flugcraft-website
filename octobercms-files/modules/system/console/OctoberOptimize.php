<?php namespace System\Console;

use System;
use Illuminate\Console\Command;

/**
 * OctoberOptimize optimizes the framework and platform files
 *
 * @package october\system
 * @author Alexey Bobkov, Samuel Georges
 */
class OctoberOptimize extends Command
{
    /**
     * @var string name of console command
     */
    protected $name = 'october:optimize';

    /**
     * @var string description of the console command
     */
    protected $description = 'Cache the framework and platform files';

    /**
     * handle executes the console command
     */
    public function handle()
    {
        $this->call('config:cache');
        $this->call('route:cache');

        if (System::hasModule('Cms')) {
            $this->call('theme:cache');
        }

        $this->info('Files cached successfully.');
    }
}
