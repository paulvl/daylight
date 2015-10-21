<?php

if (! function_exists('shrinkValidationErrors')) {
	function shrinkValidationErrors($errors){
		foreach ($errors as $field => $errorMessages) {
			$errors[$field] = strtolower( str_replace('.', '', implode(', ', $errorMessages) ) );
		}
		return $errors;
	}
}