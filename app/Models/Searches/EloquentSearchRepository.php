<?php
namespace EQM\Models\Searches;

class EloquentSearchRepository implements SearchRepository
{
    /**
     * @var \EQM\Models\Searches\EloquentSearch
     */
    private $search;

    public function __construct(EloquentSearch $search)
    {
        $this->search = $search;
    }

    /**
     * @param string $term
     * @param int $currentResults
     * @return \EQM\Models\Searches\Search
     */
    public function create($term, $currentResults)
    {
        $search = new EloquentSearch();
        $search->term = $term;
        $search->count = 1;
        $search->current_results = $currentResults;
        $search->save();

        return $search;
    }

    /**
     * @param \EQM\Models\Searches\Search $search
     * @param int $currentResults
     * @return \EQM\Models\Searches\Search
     */
    public function update(Search $search, $currentResults)
    {
        $search->count = $search->count() + 1;
        $search->current_results = $currentResults;
        $search->save();

        return $search;
    }

    /**
     * @param string $term
     * @return \EQM\Models\Searches\Search|null
     */
    public function findByTerm($term)
    {
        return $this->search->where('term', $term)->first();
    }

    /**
     * @return int
     */
    public function count()
    {
        return $this->search->sum('count');
    }

    /**
     * @return \EQM\Models\Searches\Search[]
     */
    public function adminOverview()
    {
        return $this->search->orderBy('count', 'DESC')->paginate(50);
    }
}
