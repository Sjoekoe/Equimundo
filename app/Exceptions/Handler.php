<?php namespace EQM\Exceptions;

use Exception;
use Illuminate\Contracts\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Bugsnag\BugsnagLaravel\BugsnagExceptionHandler as ExceptionHandler;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler {

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        ModelNotFoundException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return Response
     */
    public function render($request, Exception $e)
    {
        if (app()->runningUnitTests()) {
            throw $e;
        }

        if ($e instanceof ModelNotFoundException) {
            return response()->view('errors.404');
        }

        if (
            $this->appIsNotInDebugMode() &&
            ! $this->isHttpException($e) &&
            ! $this->isResponseException($e)
        ) {
            return response()->view('errors.500', [], 500);
        }

        if ($this->isHttpException($e) && $this->appIsNotInDebugMode())
        {
            return $this->renderHttpException($e);
        }

        return parent::render($request, $e);
    }

    /**
     * @return bool
     */
    private function appIsNotInDebugMode()
    {
        return ! config('app.debug');
    }

    /**
     * @param \Exception $e
     * @return bool
     */
    private function isResponseException(Exception $e)
    {
        return $e instanceof HttpResponseException || $e instanceof ValidationException;
    }

}
