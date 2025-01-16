<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof UsuarioNotFoundException) {
            return response()->json(['message' => $exception->getMessage()], $exception->getCode());
        }

        if ($exception instanceof UsuarioCreationException) {
            return response()->json(['message' => $exception->getMessage()], $exception->getCode());
        }

        Log::error('Erro.', [
            'endpoint' => $request->path(),
            'method' => $request->method(),
            'request_data' => $request->except(['senha', 'password']),
            'exception' => get_class($exception),
            'message' => $exception->getMessage(),
        ]);

        return parent::render($request, $exception);
    }
}
