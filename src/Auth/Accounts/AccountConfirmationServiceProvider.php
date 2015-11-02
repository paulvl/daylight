<?php

namespace Daylight\Auth\Accounts;

use Illuminate\Support\ServiceProvider;
use Daylight\Auth\Console\ClearConfirmationsCommand;
use Daylight\Auth\Accounts\DatabaseTokenRepository as DbRepository;

class AccountConfirmationServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../../database/migrations/2014_10_12_200000_create_account_confirmations_table.php' => database_path('migrations/2014_10_12_200000_create_account_confirmations_table.php')
        ]);

        $this->publishes([
            __DIR__.'/../../../lang/en/confirmations.php' => base_path('resources/lang/en/confirmations.php')
        ]);

        $this->publishes([
            __DIR__.'/../../../lang/es/confirmations.php' => base_path('resources/lang/es/confirmations.php')
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConfirmationBroker();

        $this->registerTokenRepository();

        $this->registerClearConfirmationsCommand();
    }

    /**
     * Register the password broker instance.
     *
     * @return void
     */
    protected function registerConfirmationBroker()
    {
        $this->app->singleton('auth.confirmation', function ($app) {
            // The confirmation token repository is responsible for storing the email addresses
            // and confirmation reset tokens. It will be used to confirm the tokens are valid
            // for the given e-mail addresses. We will resolve an implementation here.
            $tokens = $app['auth.confirmation.tokens'];

            $users = $app['auth']->driver()->getProvider();

            $view = $app['config']['auth.confirmation.email'];

            // The confirmation broker uses a token repository to validate tokens and send user
            // confirmation e-mails, as well as validating that account confirmation process as an
            // aggregate service of sorts providing a convenient interface for resets.
            return new ConfirmationBroker(
                $tokens, $users, $app['mailer'], $view
            );
        });
    }

    /**
     * Register the token repository implementation.
     *
     * @return void
     */
    protected function registerTokenRepository()
    {
        $this->app->singleton('auth.confirmation.tokens', function ($app) {
            $connection = $app['db']->connection();

            // The database token repository is an implementation of the token repository
            // interface, and is responsible for the actual storing of auth tokens and
            // their e-mail addresses. We will inject this table and hash key to it.
            $table = $app['config']['auth.confirmation.table'];

            $key = $app['config']['app.key'];

            $expire = $app['config']->get('auth.confirmation.expire', 7);

            return new DbRepository($connection, $table, $key, $expire);
        });
    }
    
    /**
    * Register the auth:clear-confirmations command.
    */
    private function registerClearConfirmationsCommand()
    {
        $this->app->singleton('command.auth.confirmation.clear-confirmations', function ($app) {
            return $app[ClearConfirmationsCommand::class];
        });
        $this->commands('command.auth.confirmation.clear-confirmations');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['auth.confirmation', 'auth.confirmation.tokens'];
    }
}
