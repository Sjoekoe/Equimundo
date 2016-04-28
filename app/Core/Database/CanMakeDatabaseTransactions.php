<?php
namespace EQM\Core\Database;

use Closure;

trait CanMakeDatabaseTransactions
{
    /**
     * @var \EQM\Core\Database\TransactionManager
     */
    protected $transactionManager;
    
    /**
     * @param \Closure $callback
     * @return mixed
     */
    public function transaction(Closure $callback)
    {
        return $this->transactionManager->transaction($callback);
    }
}
