<?php
namespace EQM\Models\Wiki\Topics;

interface Topic
{
    const TABLE = 'topics';
    
    /**
     * @return int
     */
    public function id();

    /**
     * @return string
     */
    public function title();

    /**
     * @return \Carbon\Carbon
     */
    public function createdAt();

    /**
     * @return \Carbon\Carbon
     */
    public function updatedAt();
}
