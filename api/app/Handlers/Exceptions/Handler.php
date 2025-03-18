<?php

namespace App\Handlers\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class Handler
{
    public function render($request, Throwable $exception): JsonResponse
    {
        $status = 500;
        $message = 'Something went wrong';

        switch (true) {
            case $exception instanceof AuthenticationException:
                $status = 401;
                $message = $exception->getMessage();
                break;

            case $exception instanceof AuthorizationException:
                $status = 403;
                $message = 'Forbidden';
                break;

            case $exception instanceof ValidationException:
                $status = 422;
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $exception->errors(),
                ], $status);

            case $exception instanceof ModelNotFoundException:
                $status = 404;
                $message = 'Resource not found';
                break;

            case $exception instanceof NotFoundHttpException:
                $status = 404;
                $message = 'Endpoint not found';
                break;

            case $exception instanceof MethodNotAllowedHttpException:
                $status = 405;
                $message = 'Method not allowed';
                break;

            case $exception instanceof QueryException:
                $status = 500;
                $message = 'Database query error';
                break;

            case $exception instanceof TokenMismatchException:
                $status = 419;
                $message = 'CSRF token mismatch';
                break;

            case $exception instanceof ThrottleRequestsException:
                $status = 429;
                $message = 'Too many requests';
                break;

            case $exception instanceof FileNotFoundException:
                $status = 500;
                $message = 'File not found';
                break;

            case $exception instanceof HttpException:
                $status = $exception->getStatusCode();
                $message = $exception->getMessage() ?: 'HTTP error';
                break;
        }

        $body = [
            'message' => $message
        ];

        if(config('app.debug')){
            $body['error'] = $exception->getMessage();
            $body['trace'] = $exception->getTraceAsString();
        }

        return response()->json($body, $status);
    }
}
