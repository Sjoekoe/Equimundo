<?php
namespace EQM\Models\Wiki\Articles;

use EQM\Http\AbstractRouteBinding;
use EQM\Http\RouteBinding;

class ArticleRouteBinding extends AbstractRouteBinding implements RouteBinding
{
    /**
     * @var \EQM\Models\Wiki\Articles\ArticleRepository
     */
    private $articles;

    public function __construct(ArticleRepository $articles)
    {
        $this->articles = $articles;
    }

    /**
     * @param int|string $slug
     * @return \EQM\Models\Wiki\Articles\Article|null
     */
    public function find($slug)
    {
        return $this->articles->find($slug);
    }
}
