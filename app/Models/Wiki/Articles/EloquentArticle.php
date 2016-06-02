<?php
namespace EQM\Models\Wiki\Articles;

use EQM\Models\UsesTimeStamps;
use EQM\Models\Wiki\Topics\EloquentTopic;
use Illuminate\Database\Eloquent\Model;

class EloquentArticle extends Model implements Article
{
    use UsesTimeStamps;

    /**
     * @var string
     */
    protected $table = self::TABLE;

    /**
     * @var array
     */
    protected $fillable = ['title', 'body'];

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

    public function slug()
    {
        return $this->slug;
    }

    /**
     * @return string
     */
    public function body()
    {
        return $this->body;
    }

    /**
     * @return int
     */
    public function views()
    {
        return $this->views;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function topicRelation()
    {
        return $this->belongsTo(EloquentTopic::class, 'topic_id', 'id');
    }

    /**
     * @return \EQM\Models\Wiki\Topics\Topic
     */
    public function topic()
    {
        return $this->topicRelation()->first();
    }
}
