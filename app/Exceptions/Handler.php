<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use CloudCreativity\LaravelJsonApi\Exceptions\HandlesErrors;
use Neomerx\JsonApi\Exceptions\JsonApiException;

class Handler extends ExceptionHandler
{
    use HandlesErrors;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        JsonApiException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Exception
     */
    public function render($request, Exception $exception)
    {
        if ($this->isJsonApi($request, $exception)) {
            return $this->renderJsonApi($request, $exception);
        }

        return parent::render($request, $exception);
    }

    protected function prepareException(Exception $exception)
    {
        if ($exception instanceof JsonApiException) {
          return $this->prepareJsonApiException($exception);
        }

        return parent::prepareException($exception);
    }
}
