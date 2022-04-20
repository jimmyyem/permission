<?php
/**
 * Post resource.
 */

namespace App\Http\Controllers;

use App\Exceptions\BusiException;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $offset = $request->input('offset');
        $list = Post::query()->offset($offset)->limit($this->pageSize)->get()->toArray();

        return $this->json([
            'list' => $list,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\PostRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PostRequest $request)
    {
        $data = $request->validated();
        Post::query()->create($data);

        return $this->json();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Post $post)
    {
        return $this->json($post->toArray());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Post $post)
    {
        $this->checkPermission();

        $data = $request->all();
        if (! empty($data)) {
            $data['user_id'] && $post->user_id = $data['user_id'];
            $data['title'] && $post->title = $data['title'];
            $data['body'] && $post->body = $data['body'];
            $post->save();
        }

        return $this->json();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Post $post)
    {
        $this->checkPermission();

        $post->delete();

        return $this->json();
    }

    protected function checkPermission()
    {
        if (! Gate::allows('edit-post', $post)) {
            throw new BusiException('无权限访问', 10043);
        }
    }
}
