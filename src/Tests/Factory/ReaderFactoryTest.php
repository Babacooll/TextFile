<?php

namespace TextFile\Tests\Factory;

use TextFile\Factory\ReaderFactory;
use TextFile\Reader\SimpleReader;
use TextFile\Walker\SimpleWalker;

/**
 * Class ReaderFactoryTest
 *
 * @package TextFile\Tests\Factory
 */
class ReaderFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers TextFile\Factory\ReaderFactory::createReader
     */
    public function testCreateReader()
    {
        $readerFactory = new ReaderFactory();

        $this->assertInstanceOf(SimpleReader::class, $readerFactory->createReader(SimpleReader::class, new SimpleWalker()));
    }

    /**
     * @covers TextFile\Factory\ReaderFactory::createReader
     */
    public function testCreateReaderSingleton()
    {
        $readerFactory = new ReaderFactory();

        $this->assertEquals($readerFactory->createReader(SimpleReader::class, new SimpleWalker()), $readerFactory->createReader(SimpleReader::class, new SimpleWalker()));
    }

    /**
     * @covers TextFile\Factory\ReaderFactory::createReader
     *
     * @expectedException \TextFile\Exception\InvalidReaderException
     */
    public function testCreateReaderInvalidReader()
    {
        $readerFactory = new ReaderFactory();

        $readerFactory->createReader(ReaderFactory::class, new SimpleWalker());
    }
}
