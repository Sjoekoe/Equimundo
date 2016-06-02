<?php
namespace EQM\Models\Wiki\Articles;

interface Article
{
    const TABLE = 'articles';
    
    /**
     * @return int
     */
    public function id();

    /**
     * @return string
     */
    public function title();

    /**
     * @return string
     */
    public function slug();

    /**
     * @return string
     */
    public function body();

    /**
     * @return int
     */
    public function views();

    /**
     * @return \EQM\Models\Wiki\Topics\Topic
     */
    public function topic();

    /**
     * @return \Carbon\Carbon
     */
    public function createdAt();

    /**
     * @return \Carbon\Carbon
     */
    public function updatedAt();
}
