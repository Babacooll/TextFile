<?php

namespace TextFile\Factory;

use TextFile\Exception\InvalidWalkerException;
use TextFile\Walker\WalkerInterface;

/**
 * Class WalkerFactory
 *
 * @package TextFile\Factory
 */
class WalkerFactory
{
    /**
     * @var WalkerInterface[]
     */
    protected $walkers = [];

    /**
     * @param string $walkerClass
     *
     * @return WalkerInterface
     * @throws InvalidWalkerException
     */
    public function createWalker($walkerClass)
    {
        if (isset($this->walkers[$walkerClass])) {
            return $this->walkers[$walkerClass];
        }

        if (!isset(class_implements($walkerClass)[WalkerInterface::class])) {
            throw new InvalidWalkerException();
        }

        $this->walkers[$walkerClass] = new $walkerClass;

        return $this->walkers[$walkerClass];
    }
}
