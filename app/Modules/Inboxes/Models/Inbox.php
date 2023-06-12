<?php

namespace App\Modules\Inboxes\Models;

use Illuminate\Database\Eloquent\Model;

class Inbox extends Model
{
    protected $fillable = [
        'magic_link',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
