<?php

use Daylight\Http\Response;

if (! function_exists('responseOk')) {
	function responseOk($content, array $headers = []){
		return Response::Ok($content, $headers);
	}
}

if (! function_exists('responseCreated')) {
	function responseCreated($content, array $headers = []){
		return Response::Created($content, $headers);
	}
}

if (! function_exists('responseNoContent')) {
	function responseNoContent($content, array $headers = []){
		return Response::NoContent($content, $headers);
	}
}

if (! function_exists('responseNotModified')) {
	function responseNotModified($content, array $headers = []){
		return Response::NotModified($content, $headers);
	}
}

if (! function_exists('responseBadRequest')) {
	function responseBadRequest($content, array $headers = []){
		return Response::BadRequest($content, $headers);
	}
}

if (! function_exists('responseUnauthorized')) {
	function responseUnauthorized($content, array $headers = []){
		return Response::Unauthorized($content, $headers);
	}
}

if (! function_exists('responseForbidden')) {
	function responseForbidden($content, array $headers = []){
		return Response::Forbidden($content, $headers);
	}
}

if (! function_exists('responseNotFound')) {
	function responseNotFound($content, array $headers = []){
		return Response::NotFound($content, $headers);
	}
}

if (! function_exists('responseMethodNotAllowed')) {
	function responseMethodNotAllowed($content, array $headers = []){
		return Response::MethodNotAllowed($content, $headers);
	}
}

if (! function_exists('responseNotAcceptable')) {
	function responseNotAcceptable($content, array $headers = []){
		return Response::NotAcceptable($content, $headers);
	}
}

if (! function_exists('responseConflict')) {
	function responseConflict($content, array $headers = []){
		return Response::Conflict($content, $headers);
	}
}

if (! function_exists('responseGone')) {
	function responseGone($content, array $headers = []){
		return Response::Gone($content, $headers);
	}
}

if (! function_exists('responseUnsupportedMediaType')) {
	function responseUnsupportedMediaType($content, array $headers = []){
		return Response::UnsupportedMediaType($content, $headers);
	}
}

if (! function_exists('responseUnprocessableEntity')) {
	function responseUnprocessableEntity($content, array $headers = []){
		return Response::UnprocessableEntity($content, $headers);
	}
}

if (! function_exists('responseTooManyRequests')) {
	function responseTooManyRequests($content, array $headers = []){
		return Response::TooManyRequests($content, $headers);
	}
}

if (! function_exists('responseInternalServerError')) {
	function responseInternalServerError($content, array $headers = []){
		return Response::InternalServerError($content, $headers);
	}
}

if (! function_exists('responseServiceUnavailable')) {
	function responseServiceUnavailable($content, array $headers = []){
		return Response::ServiceUnavailable($content, $headers);
	}
}


if (! function_exists('responseJsonOk')) {
	function responseJsonOk($content, array $headers = [], $options = 0){
		return Response::jsonOk($content, $headers, $options);
	}
}

if (! function_exists('responseJsonCreated')) {
	function responseJsonCreated($content, array $headers = [], $options = 0){
		return Response::jsonCreated($content, $headers, $options);
	}
}

if (! function_exists('responseJsonNoContent')) {
	function responseJsonNoContent($content, array $headers = [], $options = 0){
		return Response::jsonNoContent($content, $headers, $options);
	}
}

if (! function_exists('responseJsonNotModified')) {
	function responseJsonNotModified($content, array $headers = [], $options = 0){
		return Response::jsonNotModified($content, $headers, $options);
	}
}

if (! function_exists('responseJsonBadRequest')) {
	function responseJsonBadRequest($content, array $headers = [], $options = 0){
		return Response::jsonBadRequest($content, $headers, $options);
	}
}

if (! function_exists('responseJsonUnauthorized')) {
	function responseJsonUnauthorized($content, array $headers = [], $options = 0){
		return Response::jsonUnauthorized($content, $headers, $options);
	}
}

if (! function_exists('responseJsonForbidden')) {
	function responseJsonForbidden($content, array $headers = [], $options = 0){
		return Response::jsonForbidden($content, $headers, $options);
	}
}

if (! function_exists('responseJsonNotFound')) {
	function responseJsonNotFound($content, array $headers = [], $options = 0){
		return Response::jsonNotFound($content, $headers, $options);
	}
}

if (! function_exists('responseJsonMethodNotAllowed')) {
	function responseJsonMethodNotAllowed($content, array $headers = [], $options = 0){
		return Response::jsonMethodNotAllowed($content, $headers, $options);
	}
}

if (! function_exists('responseJsonNotAcceptable')) {
	function responseJsonNotAcceptable($content, array $headers = [], $options = 0){
		return Response::jsonNotAcceptable($content, $headers, $options);
	}
}

if (! function_exists('responseJsonConflict')) {
	function responseJsonConflict($content, array $headers = [], $options = 0){
		return Response::jsonConflict($content, $headers, $options);
	}
}

if (! function_exists('responseJsonGone')) {
	function responseJsonGone($content, array $headers = [], $options = 0){
		return Response::jsonGone($content, $headers, $options);
	}
}

if (! function_exists('responseJsonUnsupportedMediaType')) {
	function responseJsonUnsupportedMediaType($content, array $headers = [], $options = 0){
		return Response::jsonUnsupportedMediaType($content, $headers, $options);
	}
}

if (! function_exists('responseJsonUnprocessableEntity')) {
	function responseJsonUnprocessableEntity($content, array $headers = [], $options = 0){
		return Response::jsonUnprocessableEntity($content, $headers, $options);
	}
}

if (! function_exists('responseJsonTooManyRequests')) {
	function responseJsonTooManyRequests($content, array $headers = [], $options = 0){
		return Response::jsonTooManyRequests($content, $headers, $options);
	}
}

if (! function_exists('responseJsonInternalServerError')) {
	function responseJsonInternalServerError($content, array $headers = [], $options = 0){
		return Response::jsonInternalServerError($content, $headers, $options);
	}
}

if (! function_exists('responseJsonServiceUnavailable')) {
	function responseJsonServiceUnavailable($content, array $headers = [], $options = 0){
		return Response::jsonServiceUnavailable($content, $headers, $options);
	}
}

