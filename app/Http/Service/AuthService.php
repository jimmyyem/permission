<?php
/**
 * 登录、验证相关
 */

namespace App\Http\Service;

use App\Models\UserRole;
use Illuminate\Support\Facades\Crypt;

class AuthService
{
    /**
     * get online user info from header['Authorization']
     * @return array|null
     */
    public function getAuthInfo()
    {
        $authorization = request()->header('authorization');
        if (empty($authorization)) {
            return null;
        }

        $plain = Crypt::decrypt($authorization);
        [$user_id, $expire] = explode('|||', $plain);
        if (empty($user_id) || time() > $expire) {
            return null;
        }

        return [
            'user_id' => $user_id,
            'expire' => $expire,
        ];
    }

    /**
     * 判断用户是否有权限进行操作
     *
     * @param $type
     * @return void
     */
    public function allow($type = 'user')
    {

    }
}