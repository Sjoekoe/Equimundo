<?php
namespace EQM\Models\Wiki\Articles;

use EQM\Core\Slugs\SlugCreator;
use EQM\Models\Wiki\Topics\Topic;

class EloquentArticleRepository implements ArticleRepository
{
    /**
     * @var \EQM\Models\Wiki\Articles\EloquentArticle
     */
    private $article;

    public function __construct(EloquentArticle $article)
    {
        $this->article = $article;
    }

    /**
     * @param \EQM\Models\Wiki\Topics\Topic $topic
     * @param array $values
     * @return \EQM\Models\Wiki\Articles\Article
     */
    public function create(Topic $topic, array $values)
    {
        $article = new EloquentArticle();
        $article->title = $values['title'];
        $article->slug = (new SlugCreator())->createForArticle($values['title']);
        $article->body = $values['body'];
        $article->views = 0;
        $article->topic_id = $topic->id();

        $article->save();

        return $article;
    }

    /**
     * @param \EQM\Models\Wiki\Articles\Article $article
     * @param array $values
     * @return \EQM\Models\Wiki\Articles\Article
     */
    public function update(Article $article, array $values)
    {
        if (array_key_exists('title', $values)) {
            if ($values['title'] !== $article->title()) {
                $article->slug = (new SlugCreator())->createForArticle($values['title']);
            }

            $article->title = $values['title'];
        }

        if (array_key_exists('body', $values)) {
            $article->body = $values['body'];
        }
        
        if (array_key_exists('views', $values)) {
            $article->views = $values['views'];
        }

        $article->save();

        return $article;
    }

    /**
     * @param \EQM\Models\Wiki\Articles\Article $article
     */
    public function delete(Article $article)
    {
        $article->delete();
    }

    /**
     * @param string $slug
     * @return \EQM\Models\Wiki\Articles\Article|null
     */
    public function find($slug)
    {
        return $this->article->where('slug', $slug)->first();
    }

    /**
     * @param \EQM\Models\Wiki\Topics\Topic $topic
     * @param int $limit
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function findByTopicPaginated(Topic $topic, $limit = 10)
    {
        return $this->article
            ->where('topic_id', $topic->id())
            ->paginate($limit);
    }

    /**
     * @param string $slug
     * @return int
     */
    public function findSlugCount($slug)
    {
        return count($this->article->whereRaw("slug REGEXP '^{$slug}(-[0-9]*)?$'")->get());
    }
}
