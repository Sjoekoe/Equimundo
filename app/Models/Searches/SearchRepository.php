<?php
namespace EQM\Models\Searches;

interface SearchRepository
{
    /**
     * @param string $term
     * @param int $currentResults
     * @return \EQM\Models\Searches\Search
     */
    public function create($term, $currentResults);

    /**
     * @param \EQM\Models\Searches\Search $search
     * @param int $currentResults
     * @return \EQM\Models\Searches\Search
     */
    public function update(Search $search, $currentResults);

    /**
     * @param string $term
     * @return \EQM\Models\Searches\Search|null
     */
    public function findByTerm($term);

    /**
     * @return int
     */
    public function count();

    /**
     * @return \EQM\Models\Searches\Search[]
     */
    public function adminOverview();
}
