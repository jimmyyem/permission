<?php
/**
 * register and login.
 *
 */

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class AuthController extends Controller
{
    /**
     * 注册用户
     *
     * @param \App\Http\Requests\RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $params = $request->validated();
        User::query()->create([
            'name' => $params['name'],
            'email' => $params['email'],
            'password' => $params['password'],
        ]);

        return $this->json();
    }

    /**
     * 登录
     *
     * @param \App\Http\Requests\LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $params = $request->validated();
        if (! Auth::attempt(['email' => $params['email'], 'password' => $params['password']], false)) {
            return $this->json(10010, '用户名或密码错误');
        }

        $expire = time() + 3600;
        $plain = sprintf('%s|||%s', Auth::id(), $expire);

        return $this->json([
            'access_token' => Crypt::encrypt($plain),
            'expire' => $expire,
        ]);
    }
}
