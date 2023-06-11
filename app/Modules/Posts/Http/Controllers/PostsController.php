<?php

namespace App\Modules\Posts\Http\Controllers;

use App\Bootstrap\Http\Controllers\Controller;
use App\Modules\Users\Models\User;
use App\Modules\Posts\Models\Post;
use App\Modules\Posts\Repositories\PostRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Bootstrap\Traits\SlugMaker;

class PostsController extends Controller
{
    private $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function index(User $user)
    {
        $user = auth()->user();

        if (!$user) {
            abort(403);
        }

        $posts = $this->postRepository->fetchFromUser(
            $user->id,
        );

        return response(
            $posts,
            200
        );

    }

    public function getBySlug ($slug){
        $post = $this->postRepository->getBySlug($slug);

        return response(
            $post,
            200
        );
    }

    public function show (Post $post)
    {
        return response(
            $post,
            200
        );
    }

    public function update(Post $post, Request $request)
    {
        if ($post->user_id !== auth()->user()->id) {
            abort(403);
        }

        $inputs = $request->all();

        $this->postRepository->update($post, $inputs);

        return response(
            json_encode(
                [
                    'message' => 'Post updated successfully',
                    'post' => $post
                ]
            ),
            200
        );
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            abort(403,
            "You must be logged in to create a post."
            );
        }

        if (!$request->has('title') || !$request->has('body')) {
            abort(400);
        }
        
        $inputs = $request->all();

        $inputs['user_id'] = auth()->user()->id;

        $inputs['slug'] = SlugMaker::make($inputs['title']);

        $post = $this->postRepository->create($inputs);

        return response(
            json_encode(
                [
                    'message' => 'Post created successfully',
                    'post' => $post
                ]
            ),
            200
        );
    }

    public function destroy(Post $post)
    {
        if (!Auth::check()) {
            abort(403,
            "You must be logged in to delete a post."
            );
        }

        if ($post->user_id !== auth()->user()->id) {
            abort(403);
        }
        $this->postRepository->destroy($post);
        return redirect()->back();
    }
}
