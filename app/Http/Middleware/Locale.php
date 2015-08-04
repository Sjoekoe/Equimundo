<?php
namespace EQM\Http\Middleware;

use Illuminate\Auth\AuthManager;
use Illuminate\Foundation\Application;

class Locale
{
    /**
     * @var \Illuminate\Auth\AuthManager
     */
    private $auth;
    /**
     * @var \Illuminate\Foundation\Application
     */
    private $app;

    /**
     * @param \Illuminate\Auth\AuthManager $auth
     * @param \Illuminate\Foundation\Application $app
     */
    public function __construct(AuthManager $auth, Application $app)
    {
        $this->auth = $auth;
        $this->app = $app;
    }

    /**
     * @param $request
     * @param callable $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        if ($this->auth->check()) {
            $this->app->setLocale($this->auth->user()->getLocale());
        }

        return $next($request);
    }
}
