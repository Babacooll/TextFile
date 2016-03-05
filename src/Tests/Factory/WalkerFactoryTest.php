<?php

namespace TextFile\Tests\Factory;

use TextFile\Factory\WalkerFactory;
use TextFile\Walker\SimpleWalker;

/**
 * Class WalkerFactoryTest
 *
 * @package TextFile\Tests\Factory
 */
class WalkerFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers TextFile\Factory\WalkerFactory::createWalker
     */
    public function testCreateWalker()
    {
        $walkerFactory = new WalkerFactory();

        $this->assertInstanceOf(SimpleWalker::class, $walkerFactory->createWalker(SimpleWalker::class));
    }

    /**
     * @covers TextFile\Factory\WalkerFactory::createWalker
     */
    public function testCreateWalkerSingleton()
    {
        $walkerFactory = new WalkerFactory();

        $this->assertEquals($walkerFactory->createWalker(SimpleWalker::class), $walkerFactory->createWalker(SimpleWalker::class));
    }

    /**
     * @covers TextFile\Factory\WalkerFactory::createWalker
     * @expectedException \TextFile\Exception\InvalidWalkerException
     */
    public function testCreateWalkerInvalidWalker()
    {
        $walkerFactory = new WalkerFactory();

        $walkerFactory->createWalker(WalkerFactory::class);
    }
}
