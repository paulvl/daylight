<?php

namespace Daylight\Validation;

use Illuminate\Validation\Validator as IlluminateValidator;

class Validator extends IlluminateValidator
{
	public function __construct($translator, $data, $rules, $messages, array $customAttributes = array())
    {
        // Set custom validation error messages
        if(!isset($messages['null_or_exists']))
        {
            $messages['null_or_exists'] = $translator->get(
                'daylight-validator::validation.null_or_exists'
            );
        }
        parent::__construct($translator, $data, $rules, $messages, $customAttributes);
    }

    public function validateNullOrExists( $attribute, $value, $parameters )
    {
        if ($value == null)
        {
            $parameters[$attribute] = null;
            return true;
        }
        else
            return $this->validateExists($attribute, $value, $parameters);
    }
}