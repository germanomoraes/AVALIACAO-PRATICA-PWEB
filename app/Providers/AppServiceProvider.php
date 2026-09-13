<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Schema;
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
        // Força HTTPS em ambiente de produção (Render)
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        // Se o banco for SQLite, garante que o arquivo exista e roda as migrations
        if (config('database.default') === 'sqlite') {
            $dbPath = database_path('database.sqlite');
            if (!file_exists($dbPath)) {
                @touch($dbPath);
            }

            // Executa as migrations se a tabela principal 'users' ainda não existir
            try {
                if (!Schema::hasTable('users')) {
                    Artisan::call('migrate', ['--force' => true]);
                }
            } catch (\Exception $e) {
                // Previne crash de permissão temporária
            }
        }
    }
}