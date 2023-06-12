<?php

namespace App\Modules\Inboxes\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    public function boot()
    {
    }

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }
}
