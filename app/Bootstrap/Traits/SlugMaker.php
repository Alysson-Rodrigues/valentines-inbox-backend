<?php

namespace App\Bootstrap\Traits;

use Illuminate\Support\Str;

trait SlugMaker
{
    /**
     * @param $title
     * @return string
     */
    public static function make($title)
    {
        $slug = Str::slug($title, '-');
        $slug .= '-' . time();
        return $slug;
    }
}