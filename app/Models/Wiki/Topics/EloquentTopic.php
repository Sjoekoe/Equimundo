<?php
namespace EQM\Models\Wiki\Topics;

use EQM\Models\UsesTimeStamps;
use Illuminate\Database\Eloquent\Model;

class EloquentTopic extends Model implements Topic
{
    use UsesTimeStamps;

    /**
     * @var string
     */
    protected $table = self::TABLE;

    /**
     * @var array
     */
    protected $fillable = ['title'];

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
    public function title()
    {
        return $this->title;
    }
}
