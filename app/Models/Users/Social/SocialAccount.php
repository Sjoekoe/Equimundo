<?php
namespace EQM\Models\Users\Social;

interface SocialAccount
{
    const TABLE = 'social_accounts';
    
    /**
     * @return int
     */
    public function id();

    /**
     * @return \EQM\Models\Users\User
     */
    public function user();

    /**
     * @return int
     */
    public function providerId();

    /**
     * @return string
     */
    public function provider();

    /**
     * @return \Carbon\Carbon
     */
    public function createdAt();

    /**
     * @return \Carbon\Carbon
     */
    public function updatedAt();
}
