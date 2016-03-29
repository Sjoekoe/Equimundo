<?php

use EQM\Core\JWT\TokenGenerator;

abstract class ApiTestCase extends \TestCase
{
    /**
     * @param int $userId
     * @return array
     */
    protected function setJWTHeaders($userId = null)
    {
        return ['Authorization' => 'Bearer ' . $this->getJWTToken($userId)];
    }

    /**
     * For now we'll return a token for the admin.
     *
     * @param int $userId
     * @return string
     */
    private function getJWTToken($userId = null)
    {
        $user = $this->findUser($userId);

        return $this->app[TokenGenerator::class]->byUser($user);
    }
}
