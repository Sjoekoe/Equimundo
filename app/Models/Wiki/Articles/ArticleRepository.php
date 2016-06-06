<?php
namespace EQM\Models\Wiki\Articles;

use EQM\Models\Wiki\Topics\Topic;

interface ArticleRepository
{
    /**
     * @param \EQM\Models\Wiki\Topics\Topic $topic
     * @param array $values
     * @return \EQM\Models\Wiki\Articles\Article
     */
    public function create(Topic $topic, array $values);
    
    /**
     * @param \EQM\Models\Wiki\Articles\Article $article
     * @param array $values
     * @return \EQM\Models\Wiki\Articles\Article
     */
    public function update(Article $article, array $values);

    /**
     * @param \EQM\Models\Wiki\Articles\Article $article
     */
    public function delete(Article $article);

    /**
     * @param string $slug
     * @return \EQM\Models\Wiki\Articles\Article|null
     */
    public function find($slug);

    /**
     * @param \EQM\Models\Wiki\Topics\Topic $topic
     * @param int $limit
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function findByTopicPaginated(Topic $topic, $limit = 50);

    /**
     * @param string $slug
     * @return int
     */
    public function findSlugCount($slug);
}
