<?php

namespace Daylight\Validation;

use Illuminate\Support\ServiceProvider;
use Daylight\Validation\Validator;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;

class ValidatorServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(
            __DIR__ . '/../../lang',
            'daylight-validator'
        );

        // Registering the validator extension with the validator factory
        $this->app[ValidationFactory::class]->resolver(
            function($translator, $data, $rules, $messages, $customAttributes = array())
            {
                return new Validator(
                    $translator,
                    $data,
                    $rules,
                    $messages,
                    $customAttributes
                );
            }
        );
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('validator');
    }
}
