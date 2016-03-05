<?php

namespace TextFile\Exception;

/**
 * Class InvalidWalkerException
 *
 * @package TextFile\Exception
 */
class InvalidWalkerException extends \Exception
{
    protected $message = 'Walkers should implement WalkerInterface interface';
}
