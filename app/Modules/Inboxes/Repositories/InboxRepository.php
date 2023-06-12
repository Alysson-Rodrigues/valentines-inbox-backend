<?php

namespace App\Modules\Inboxes\Repositories;

use App\Bootstrap\Repositories\Repository;
use App\Modules\Inboxes\Models\Inbox;

class InboxRepository extends Repository
{
    /**
     * InboxesRepository constructor.
     * @param Inbox $model
     */
    public function __construct(Inbox $model)
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
