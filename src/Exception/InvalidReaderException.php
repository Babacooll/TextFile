<?php

namespace TextFile\Exception;

/**
 * Class InvalidReaderException
 *
 * @package TextFile\Exception
 */
class InvalidReaderException extends \Exception
{
    protected $message = 'Readers should implement ReaderInterface interface';
}
