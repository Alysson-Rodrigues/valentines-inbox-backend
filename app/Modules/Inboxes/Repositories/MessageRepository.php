<?php

namespace App\Modules\Inboxes\Repositories;

use App\Bootstrap\Repositories\Repository;
use App\Modules\Inboxes\Models\Message;

class MessageRepository extends Repository
{
    /**
     * MessageRepository constructor.
     * @param Message $model
     */
    public function __construct(Message $model)
    {
        parent::__construct($model);
    }

    public function fetchFromInbox($inbox)
    {
        return $this->model
            ->newQuery()
            ->where('target_inbox_id', $inbox)
            ->orderByDesc('created_at')
            ->paginate(10);
    }

    public function attachOnInbox($inboxId, $message)
    {
        $message = Message::create($message);
        $message->target_inbox_id = $inboxId;
        $message->save();
    }

}
