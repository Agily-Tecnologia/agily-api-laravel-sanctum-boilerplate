<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
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
        $this->renderable(function (\Exception $e, $request) {
            if ($request->is("api/*")) {
                if ($e instanceof ValidationException) {
                    return response()->json($e->errors(), $e->status);
                }

                if ($e instanceof AuthenticationException) {
                    return response()->json($e->getMessage(), 401);
                }

                $statusCode = !empty($e->getCode()) ? $e->getCode() : 500;
                $statusCode = !empty($e->getStatusCode()) ? $e->getStatusCode() : $statusCode;
                $statusCode = !empty($e->status) ? $e->status : $statusCode;

                return response()->json($e->getMessage(), $statusCode);
            }
        });

        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
