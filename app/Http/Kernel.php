<?php namespace EQM\Http;

use EQM\Http\Middleware\Locale;
use EQM\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class Kernel extends HttpKernel {

	/**
	 * The application's global HTTP middleware stack.
	 *
	 * @var array
	 */
	protected $middleware = [
		CheckForMaintenanceMode::class,
		EncryptCookies::class,
		AddQueuedCookiesToResponse::class,
		StartSession::class,
		ShareErrorsFromSession::class,
		VerifyCsrfToken::class,
        Locale::class
	];

	/**
	 * The application's route middleware.
	 *
	 * @var array
	 */
	protected $routeMiddleware = [
		'auth' => 'EQM\Http\Middleware\Authenticate',
		'auth.basic' => 'Illuminate\Auth\Middleware\AuthenticateWithBasicAuth',
		'guest' => 'EQM\Http\Middleware\RedirectIfAuthenticated',
        'admin' => 'EQM\Http\MiddleWare\Admin',
	];

}
