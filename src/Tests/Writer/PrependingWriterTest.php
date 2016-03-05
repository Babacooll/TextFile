<?php

namespace TextFile\Tests\Writer;

use TextFile\Tests\TextFileTestCase;
use TextFile\Writer\PrependingWriter;

/**
 * Class PrependingWriterTest
 *
 * @package TextFile\Tests\Writer
 */
class PrependingWriterTest extends TextFileTestCase
{
    /**
     * @covers TextFile\Writer\PrependingWriter::write
     */
    public function testWriteBeginning()
    {
        $prependingWriter = new PrependingWriter();

        $filePath = $this->createTestFileFromFixtures('complex_singleline_file.txt');
        $file     = new \SplFileObject($filePath, 'r+');

        $prependingWriter->write($file, 'test');

        $file->rewind();

        $this->assertEquals('testfirstsecondthirdfourthfifth', trim($file->current()));
    }

    /**
     * @covers TextFile\Writer\PrependingWriter::write
     */
    public function testWriteMiddle()
    {
        $prependingWriter = new PrependingWriter();

        $filePath = $this->createTestFileFromFixtures('complex_singleline_file.txt');
        $file     = new \SplFileObject($filePath, 'r+');

        $file->fseek(5);

        $prependingWriter->write($file, 'test');

        $file->rewind();

        $this->assertEquals('firsttestsecondthirdfourthfifth', trim($file->current()));
    }

    /**
     * @covers TextFile\Writer\PrependingWriter::write
     */
    public function testWriteEnd()
    {
        $prependingWriter = new PrependingWriter();

        $filePath = $this->createTestFileFromFixtures('complex_singleline_file.txt');
        $file     = new \SplFileObject($filePath, 'r+');

        $file->fseek(27);

        $prependingWriter->write($file, 'test');

        $file->rewind();

        $this->assertEquals('firstsecondthirdfourthfifthtest', trim($file->current()));
    }

    /**
     * @covers TextFile\Writer\ErasingWriter::write
     */
    public function testWriteMiddleNewLine()
    {
        $prependingWriter = new PrependingWriter();

        $filePath = $this->createTestFileFromFixtures('complex_singleline_file.txt');
        $file     = new \SplFileObject($filePath, 'r+');

        $file->fseek(5);

        $prependingWriter->write($file, 'test', true);

        $file->rewind();

        $this->assertEquals('firsttest', trim($file->current()));

        $file->next();

        $this->assertEquals('secondthirdfourthfifth', trim($file->current()));
    }

    /**
     * @covers TextFile\Writer\PrependingWriter::write
     */
    public function testWriteBeginningNewLine()
    {
        $prependingWriter = new PrependingWriter();

        $filePath = $this->createTestFileFromFixtures('complex_singleline_file.txt');
        $file     = new \SplFileObject($filePath, 'r+');

        $prependingWriter->write($file, 'test', true);

        $file->rewind();

        $this->assertEquals('test', trim($file->current()));

        $file->next();

        $this->assertEquals('firstsecondthirdfourthfifth', trim($file->current()));
    }
}
