<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
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
        $this->renderable(function (Throwable $e, Request $request) {
            if ($request->is('api/*')) {
                if ($e instanceof HttpException) {
                    return response()->json([
                        'message' => $e->getMessage(),
                        'errors' => null
                    ], $e->getStatusCode());
                }

                if (!config('app.debug')) {
                    return response()->json([
                        'message' => 'Unexpected error, try later',
                        'errors' => null
                    ], 500);
                }
            }
        });
    }
}
