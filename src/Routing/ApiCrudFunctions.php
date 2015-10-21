<?php

namespace Daylight\Routing;

use Illuminate\Http\Request;

trait ApiCrudFunctions
{
	use ValidateRequest;

	public function createOrFail($class, Request $request)
    {
        $requestData = $request->all();

        $errorMsg = isset($this->errorMsg) ? $this->errorMsg : 'content cannot be parsed';
        $okMsg = isset($this->okMsg) ? $this->okMsg : 'record was created successfully';

        $validator = $this->validator($requestData);

        if ($validator->fails()) {
            return responseJsonBadRequest( ['msg' => $errorMsg, 'errors' => shrinkValidationErrors( $validator->errors()->getMessages() ) ] );
        }

        if( method_exists($this,'create') )
        {
        	return $this->create($request);
        }

        $modelInstance = $class::create($requestData);

        // $modelInstance = $this->create($request->all());
        return responseJsonOk( ['msg' => $okMsg] );
    }


}