<?php

namespace Daylight\Http;

use Illuminate\Http\JsonResponse as IlluminateJsonResponse;
use Illuminate\Http\Response as IlluminateResponse;
use Daylight\Http\StatusCodesTrait as StatusCodes;

class Response
{
    use StatusCodes;

    private $_jsonHeaders = ['Content-Type' => 'application/json'];

    private $_jsonOptions = 0;

    public function __call($name, $arguments)
    {
        if(! in_array($name, ['response', 'jsonResponse']))
        {
            $statusCode = '_' . lcfirst($name);
            $responseType = 'response';
            if(substr($name, 0, 4) == 'json')
            {
                $statusCode = '_' . lcfirst(substr($name, 4, strlen($name)));
                $responseType = 'jsonResponse';
            }
            if( isset($statusCode) ){
                return $this->$responseType(self::$$statusCode, $arguments);
            }else{
                return 'no existe el metodo';
                $trace = debug_backtrace();
                trigger_error('Method ' . $name . ' must have an array as argument, on line ' . $trace[0]['line'], E_USER_NOTICE);
                return null;
            }
        }
    }

    public static function __callStatic($name, $arguments)
    {
        if(! in_array($name, ['response', 'jsonResponse']))
        {
            $statusCode = '_' . lcfirst($name);
            $responseType = 'response';

            if(substr($name, 0, 4) == 'json')
            {
                $statusCode = '_' . lcfirst(substr($name, 4, strlen($name)));
                $responseType = 'jsonResponse';
            }
            if( isset($statusCode) ){
                return call_user_func(array(new self, $responseType), self::$$statusCode, $arguments);
            }else{
                $trace = debug_backtrace();
                trigger_error('Method ' . $name . ' must have an array as argument, on line ' . $trace[0]['line'], E_USER_NOTICE);
                return null;
            }
        }
    }

    private function response($status, $arguments)
    {
        $content = isset($arguments[0]) ? $arguments[0] : '';
        $headers = isset($arguments[1]) ? $arguments[1] : [];
        $response = new IlluminateResponse($content, $status);
        foreach ($headers as $key => $value) {
            $response->header($key, $value, true);
        }
        return $response;
    }

    private function jsonResponse($status, $arguments)
    {
        $content = isset($arguments[0]) ? $arguments[0] : '';
        $headers = isset($arguments[1]) ? $arguments[1] : $this->_jsonHeaders;
        $headers = array_merge($this->_jsonHeaders, $headers);
        $options = isset($arguments[2]) ? $arguments[2] : $this->_jsonOptions;
        $response = new IlluminateJsonResponse($content, $status, [], $options);
        foreach ($headers as $key => $value) {
            $response->header($key, $value, true);
        }
        return $response;
    }
    
}