<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    // public function render($request, Throwable $exception)
    // {
    //     if ($exception instanceof ModelNotFoundException || $exception instanceof NotFoundHttpException) {
    //         return response()->view('errors.404', [], 404);
    //     }

    //     if ($exception instanceof HttpException) {
    //         return response()->view("errors.{$exception->getStatusCode()}", [], $exception->getStatusCode());
    //     }

    //     return response()->view('errors.500', [], 500);
    // }
}
