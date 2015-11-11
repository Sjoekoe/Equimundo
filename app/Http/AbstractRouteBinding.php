<?php
namespace EQM\Http;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AbstractRouteBinding
{
    /**
     * @param int|string $value
     * @return mixed
     */
    public function bind($value)
    {
        if ($entity = $this->find($value)) {
            return $entity;
        }

        throw new NotFoundHttpException();
    }
}
