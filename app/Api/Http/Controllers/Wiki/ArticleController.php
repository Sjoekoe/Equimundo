<?php
namespace EQM\Api\Http\Controllers\Wiki;

use EQM\Api\Http\Controller;
use EQM\Api\Wiki\Articles\ArticleTransformer;
use EQM\Api\Wiki\Articles\Requests\StoreArticleRequest;
use EQM\Api\Wiki\Articles\Requests\UpdateArticleRequest;
use EQM\Models\Wiki\Articles\Article;
use EQM\Models\Wiki\Articles\ArticleRepository;
use EQM\Models\Wiki\Topics\Topic;

class ArticleController extends Controller
{
    /**
     * @var \EQM\Models\Wiki\Articles\ArticleRepository
     */
    private $articles;

    public function __construct(ArticleRepository $articles)
    {
        $this->articles = $articles;
    }

    public function index(Topic $topic)
    {
        $articles = $this->articles->findByTopicPaginated($topic);

        return $this->response()->paginator($articles, new ArticleTransformer());
    }
    
    public function store(StoreArticleRequest $request, Topic $topic)
    {
        $article = $this->articles->create($topic, $request->all());
        
        return $this->response()->item($article, new ArticleTransformer());
    }

    public function show(Topic $topic, Article $article)
    {
        return $this->response()->item($article, new ArticleTransformer());
    }

    public function update(UpdateArticleRequest $request, Topic $topic, Article $article)
    {
        $article = $this->articles->update($article, $request->all());

        return $this->response()->item($article, new ArticleTransformer());
    }

    public function delete(Topic $topic, Article $article)
    {
        $this->articles->delete($article);

        return $this->response()->noContent();
    }
}
