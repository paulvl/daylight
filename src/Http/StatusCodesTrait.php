<?php

namespace Daylight\Http;

trait StatusCodesTrait
{

	// Respuesta a un exitoso GET, PUT, PATCH o DELETE. Puede ser usado también para un POST que no resulta en una creación.
    private static $_ok                     = 200;
    
    // [Creada] Respuesta a un POST que resulta en una creación. Debería ser combinado con un encabezado Location, apuntando a la ubicación del nuevo recurso.
    private static $_created                    = 201;
    
    // [Sin Contenido] Respuesta a una petición exitosa que no devuelve un body (por ejemplo en una petición DELETE).
    private static $_noContent             = 204;
    
    // [No Modificada] Usado cuando el cacheo de encabezados HTTP está activo y el cliente puede usar datos cacheados.
    private static $_notModified           = 304;
    
    // [Petición Errónea] La petición está malformada, como por ejemplo, si el contenido no fue bien parseado. El error se debe mostrar también en el JSON de respuesta.
    private static $_badRequest                = 400;
    
    // [Sin autorización] Cuando los detalles de autenticación son inválidos o no son otorgados. También útil para disparar un popup de autorización si la API es usada desde un navegador.
    private static $_unauthorized           = 401;
    
    // [Prohibida] Cuando la autenticación es exitosa pero el usuario no tiene permiso al recurso en cuestión.
    private static $_forbidden              = 403;
    
    // [No encontrada] Cuando un recurso se solicita un recurso no existente.
    private static $_notFound              = 404;
    
    // [Método no permitido] Cuando un método HTTP que está siendo pedido no está permitido para el usuario autenticado.
    private static $_methodNotAllowed     = 405;
    
    // [Método no permitido] Cuando un método HTTP que está siendo pedido no está permitido para el usuario autenticado.
    private static $_notAcceptable         = 406;
    
    // [Conflicto] Cuando hay algún conflicto al procesar una petición, por ejemplo en PATCH, POST o DELETE.
    private static $_conflict               = 409;
    
    // [Retirado] Indica que el recurso en ese endpoint ya no está disponible. Útil como una respuesta en blanco para viejas versiones de la API.
    private static $_gone                   = 410;
    
    // [Tipo de contenido no soportado] Si el tipo de contenido que solicita la petición es incorrecto.
    private static $_unsupportedMediaType = 415;
    
    // [Entidad improcesable] Utilizada para errores de validación, o cuando por ejemplo faltan campos en una petición.
    private static $_unprocessableEntity   = 422;
    
    // [Demasiadas peticiones] Cuando una petición es rechazada debido a la tasa límite.
    private static $_tooManyRequests      = 429;
    
    // [Error Interno del servidor] Los desarrolladores de API NO deberían usar este código. En su lugar se debería loguear el fallo y no devolver respuesta.
    private static $_internalServerError  = 500;
    
    // [Servicio no disponible] Los servidores están activos, pero saturados con solicitudes.
    private static $_serviceUnavailable        = 503;
}