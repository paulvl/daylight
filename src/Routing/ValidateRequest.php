<?php

namespace Daylight\Routing;

use Illuminate\Support\Facades\Validator;

trait ValidateRequest
{
	/**
    * Get a validator for an incoming request.
    *
    * @param  array  $data
    * @param  array  $rules
    * @return \Illuminate\Contracts\Validation\Validator
    */

    protected function validator(array $data, array $rules)
    {
        return Validator::make($data, $rules);
    }


}
