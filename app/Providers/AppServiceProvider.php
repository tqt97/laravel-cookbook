<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Str;

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
        Str::macro('readingTime', function (string $subject, $wordsPerMinute = 200) {
            $words = str_word_count(strip_tags($subject));
            $plural = $words > 1 ? 's' : '';

            return $words.' words, '.intval(ceil($words / $wordsPerMinute))." minute{$plural} read";
        });
    }
}
