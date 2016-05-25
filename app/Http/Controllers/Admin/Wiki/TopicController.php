<?php
namespace EQM\Http\Controllers\Admin\Wiki;

use EQM\Http\Controllers\Controller;

class TopicController extends Controller
{
    public function index()
    {
        return view('wikis.admin.index');
    }   
}
