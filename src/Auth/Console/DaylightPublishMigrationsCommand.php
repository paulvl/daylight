<?php

namespace Daylight\Auth\Console;

use Illuminate\Console\Command;

class DaylightPublishMigrationsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daylight:publish-migrations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish Daylight migrations';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->callSilent('vendor:publish', [
            '--provider' => 'Daylight\Auth\SocialNetworks\SocialNetworksServiceProvider',
            '--tag' => 'migrations'
        ]);
        
        $this->info('Publish Daylight migrations completed!');
    }
}
