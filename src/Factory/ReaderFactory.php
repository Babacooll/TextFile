<?php

namespace TextFile\Factory;

use TextFile\Exception\InvalidReaderException;
use TextFile\Exception\InvalidWriterException;
use TextFile\Reader\ReaderInterface;
use TextFile\Walker\WalkerInterface;

/**
 * Class ReaderFactory
 *
 * @package TextFile\Factory
 */
class ReaderFactory
{
    /**
     * @var ReaderInterface[]
     */
    protected $readers = [];

    /**
     * @param string          $readerClass
     * @param WalkerInterface $walker
     *
     * @return ReaderInterface
     * @throws InvalidReaderException
     */
    public function createReader($readerClass, WalkerInterface $walker)
    {
        $walkerClassName = get_class($walker);

        if (isset($this->readers[$readerClass][$walkerClassName])) {
            return $this->readers[$readerClass][$walkerClassName];
        }

        if (!isset(class_implements($readerClass)[ReaderInterface::class])) {
            throw new InvalidReaderException();
        }

        $this->addReader($readerClass, $walker);

        return $this->readers[$readerClass][$walkerClassName];
    }

    /**
     * @param string          $readerClass
     * @param WalkerInterface $walker
     */
    protected function addReader($readerClass, WalkerInterface $walker)
    {
        $walkerClassName = get_class($walker);

        $this->readers[$readerClass][$walkerClassName] = new $readerClass($walker);
    }
}
