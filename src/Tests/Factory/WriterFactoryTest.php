<?php

namespace TextFile\Tests\Factory;

use TextFile\Factory\WriterFactory;
use TextFile\Writer\ErasingWriter;
use TextFile\Writer\PrependingWriter;

/**
 * Class WriterFactoryTest
 *
 * @package TextFile\Tests\Factory
 */
class WriterFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers TextFile\Factory\WriterFactory::createWriter
     */
    public function testCreateWriter()
    {
        $writerFactory = new WriterFactory();

        $this->assertInstanceOf(PrependingWriter::class, $writerFactory->createWriter(PrependingWriter::class));
        $this->assertInstanceOf(ErasingWriter::class, $writerFactory->createWriter(ErasingWriter::class));
    }

    /**
     * @covers TextFile\Factory\WriterFactory::createWriter
     */
    public function testCreateWriterSingleton()
    {
        $writerFactory = new WriterFactory();

        $this->assertEquals($writerFactory->createWriter(PrependingWriter::class), $writerFactory->createWriter(PrependingWriter::class));
        $this->assertEquals($writerFactory->createWriter(ErasingWriter::class), $writerFactory->createWriter(ErasingWriter::class));
    }

    /**
     * @covers TextFile\Factory\WriterFactory::createWriter
     * @expectedException \TextFile\Exception\InvalidWriterException
     */
    public function testCreateWriterInvalidWriter()
    {
        $writerFactory = new WriterFactory();

        $writerFactory->createWriter(WriterFactory::class);
    }
}
