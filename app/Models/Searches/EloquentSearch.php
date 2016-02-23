<?php
namespace EQM\Models\Searches;

use Illuminate\Database\Eloquent\Model;

class EloquentSearch extends Model implements Search
{
    protected $table = self::TABLE;

    /**
     * @return int
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function term()
    {
        return $this->term;
    }

    /**
     * @return int
     */
    public function count()
    {
        return $this->count;
    }

    /**
     * @return int
     */
    public function currentResults()
    {
        return $this->current_results;
    }
}
