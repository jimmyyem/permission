<?php
/**
 * User resource.
 */

namespace App\Http\Controllers;

use App\Exceptions\BusiException;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function __construct()
    {
        $this->checkPermission();
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $offset = $request->input('offset');
        $list = User::query()->offset($offset)->limit($this->pageSize)->get()->toArray();

        return $this->json([
            'list' => $list,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(RegisterRequest $request)
    {
        $data = $request->validated();
        User::query()->create($data);

        return $this->json();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $user)
    {
        return $this->json($user->toArray());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, User $user)
    {
        $data = $request->all();
        if (! empty($data)) {
            $data['name'] && $user->name = $data['name'];
            $data['password'] && $user->password = $data['password'];
            $user->save();
        }

        return $this->json();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user)
    {
        $user->delete();

        return $this->json();
    }

    protected function checkPermission()
    {
        if (! Gate::allows('edit-post', $post)) {
            throw new BusiException('无权限访问', 10043);
        }
    }
}
