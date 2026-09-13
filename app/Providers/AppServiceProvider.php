<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Artisan;

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
        // Garante a existência física do arquivo de banco de dados
        $dbPath = database_path('database.sqlite');
        if (!file_exists($dbPath)) {
            @mkdir(dirname($dbPath), 0755, true);
            @touch($dbPath);
        }

        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        // Executa as migrations automaticamente
        try {
            Artisan::call('migrate', ['--force' => true]);
        } catch (\Exception $e) {
            // Ignora se as tabelas já existirem
        }
    }
}