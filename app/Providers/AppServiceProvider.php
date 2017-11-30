<?php

namespace App\Providers;

use App\Http\View\RiotTag;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Prooph\Common\Messaging\FQCNMessageFactory;
use Prooph\Common\Messaging\MessageFactory;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('riotTag', function ($tag) {
            return (new RiotTag)->render($tag);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(MessageFactory::class, FQCNMessageFactory::class);
    }


}
