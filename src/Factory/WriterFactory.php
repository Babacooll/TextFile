<?php

namespace TextFile\Factory;

use TextFile\Exception\InvalidWriterException;
use TextFile\Writer\WriterInterface;

/**
 * Class WriterFactory
 *
 * @package TextFile\Factory
 */
class WriterFactory
{
    /**
     * @var WriterInterface[]
     */
    protected $writers = [];

    /**
     * @param string $writerClass
     *
     * @return WriterInterface
     * @throws InvalidWriterException
     */
    public function createWriter($writerClass)
    {
        if (isset($this->writers[$writerClass])) {
            return $this->writers[$writerClass];
        }

        if (!isset(class_implements($writerClass)[WriterInterface::class])) {
            throw new InvalidWriterException();
        }

        $this->writers[$writerClass] = new $writerClass;

        return $this->writers[$writerClass];
    }
}
