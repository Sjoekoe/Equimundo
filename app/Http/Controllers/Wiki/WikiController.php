<?php
namespace EQM\Http\Controllers\Wiki;

use EQM\Http\Controllers\Controller;
use EQM\Models\Wiki\Articles\Article;
use EQM\Models\Wiki\Articles\ArticleRepository;
use EQM\Models\Wiki\Topics\Topic;
use EQM\Models\Wiki\Topics\TopicRepository;

class WikiController extends Controller
{
    /**
     * @var \EQM\Models\Wiki\Topics\TopicRepository
     */
    private $topics;

    /**
     * @var \EQM\Models\Wiki\Articles\ArticleRepository
     */
    private $articles;

    public function __construct(TopicRepository $topics, ArticleRepository $articles)
    {
        $this->topics = $topics;
        $this->articles = $articles;
    }

    public function index()
    {
        $topics = $this->topics->findAllPaginated();

        return view('wikis.index', compact('topics'));
    }

    public function show(Topic $topic)
    {
        $articles = $this->articles->findByTopicPaginated($topic);

        return view('wikis.show', compact('topic', 'articles'));
    }

    public function showArticle(Article $article)
    {
        $this->articles->update($article, ['views' => $article->views() + 1]);

        return view('wikis.article', compact('article'));
    }
}
