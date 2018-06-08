<?php

namespace App\Exceptions;

use Exception;
use Throwable;

/**
 * Class LinkedAccountTokenException.
 */
class LinkedAccountTokenException extends Exception
{
    /**
     * @var
     */
    public $message;

    /**
     * GeneralException constructor.
     *
     * @param string         $message
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct($message = 'The Agave token associated with the linked account is missing or invalid.', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Report the exception.
     *
     * @return void
     */
    public function report()
    {
        //
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        /*
         * All instances of GeneralException redirect back with a flash message to show a bootstrap alert-error
         */
        return redirect()
            ->route('frontend.auth.login')
            ->withFlashDanger($this->message);
    }
}
