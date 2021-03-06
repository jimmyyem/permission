<?php

namespace App\Http\Middleware;

use App\Http\Middleware\EncryptCookies as Middleware;
use App\Http\Service\AuthService;
use App\Models\UserRole;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckLogin extends Middleware
{
    /**
     * super admin and admin group
     *
     * @var string[]
     */
    protected $adminGroups = [
        'super_admin',
        'admin',
    ];

    /**
     * not log in or do not have permission will return error.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $userInfo = app(AuthService::class)->getAuthInfo();
        if (is_null($userInfo)) {
            return response()->json([
                'code' => 10020,
                'msg' => '未登录',
                'data' => null,
            ]);
        } else {
            if ($userInfo['expire'] < time()) {
                return response()->json([
                    'code' => 10021,
                    'msg' => '未登录',
                    'data' => null,
                ]);
            }
        }
        Auth::loginUsingId($userInfo['user_id']);

        return $next($request);

        /**
         * 以下代码暂时注释掉，使用Gate实现，不使用diy的方式，不容易扩展权限
         */

        [$group,] = explode('.', $request->route()->getName());

        // check permission
        $userRole = UserRole::query()->where('user_id', $userInfo['user_id'])->join('roles', 'roles.id', '=', 'user_role.role_id')->first();
        switch ($group) {
            case 'user':
                if (empty($userRole) || ! in_array($userRole->slug, $this->adminGroups)) {
                    return response()->json([
                        'code' => 10022,
                        'msg' => '无权限访问',
                        'data' => null,
                    ]);
                }

                break;
            case 'post':
                $post = $request->route()->parameter('post');
                if (($post && $post->user_id == $userInfo['user_id']) || in_array($userRole->slug, $this->adminGroups)) {
                    //pass
                } else {
                    return response()->json([
                        'code' => 10023,
                        'msg' => '无权限访问',
                        'data' => null,
                    ]);
                }
                break;
        }
    }
}
