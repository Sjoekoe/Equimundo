<?php
namespace EQM\Core\Search;

interface SearchEngine
{
    public function index($index);

    /**
     * @param string $query
     * @return array
     */
    public function get($query);
}
