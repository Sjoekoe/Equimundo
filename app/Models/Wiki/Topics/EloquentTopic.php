<?php
namespace EQM\Models\Wiki\Topics;

use EQM\Models\UsesTimeStamps;
use EQM\Models\Wiki\Articles\EloquentArticle;
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articleRelation()
    {
        return $this->hasMany(EloquentArticle::class, 'topic_id', 'id');
    }

    /**
     * @return \EQM\Models\Wiki\Articles\Article[]
     */
    public function articles()
    {
        return $this->articleRelation()->get();
    }
}
