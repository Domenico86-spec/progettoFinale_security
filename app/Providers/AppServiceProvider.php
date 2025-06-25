<?php

namespace App\Providers;

use App\Models\Tag;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if(Schema::hasTable('categories')){
            $categories = Category::all();
            View::share(['categories' => $categories]);
        }
        if(Schema::hasTable('tags')){
            $tags = Tag::all();
            View::share(['tags' => $tags]);
        }



        // Aggiunto per limitare le richieste

        RateLimiter::for('global', function (Request $request) {
        return Limit::perMinute(10)->by($request->ip())->response(function () {
        return response('Troppe richieste di ricerca.', 429);

            });
         });


          RateLimiter::for('articleSearch', function (Request $request) {
    return Limit::perMinute(30)->by($request->ip())->response(function () {
        return response('Troppe richieste di ricerca.', 429);

            });
        });








    }
}


