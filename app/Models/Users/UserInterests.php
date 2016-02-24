<?php
namespace EQM\Models\Users;

interface UserInterests
{
    const TABLE = 'user_interests';
    const OWNER = 1;
    const ENTHOUSIAST = 2;
    const PROFESSIONAL = 3;
    const BREEDER = 4;
    const ATHLETE = 5;

    /**
     * @return int
     */
    public function id();

    /**
     * @return \EQM\Models\users\User
     */
    public function user();

    /**
     * @return int
     */
    public function type();
}
