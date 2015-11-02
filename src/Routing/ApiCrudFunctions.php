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
        	$modelInstance = $this->create($request);
        }else{

            $modelInstance = $class::create($requestData);
        }

        if ($modelInstance instanceof CanConfirmAccountContract) {
            return $this->postEmail($request);
        }
        
        return responseJsonOk( ['message' => $okMessage] );
    }


}