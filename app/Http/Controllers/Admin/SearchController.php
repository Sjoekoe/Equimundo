<?php
namespace EQM\Http\Controllers\Admin;

use EQM\Http\Controllers\Controller;
use EQM\Models\Searches\SearchRepository;

class SearchController extends Controller
{
    /**
     * @var \EQM\Models\Searches\SearchRepository
     */
    private $searches;

    public function __construct(SearchRepository $searches)
    {
        $this->searches = $searches;
    }

    public function index()
    {
        $searches = $this->searches->adminOverview();

        return view('admin.searches.index', compact('searches'));
    }
}
