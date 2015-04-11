<?php 
namespace HorseStories\Http\Middleware;

use App;
use Closure;
use Illuminate\Auth\Guard;

class Admin
{
    /**
     * @var \Illuminate\Auth\Guard
     */
    private $auth;

    /**
     * @param \Illuminate\Auth\Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next)
    {
        if ($this->auth->guest()) {
            return redirect()->guest('login');
        }

        if ($this->auth->check() && ! $this->auth->user()->isAdmin()) {
            App::abort('403');
        }

        return $next($request);
    }
}