<?php

namespace TextFile\Exception;

/**
 * Class InvalidWriterException
 *
 * @package TextFile\Exception
 */
class InvalidWriterException extends \Exception
{
    protected $message = 'Writers should implement WriterInterface interface';
}
