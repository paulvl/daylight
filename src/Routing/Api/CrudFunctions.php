<?php

namespace Daylight\Routing\Api;

use Illuminate\Http\Request;
use Daylight\Routing\ValidateRequest;
use Daylight\Routing\ExecutionError;

trait CrudFunctions
{
	use ValidateRequest,
        CrudMessages;

    public function createOrFail($class, Request $request, $returnModelInstance = false, array $rules = array())
    {
        $requestData = $request->all();

        $creationRules = count($rules) > 0 ? $rules : (isset($this->creationRules) ? $this->creationRules : array());

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

        if($returnModelInstance === true)
        {
            $response['data'] = $modelInstance->toArray();
        }

        return responseJsonOk( $response );
    }

	public function updateOrFail($class, $modelId, Request $request, $returnModelInstance = false, array $rules = array())
    {
        $requestData = $request->all();

        $updateRules = count($rules) > 0 ? $rules : (isset($this->updateRules) ? $this->updateRules : array());

        $validator = $this->validator($requestData, $updateRules);

        if ($validator->fails()) {
            return responseJsonUnprocessableEntity( ['message' => $this->contentCannotBeParsedMsg, 'errors' => shrinkValidationErrors( $validator->errors()->getMessages() ) ] );
        }

        if( method_exists($this, 'update') )
        {
        	$modelInstance = $this->update($request, $modelId);
        }else{
            $modelInstance = $class::find($modelId);
            foreach ($requestData as $key => $value) {
                $modelInstance->$key = $value;
            }
            $modelInstance->save();
        }

        if($modelInstance instanceof ExecutionError)
        {
            $response = ['message' => $modelInstance->message];

            if($returnModelInstance === true)
            {
                $response['data'] = $modelInstance->data->toArray();
            }

            return responseJsonForbidden($response);
        }

        $response = ['message' => $this->updateSuccessMsg];

        if($returnModelInstance === true)
        {
            $response['data'] = $modelInstance->toArray();
        }

        return responseJsonOk( $response );
    }

}