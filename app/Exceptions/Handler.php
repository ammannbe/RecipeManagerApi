<?php

namespace App\Exceptions;

use App\Mail\ExceptionOccured;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\Debug\ExceptionHandler as SymfonyExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
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
     * Determine if the exception should be reported.
     *
     * @param  \Exception  $e
     * @return bool
     */
    public function shouldReport(\Exception $e)
    {
        if (config('app.debug')) {
            return false;
        }

        return parent::shouldReport($e);
    }

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(\Exception $exception)
    {
        if ($this->shouldReport($exception)) {
            $this->sendEmail($exception);
        }

        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, \Exception $exception)
    {
        return parent::render($request, $exception);
    }

    /**
     * Sends an email to the developer about the exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    private function sendEmail(\Exception $exception)
    {
        try {
            $flatten = FlattenException::create($exception);
            $handler = new SymfonyExceptionHandler();
            $html = $handler->getHtml($flatten);
            Mail::to(config('mail.exception_recipient'))->send(new ExceptionOccured($html));
        } catch (\Exception $e) {
            dd("An error occured while sending the exception email: {$e}", "Previous error: {$exception}");
        }
    }
}
