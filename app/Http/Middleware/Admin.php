<?php
namespace EQM\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthManager;

class Admin
{
    /**
     * @var \Illuminate\Auth\AuthManager
     */
    private $auth;

    public function __construct(AuthManager $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next)
    {
        if ($this->auth->guest()) {
            return redirect()->guest('login');
        }

        if ($this->auth->check() && ! $this->auth->user()->isAdmin()) {
            abort('403');
        }

        return $next($request);
    }
}
