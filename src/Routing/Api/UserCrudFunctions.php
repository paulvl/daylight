<?php

namespace Daylight\Routing\Api;

use Illuminate\Http\Request;
use Daylight\Foundation\Auth\ApiConfirmsAccounts;
use Daylight\Routing\ValidateRequest;
use Daylight\Contracts\Auth\CanConfirmAccount as CanConfirmAccountContract;

trait UserCrudFunctions
{
	use ApiConfirmsAccounts,
        ValidateRequest,
        CrudMessages;

	public function createOrFail($class, Request $request)
    {
        $requestData = $request->all();

        $validator = $this->validator($requestData);

        if ($validator->fails()) {
            return responseJsonUnprocessableEntity( ['message' => $this->contentCannotBeParsedMsg, 'errors' => shrinkValidationErrors( $validator->errors()->getMessages() ) ] );
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
        
        return responseJsonOk( ['message' => $this->creationSuccessMsg] );
    }


}