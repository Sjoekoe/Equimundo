<?php
namespace EQM\Models\Users;

use EQM\Http\AbstractRouteBinding;
use EQM\Http\RouteBinding;

class UserSlugRouteBinder extends AbstractRouteBinding implements RouteBinding
{
    /**
     * @var \EQM\Models\Users\UserRepository
     */
    private $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    /**
     * @param int|string $slug
     * @return mixed
     */
    public function find($slug)
    {
        return $this->users->findBySlug($slug);
    }
}
