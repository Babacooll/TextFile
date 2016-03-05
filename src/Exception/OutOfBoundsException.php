<?php

namespace TextFile\Exception;

/**
 * Class OutOfBoundsException
 *
 * @package TextFile\Exception
 */
class OutOfBoundsException extends \Exception
{
    protected $message = 'You tried to seek out of files boundaries';
}
