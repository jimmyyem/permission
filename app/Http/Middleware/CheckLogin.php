<?php

namespace App\Http\Middleware;

use App\Http\Middleware\EncryptCookies as Middleware;
use App\Http\Service\AuthService;
use Closure;
use Illuminate\Http\Request;

class CheckLogin extends Middleware
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // check login
        $userInfo = app(AuthService::class)->getAuthInfo();
        if (is_null($userInfo)) {
            return response()->json([
                'code' => 10030,
                'msg' => '未登录',
                'data' => null,
            ]);
        }

        return $next($request);
    }
}
