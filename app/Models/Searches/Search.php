<?php
namespace EQM\Models\Searches;

interface Search
{
    const TABLE = 'searches';

    /**
     * @return int
     */
    public function id();

    /**
     * @return string
     */
    public function term();

    /**
     * @return int
     */
    public function count();

    /**
     * @return int
     */
    public function currentResults();
}
