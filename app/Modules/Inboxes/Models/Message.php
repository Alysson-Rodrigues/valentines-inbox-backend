<?php

namespace App\Modules\Inboxes\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'target_inbox_id',
        'author',
        'title',
        'content',
    ];

    public function targetInbox()
    {
        return $this->belongsTo(Inbox::class, 'target_inbox_id');
    }
}
