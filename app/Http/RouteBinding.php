<?php
namespace EQM\Http;

interface RouteBinding
{
    /**
     * @param int|string $value
     * @return mixed
     */
    public function bind($value);

    /**
     * @param int|string $id
     * @return mixed
     */
    public function find($id);
}
