<?php
namespace EQM\Core\Database;

use Closure;
use DB;

class EloquentTransactionManager implements TransactionManager
{
    /**
     * @param \Closure $callback
     * @return mixed
     */
    public function transaction(Closure $callback)
    {
        DB::beginTransaction();
        try {
            $result = $callback();
            DB::commit();

            return $result;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
