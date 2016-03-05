<?php

namespace TextFile\Tests\Writer;

use TextFile\Tests\TextFileTestCase;
use TextFile\Writer\ErasingWriter;

/**
 * Class ErasingWriterTest
 *
 * @package TextFile\Tests\Writer
 */
class ErasingWriterTest extends TextFileTestCase
{
    /**
     * @covers TextFile\Writer\ErasingWriter::write
     */
    public function testWriteBeginning()
    {
        $erasingWriter = new ErasingWriter();

        $filePath = $this->createTestFileFromFixtures('complex_singleline_file.txt');
        $file     = new \SplFileObject($filePath, 'r+');

        $erasingWriter->write($file, 'test');

        $file->rewind();

        $this->assertEquals('testtsecondthirdfourthfifth', trim($file->current()));
    }

    /**
     * @covers TextFile\Writer\ErasingWriter::write
     */
    public function testWriteMiddle()
    {
        $erasingWriter = new ErasingWriter();

        $filePath = $this->createTestFileFromFixtures('complex_singleline_file.txt');
        $file     = new \SplFileObject($filePath, 'r+');

        $file->fseek(5);

        $erasingWriter->write($file, 'test');

        $file->rewind();

        $this->assertEquals('firsttestndthirdfourthfifth', trim($file->current()));
    }

    /**
     * @covers TextFile\Writer\ErasingWriter::write
     */
    public function testWriteMiddleNewLine()
    {
        $erasingWriter = new ErasingWriter();

        $filePath = $this->createTestFileFromFixtures('complex_singleline_file.txt');
        $file     = new \SplFileObject($filePath, 'r+');

        $file->fseek(5);

        $erasingWriter->write($file, 'test', true);

        $file->rewind();

        $this->assertEquals('firsttest', trim($file->current()));

        $file->next();

        $this->assertEquals('dthirdfourthfifth', trim($file->current()));
    }

    /**
     * @covers TextFile\Writer\ErasingWriter::write
     */
    public function testWriteBeginningNewLine()
    {
        $erasingWriter = new ErasingWriter();

        $filePath = $this->createTestFileFromFixtures('complex_singleline_file.txt');
        $file     = new \SplFileObject($filePath, 'r+');

        $erasingWriter->write($file, 'test', true);

        $file->rewind();

        $this->assertEquals('test', trim($file->current()));

        $file->next();

        $this->assertEquals('secondthirdfourthfifth', trim($file->current()));
    }
}
