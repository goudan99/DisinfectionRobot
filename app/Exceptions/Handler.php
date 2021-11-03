<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Throwable;
use App\Exceptions\AttachException;
use App\Exceptions\AuthException;
use App\Exceptions\NotFoundException;
use App\Exceptions\UniqueException;
use Illuminate\Support\Arr;

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
	
	/*重新格式化成定义的格式*/
    protected function invalidJson($request, ValidationException $exception)
    {
        return response()->json([
			'code'=>$exception->status,
            'msg' => $exception->getMessage(),
            'data' => $exception->errors(),
			'timestamp' => time()
        ], 200);
    }

	//401显示
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $request->expectsJson() ? 
				response()->json([
					'code' => 401,
					'msg'  => "用户未登录",
					'data' => [],
					'timestamp' => time()
				], 200): 
				redirect()->guest($exception->redirectTo() ?? route('login'));
    }
	
	/*重新格式化成定义的格式*/
    protected function convertExceptionToArray(Throwable $e)
    {
        return config('app.debug') ? [
            'message' => $e->getMessage(),
            'exception' => get_class($e),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => collect($e->getTrace())->map(function ($trace) {
                return Arr::except($trace, ['args']);
            })->all(),
        ] : [
			'code'=>  $this->isHttpException($e)? $e->getStatusCode() : 500,
            'msg' =>  $this->isHttpException($e) ? $e->getMessage() : 'Server Error',
            'data' => [],
			'timestamp' => time()
        ];
    }
	
    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        if ($e->response) {
            return $e->response;
        }

        return $request->expectsJson()
                    ?response()->json([
						'code'=>$e->status,
						'msg' => "验证不通过",
						'data' => $e->errors(),
						'timestamp' => time()
					], 200): $this->invalid($request, $e);
    }
}
