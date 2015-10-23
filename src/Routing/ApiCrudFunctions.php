<?php

namespace Daylight\Routing;

use Illuminate\Http\Request;

trait ApiCrudFunctions
{
	use ValidateRequest;

	public function createOrFail($class, Request $request)
    {
        $requestData = $request->all();

        $errorMessage = isset($this->errorMessage) ? $this->errorMessage : 'content cannot be parsed';
        $okMessage = isset($this->okMessage) ? $this->okMessage : 'record was created successfully';

        $validator = $this->validator($requestData);

        if ($validator->fails()) {
            return responseJsonUnprocessableEntity( ['message' => $errorMessage, 'errors' => shrinkValidationErrors( $validator->errors()->getMessages() ) ] );
        }

        if( method_exists($this,'create') )
        {
        	return $this->create($request);
        }

        $modelInstance = $class::create($requestData);

        // $modelInstance = $this->create($request->all());
        return responseJsonOk( ['message' => $okMessage] );
    }


}