<?php
namespace EQM\Core\Search;

use AlgoliaSearch\Client;

class AlgoliaSearchEngine implements SearchEngine
{
    /**
     * @var \AlgoliaSearch\Client
     */
    private $client;

    protected $index;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function index($index)
    {
        return $this->index = $this->client->initIndex($index);
    }

    /**
     * @param string $query
     * @return array
     */
    public function get($query)
    {
        return $this->index->search($query)['hits'];
    }
}
