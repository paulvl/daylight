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

    protected function validator(array $data, $rules = array())
    {
        $validationRules = isset($this->rules) ? $this->rules : $rules;
        return Validator::make($data, $validationRules);
    }


}
