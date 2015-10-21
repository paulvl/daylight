<?php

namespace Daylight\Routing;

use Illuminate\Http\Request;
use Daylight\Routing\ValidateRequest;

trait ApiCrudFunctions
{
	use ValidateRequest;

	public function createOrFail($class, Request $request)
    {
        $errorMsg = isset($this->errorMsg) ? $this->errorMsg : 'content cannot be parsed';
        $okMsg = isset($this->okMsg) ? $this->okMsg : 'record was created successfully';

        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return responseJsonBadRequest( ['msg' => $errorMsg, 'errors' => shrinkValidationErrors( $validator->errors()->getMessages() ) ] );
        }

        if( method_exists($this,'create') )
        {
        	return $this->create($request);
        }

        $modelInstance = $class::create($request->all());

        // $modelInstance = $this->create($request->all());
        return responseJsonOk( ['msg' => $okMsg] );
    }


}