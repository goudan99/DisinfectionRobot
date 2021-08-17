<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;
use App\Exceptions\AttachException;
use App\Exceptions\AuthException;
use App\Exceptions\NotFoundException;
use App\Exceptions\UniqueException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
		AttachException::class,
		AuthException::class,
		NotFoundException::class,
		UniqueException::class
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
        $this->reportable(function (Throwable $e) {
            //
        });
    }
	
    protected function invalidJson($request, ValidationException $exception)
    {
        return response()->json([
			'code'=>$exception->status,
            'msg' => '数据验证不正确',
            'error' => $exception->errors(),
			'data'=>''
        ], 200);
    }
}
