<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (NotFoundHttpException $e, $request) {
            if($request->is('api/products/*')){
                return response()->json([
                    'status' => false,
                    'message' => '¡The selected product id is invalid!'
                ], 404);
            }
            if($request->is('api/categories/*')){
                return response()->json([
                    'status' => false,
                    'message' => '¡The selected category id is invalid!'
                ], 404);
            }
            if($request->is('api/providers/*')){
                return response()->json([
                    'status' => false,
                    'message' => '¡The selected provider id is invalid!'
                ], 404);
            }
        });


    }
}
