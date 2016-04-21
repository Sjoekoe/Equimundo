<?php
namespace EQM\Core\Database;

use Illuminate\Support\ServiceProvider;

class DatabaseServiceProvider extends ServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = true;
    public function register()
    {
        $this->app->singleton(TransactionManager::class, function() {
            return new EloquentTransactionManager();
        });
    }
    /**
     * @return array
     */
    public function provides()
    {
        return [
            TransactionManager::class,
        ];
    }
}
