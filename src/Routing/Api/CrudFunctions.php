<?php

namespace Daylight\Routing\Api;

use Illuminate\Http\Request;
use Daylight\Routing\ValidateRequest;

trait CrudFunctions
{
	use ValidateRequest,
        CrudMessages;

    public function createOrFail($class, Request $request, boolean $returnModelInstance = false, array $rules = null)
    {
        $requestData = $request->all();

        $creationRules = !is_null($rule) ? $rules : (isset($this->creationRules) ? $this->creationRules : array());

        $validator = $this->validator($requestData, $creationRules);

        if ($validator->fails()) {
            return responseJsonUnprocessableEntity( ['message' => $this->contentCannotBeParsedMsg, 'errors' => shrinkValidationErrors( $validator->errors()->getMessages() ) ] );
        }

        if( method_exists($this, 'create') )
        {
            $modelInstance = $this->create($request);
        }else{
            $modelInstance = $class::create($requestData);
        }

        $response = ['message' => $this->creationSuccessMsg];

        if($returnModelInstance)
        {
            $response['data'] => $modelInstance->toArray();
        }

        return responseJsonOk( $response );
    }

	public function updateOrFail($class, $modelId, Request $request, boolean $returnModelInstance = false, array $rules = null)
    {
        $requestData = $request->all();

        $updateRules = !is_null($rule) ? $rules : (isset($this->updateRules) ? $this->updateRules : array());

        $validator = $this->validator($requestData, $updateRules);

        if ($validator->fails()) {
            return responseJsonUnprocessableEntity( ['message' => $this->contentCannotBeParsedMsg, 'errors' => shrinkValidationErrors( $validator->errors()->getMessages() ) ] );
        }

        if( method_exists($this, 'update') )
        {
        	$modelInstance = $this->update($request);
        }else{
            $modelInstance = $class::where('id', $modelId)->update($requestData);
        }

        $response = ['message' => $this->updateSuccessMsg];

        if($returnModelInstance)
        {
            $response['data'] => $modelInstance->toArray();
        }

        return responseJsonOk( $response );
    }

}