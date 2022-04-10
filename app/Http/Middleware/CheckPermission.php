<?php

namespace App\Http\Middleware;

use App\Http\Middleware\CheckLogin as Middleware;
use App\Http\Service\AuthService;
use App\Models\UserRole;
use Closure;
use Illuminate\Http\Request;

class CheckPermission extends Middleware
{
    /**
     * 超管和普通管理员
     *
     * @var string[]
     */
    protected $adminGroups = [
        'super_admin',
        'admin',
    ];

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        [$group,] = explode('.', $request->route()->getName());

        // check login
        $userInfo = app(AuthService::class)->getAuthInfo();
        if (is_null($userInfo)) {
            return response()->json([
                'code' => 10020,
                'msg' => '未登录',
                'data' => null,
            ]);
        } else {
            if ($userInfo['expire'] > time()) {
                return response()->json([
                    'code' => 10021,
                    'msg' => '未登录',
                    'data' => null,
                ]);
            }
        }

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

        return $next($request);
    }
}
