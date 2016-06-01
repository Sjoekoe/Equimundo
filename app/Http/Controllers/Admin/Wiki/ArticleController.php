<?php
namespace EQM\Http\Controllers\Admin\Wiki;

use EQM\Http\Controllers\Controller;
use EQM\Models\Wiki\Articles\Article;
use EQM\Models\Wiki\Articles\ArticleRepository;
use EQM\Models\Wiki\Topics\Topic;
use Illuminate\Http\Request;

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

    public function create(Topic $topic)
    {
        return view('wikis.admin.articles.create', compact('topic'));
    }

    public function store(Request $request, Topic $topic)
    {
        $this->articles->create($topic, $request->all());

        return redirect()->route('admin.wiki.topics');
    }

    public function edit(Topic $topic, Article $article)
    {
        return view('wikis.admin.articles.edit', compact('article', 'topic'));
    }

    public function update(Request $request, Topic $topic, Article $article)
    {
        $this->articles->update($article, $request->all());

        return redirect()->route('admin.wiki.topic', $topic->id());
    }
}
