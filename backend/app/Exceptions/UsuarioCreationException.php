<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class UsuarioCreationException extends Exception
{
    protected $message = 'Falha ao criar usuário';
    protected $code = Response::HTTP_INTERNAL_SERVER_ERROR;
}
