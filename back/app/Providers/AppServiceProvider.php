<?php

namespace App\Providers;

use App\Rules\ReCaptcha;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Validator::extend('recaptcha', ReCaptcha::class . '@passes');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (!Collection::hasMacro('paginate')) {

            // Enable pagination for collection
            Collection::macro('paginate',
                function ($perPage = 10, $page = null, $options = []) {
                    $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
                    return (new LengthAwarePaginator(
                        $this->forPage($page, $perPage)->values()->all(),
                        $this->count(),
                        $perPage,
                        $page,
                        $options
                    ))
                        ->withPath('');
                });
        }
    }
}
