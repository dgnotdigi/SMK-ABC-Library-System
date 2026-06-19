<?php

namespace App\Exceptions;

use Exception;

/**
 * Thrown when a circulation action (checkout, return, renew, hold) violates
 * a library policy. The message is always safe to show directly to the user.
 */
class CirculationException extends Exception
{
    //
}
