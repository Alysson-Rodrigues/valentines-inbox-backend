<?php

namespace App\Modules\Posts\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    const VISIBILITY = [
        1 => 'Draft',
        2 => 'Published',
        3 => 'Scheduled',
    ];

    const TYPES = [
        1 => 'Feed',
        2 => 'Community',
        3 => 'Pack Fragment',
    ];

    const COMMENTABLE_TYPES = [
        1 => 'Only followers',
        2 => 'Only me',
        3 => 'Public',
        4 => 'Followers and friends',
        5 => 'Pack Buyers',
    ];

    protected $fillable = [
        'user_id',
        'commentable_type',
        'visibility',
        'type',
        'title',
        'slug',
        'excerpt',
        'body'
    ];
}
