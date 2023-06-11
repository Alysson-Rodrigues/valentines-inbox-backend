<?php

namespace App\Modules\Posts\Repositories;

use App\Bootstrap\Repositories\Repository;
use App\Modules\Posts\Models\Post;

class PostRepository extends Repository
{
    /**
     * PostsRepository constructor.
     * @param Post $model
     */
    public function __construct(Post $model)
    {
        parent::__construct($model);
    }

    public function fetchFromUser($user)
    {
        return $this->model
            ->newQuery()
            ->where('user_id', $user)
            ->orderByDesc('created_at')
            ->paginate(10);
    }

    public function getBySlug($slug)
    {
        return $this->model
            ->newQuery()
            ->where('slug', $slug)
            ->first();
    }
}
