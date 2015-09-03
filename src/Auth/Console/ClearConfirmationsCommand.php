<?php

namespace Daylight\Auth\Console;

use Illuminate\Console\Command;

class ClearConfirmationsCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'auth:clear-confirmations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Flush expired account confirmation tokens';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $this->laravel['auth.confirmation.tokens']->deleteExpired();

        $this->info('Expired confirmation tokens cleared!');
    }
}
