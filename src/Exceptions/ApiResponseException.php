<?php

namespace Ipunkt\Fileproxy\Exceptions;

use Psr\Http\Message\ResponseInterface;

class ApiResponseException extends \RuntimeException
{
    public static function fromErrorResponse(ResponseInterface $response)
    {
        $data = json_decode( $response->getBody(), true );

        $errors = array_get($data, 'errors', array());

        $error = current($errors);

        return new static(array_get($error, 'title'), array_get($error, 'code'));
    }
}