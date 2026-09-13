<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        // Força HTTPS em ambiente de produção (Render)
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        // Garante a criação do banco de dados SQLite e executa as migrations no Docker
        if (config('database.default') === 'sqlite') {
            $dbPath = database_path('database.sqlite');
            if (!file_exists($dbPath)) {
                touch($dbPath);
                try {
                    \Illuminate\Support\Facades\Artisan::call('migrate --force');
                } catch (\Exception $e) {
                    // Ignora se as tabelas já existirem
                }
            }
        }
    }
}
