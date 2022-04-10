<?php

namespace App\Exceptions;

use Exception;

class BusiException extends Exception
{
    /**
     * @param $message
     * @param $code
     * @param \Throwable|null $previous
     */
    public function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function render()
    {
        return response()->json([
            'code' => $this->getCode(),
            'msg' => $this->getMessage(),
            'data' => null,
        ]);
    }
}
