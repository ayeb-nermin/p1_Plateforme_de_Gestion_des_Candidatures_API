<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
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

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable               $exception
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof AuthenticationException) {
            return responseApi(401, [], __('messages.errors.unauthorized'));
        }

        if ($exception instanceof AuthorizationException) {
            Log::error("HANDLER AuthorizationException : ". $exception->getMessage());

            return responseApi(403, [], __('messages.errors.permission_denied'));
        }

        if ($exception instanceof ThrottleRequestsException) {
            Log::error("HANDLER ThrottleRequestsException : ". $exception->getMessage());

            return responseApi($exception->getStatusCode(), [], $exception->getMessage());
        }

        if ($exception instanceof ModelNotFoundException) {
            Log::error("HANDLER ModelNotFoundException : ". $exception->getMessage());

            return responseApi(404, [], __('messages.errors.data_not_found'));
        }

        if ($exception instanceof NotFoundHttpException) {
            Log::error("HANDLER NotFoundHttpException : ". $exception->getMessage());

            return responseApi(404, [], __('messages.errors.route_not_found'));
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            Log::error("HANDLER MethodNotAllowedHttpException : ". $exception->getMessage());

            return responseApi(404, [], __('messages.errors.invalid_method'));
        }

        // if ($exception instanceof ValidationException) {
        //     Log::error("HANDLER ValidationException : ". $exception->getMessage());

        //     return responseApi(404, [], __('messages.errors.invalid_method'));
        // }

        if (config('app.env') != 'local') {
            if ($exception instanceof Throwable) {
                if (isset($exception->status)) {
                    if ($exception->status == 422) {
                        return responseApi($exception->status, [], __('messages.errors.validation_failed'), $exception->errors());
                    }
                }
                Log::error("HANDLER Throwable : ". $exception->getMessage());

                return responseApi(500, [], __('messages.errors.system_error'));
            }
        }

        return parent::render($request, $exception);
    }

    protected function invalidJson($request, ValidationException $exception)
    {
        return responseApi($exception->status, [], __('messages.errors.validation_failed'), $exception->errors());
    }
}
