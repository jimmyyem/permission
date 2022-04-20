<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //定义一个权限，用到的地方判断下 allows 即可
        // 用户要求是超级管理员或者普通管理员
        Gate::define('user', function ($user) {
            return $user->isSuperAdmin() || $user->isAdmin();
        });

        // 本人或者普通管理员可编辑帖子
        Gate::define('post', function ($user, $post) {
            return $user->id == $post->user_id || $user->isAdmin();
        });
    }
}
