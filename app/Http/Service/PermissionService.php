<?php

namespace App\Http\Service;

use App\Models\UserRole;

class PermissionService
{
    /**
     * 判断用户是否有权限进行操作
     * @param $type
     * @return void
     */
    public function allow($type = 'user')
    {

    }

    protected function getUserInfo()
    {
        $find = UserRole::query()->where('user_id', $user_id)->get();

    }
}