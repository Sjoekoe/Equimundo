<?php
namespace EQM\Models\Competitions;

use Illuminate\Database\Eloquent\Model;

class EloquentCompetition extends Model implements Competition
{
    protected $table = self::TABLE;

    protected $fillable = ['email'];
    
    /**
     * @return mixed
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function email()
    {
        return $this->email;
    }
}
