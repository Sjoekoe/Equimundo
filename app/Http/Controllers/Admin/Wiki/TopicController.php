<?php
namespace EQM\Http\Controllers\Admin\Wiki;

use EQM\Core\Info\Info;
use EQM\Http\Controllers\Controller;
use EQM\Models\Wiki\Topics\Topic;

class TopicController extends Controller
{
    public function index()
    {
        return view('wikis.admin.index');
    }

    public function show(Info $info, Topic $topic)
    {
        $info->flash('topic', $topic->id());

        return view('wikis.admin.show', compact('topic'));
    }
}
