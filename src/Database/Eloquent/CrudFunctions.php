<?php

namespace Daylight\Database\Eloquent;

use Closure;
use Illuminate\Http\Request;
use Daylight\Routing\ValidateRequest;
use Daylight\Routing\Api\CrudMessages;

trait CrudFunctions
{
	use ValidateRequest,
        CrudMessages;

	public static function createOrFail($request, Closure $callback = null)
    {
        $requestData = ($request instanceof Request) ? $request->all() : $request;

        $validator = $this->validator($requestData);

        if ($validator->fails()) {
            return responseJsonUnprocessableEntity( ['message' => $this->contentCannotBeParsedMsg, 'errors' => shrinkValidationErrors( $validator->errors()->getMessages() ) ] );
        }

        if( !is_null($callback) )
        {
        	$modelInstance = call_user_func($callback);
        }else{
            $modelInstance = self::create($requestData);
        }
        
        return responseJsonOk( ['message' => $this->creationSuccessMsg] );
    }


}