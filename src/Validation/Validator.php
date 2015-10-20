<?php

namespace Daylight\Validation;

use Illuminate\Validation\Validator as IlluminateValidator;

class Validator extends IlluminateValidator
{
    public function validateNullOrExists( $attribute, $value, $parameters )
    {
        if ($value == null)
            return true;
        else
            return $this->validateExists($attribute, $value, $parameters);
    }
}