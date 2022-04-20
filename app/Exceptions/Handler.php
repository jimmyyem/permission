<?php

namespace App\Exceptions;

use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [//
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
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param $request
     * @param \Throwable $exception
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if (request()->ajax() || $request->expectsJson() || $request->wantsJson()) {
            if ($exception instanceof ValidationException) {
                Log::error("数据校验异常:".$exception->getMessage());

                return response()->json([
                    'code' => 10001,
                    'msg' => $exception->validator->errors()->first(),
                    'data' => [
                        'line' => __LINE__,
                        'error' => '数据校验异常',
                    ],
                ]);
            }

            if ($exception instanceof QueryException) {
                Log::error("数据库异常:".$exception->getMessage());

                return response()->json([
                    'code' => 10002,
                    'msg' => '操作失败了，请稍候重试',
                    'data' => [
                        'line' => __LINE__,
                        'error' => '数据库异常',
                    ],
                ]);
            }

            // Exception and BusiException
            Log::error($exception->getMessage());

            return response()->json([
                'code' => $exception->getCode(),
                'msg' => $exception->getMessage(),
                'data' => [
                    'line' => __LINE__,
                    'error' => 'unknown',
                ],
            ]);
        }

        return parent::render($request, $exception);
    }
}
