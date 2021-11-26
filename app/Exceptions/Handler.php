<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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
    public function render($request, Throwable $exception)
    {
        // Custom render.
        if ($exception instanceof QueryException) {
            return response()->view('errors.query', [], 500);
        }

        // Add extra custom render.
//        if ($exception instanceof ModelNotFoundException) {
//            return response()->view('errors.not_found', [], 500);
//        }

        // Default render.
        return parent::render($request, $exception);
    }
}
