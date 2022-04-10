<?php

namespace App\Http\Controllers;

use App\Http\Service\AuthService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var int
     */
    protected $pageSize = 15;

    /**
     * @var
     */
    protected $user_id;

    /**
     * return json format data.
     *
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function json($data = null)
    {
        return response()->json([
            'code' => 0,
            'msg' => 'success',
            'data' => $data,
        ]);
    }

    /**
     * check if already login.
     *
     * @return bool
     */
    protected function checkLogin()
    {
        $userInfo = app(AuthService::class)->getAuthInfo();

        if (is_array($userInfo) && ! empty($userInfo)) {
            $this->user_id = $userInfo['user_id'];

            return true;
        }

        return false;
    }
}
