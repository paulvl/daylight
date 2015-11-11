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

	public function createOrFail(Request $request, Closure $callback = null)
    {
        $requestData = $request->all();

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

        if ($modelInstance instanceof CanConfirmAccountContract) {
            return $this->postEmail($request);
        }
        
        return responseJsonOk( ['message' => $this->creationSuccessMsg] );
    }


}