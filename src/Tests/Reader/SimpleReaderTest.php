<?php

namespace TextFile\Tests\Reader;

use TextFile\Reader\SimpleReader;
use TextFile\Tests\TextFileTestCase;
use TextFile\Walker\SimpleWalker;

/**
 * Class SimpleReaderTest
 *
 * @package TextFile\Tests\Reader
 */
class SimpleReaderTest extends TextFileTestCase
{
    /**
     * @covers TextFile\Reader\SimpleReader::getLinesRange
     */
    public function testGetLinesRange()
    {
        $reader = new SimpleReader(new SimpleWalker());

        $filePath = $this->createTestFileFromFixtures('complex_multiline_file.txt');
        $file     = new \SplFileObject($filePath, 'r+');
        $range    = $reader->getLinesRange($file, 0, 2);

        $this->assertInstanceOf('\LimitIterator', $range);

        $this->assertCount(2, $range);
    }

    /**
     * @covers TextFile\Reader\SimpleReader::getLinesRange
     *
     * @expectedException \TextFile\Exception\OutOfBoundsException
     */
    public function testGetLinesRangeOutOfBoundsTooLow()
    {
        $reader = new SimpleReader(new SimpleWalker());

        $filePath = $this->createTestFileFromFixtures('complex_multiline_file.txt');
        $file     = new \SplFileObject($filePath, 'r+');

        $reader->getLinesRange($file, -1, 2);
    }

    /**
     * @covers TextFile\Reader\SimpleReader::getLinesRange
     *
     * @expectedException \TextFile\Exception\OutOfBoundsException
     */
    public function testGetLinesRangeOutOfBoundsTooHigh()
    {
        $reader = new SimpleReader(new SimpleWalker());

        $filePath = $this->createTestFileFromFixtures('complex_multiline_file.txt');
        $file     = new \SplFileObject($filePath, 'r+');

        $reader->getLinesRange($file, 0, 20);
    }

    /**
     * @covers TextFile\Reader\SimpleReader::getNextLineContent
     */
    public function testGetNextLineContentFromStart()
    {
        $reader = new SimpleReader(new SimpleWalker());

        $filePath = $this->createTestFileFromFixtures('complex_multiline_file.txt');
        $file     = new \SplFileObject($filePath, 'r+');

        $this->assertEquals('second', $reader->getNextLineContent($file));

        // Test if pointer is correctly reset

        $this->assertEquals('second', $reader->getNextLineContent($file));
    }

    /**
     * @covers TextFile\Reader\SimpleReader::getNextLineContent
     */
    public function testGetNextLineContent()
    {
        $reader = new SimpleReader(new SimpleWalker());

        $filePath = $this->createTestFileFromFixtures('complex_multiline_file.txt');
        $file     = new \SplFileObject($filePath, 'r+');

        $file->seek(2);

        $this->assertEquals('fourth', $reader->getNextLineContent($file));

        // Test if pointer is correctly reset

        $this->assertEquals('fourth', $reader->getNextLineContent($file));
    }

    /**
     * @covers TextFile\Reader\SimpleReader::getNextLineContent
     *
     * @expectedException \TextFile\Exception\OutOfBoundsException
     */
    public function testGetNextLineContentOutOfBounds()
    {
        $reader = new SimpleReader(new SimpleWalker());

        $filePath = $this->createTestFileFromFixtures('complex_multiline_file.txt');
        $file     = new \SplFileObject($filePath, 'r+');

        $file->seek(5);

        $reader->getNextLineContent($file);
    }

    /**
     * @covers TextFile\Reader\SimpleReader::getPreviousLineContent
     */
    public function testGetPreviousLineContent()
    {
        $reader = new SimpleReader(new SimpleWalker());

        $filePath = $this->createTestFileFromFixtures('complex_multiline_file.txt');
        $file     = new \SplFileObject($filePath, 'r+');

        $file->seek(2);

        $this->assertEquals('second', $reader->getPreviousLineContent($file));

        // Test if pointer is correctly reset

        $this->assertEquals('second', $reader->getPreviousLineContent($file));
    }

    /**
     * @covers TextFile\Reader\SimpleReader::getPreviousLineContent
     *
     * @expectedException \TextFile\Exception\OutOfBoundsException
     */
    public function testGetPreviousLineContentOutOfBounds()
    {
        $reader = new SimpleReader(new SimpleWalker());

        $filePath = $this->createTestFileFromFixtures('complex_multiline_file.txt');
        $file     = new \SplFileObject($filePath, 'r+');

        $file->seek(0);

        $reader->getPreviousLineContent($file);
    }

    /**
     * @covers TextFile\Reader\SimpleReader::getCurrentLineContent
     */
    public function testGetCurrentLineContent()
    {
        $reader = new SimpleReader(new SimpleWalker());

        $filePath = $this->createTestFileFromFixtures('complex_multiline_file.txt');
        $file     = new \SplFileObject($filePath, 'r+');

        $file->seek(2);

        $this->assertEquals('third', $reader->getCurrentLineContent($file));

        // Test if pointer is correctly reset

        $this->assertEquals('third', $reader->getCurrentLineContent($file));
    }

    /**
     * @covers TextFile\Reader\SimpleReader::getLineContent
     */
    public function testGetLineContent()
    {
        $reader = new SimpleReader(new SimpleWalker());

        $filePath = $this->createTestFileFromFixtures('complex_multiline_file.txt');
        $file     = new \SplFileObject($filePath, 'r+');

        $this->assertEquals('third', $reader->getLineContent($file, 2));
    }

    /**
     * @covers TextFile\Reader\SimpleReader::getLineContent
     *
     * @expectedException \TextFile\Exception\OutOfBoundsException
     */
    public function testGetLineContentOutOfBoundsTooHigh()
    {
        $reader = new SimpleReader(new SimpleWalker());

        $filePath = $this->createTestFileFromFixtures('complex_multiline_file.txt');
        $file     = new \SplFileObject($filePath, 'r+');

        $this->assertEquals('third', $reader->getLineContent($file, 9));
    }

    /**
     * @covers TextFile\Reader\SimpleReader::getLineContent
     *
     * @expectedException \TextFile\Exception\OutOfBoundsException
     */
    public function testGetLineContentOutOfBoundsTooLow()
    {
        $reader = new SimpleReader(new SimpleWalker());

        $filePath = $this->createTestFileFromFixtures('complex_multiline_file.txt');
        $file     = new \SplFileObject($filePath, 'r+');

        $this->assertEquals('third', $reader->getLineContent($file, -1));
    }

    /**
     * @covers TextFile\Reader\SimpleReader::getNextCharacterContent
     */
    public function testGetNextCharacterContent()
    {
        $reader = new SimpleReader(new SimpleWalker());

        $filePath = $this->createTestFileFromFixtures('complex_multiline_file.txt');
        $file     = new \SplFileObject($filePath, 'r+');

        $file->fseek(2);

        $this->assertEquals('r', $reader->getNextCharacterContent($file));
    }

    /**
     * @covers TextFile\Reader\SimpleReader::getPreviousCharacterContent
     */
    public function testGetPreviousCharacterContent()
    {
        $reader = new SimpleReader(new SimpleWalker());

        $filePath = $this->createTestFileFromFixtures('complex_multiline_file.txt');
        $file     = new \SplFileObject($filePath, 'r+');

        $file->fseek(2);

        $this->assertEquals('i', $reader->getPreviousCharacterContent($file));
    }

    /**
     * @covers TextFile\Reader\SimpleReader::getCharacterContent
     */
    public function testGetCharacterContent()
    {
        $reader = new SimpleReader(new SimpleWalker());

        $filePath = $this->createTestFileFromFixtures('complex_multiline_file.txt');
        $file     = new \SplFileObject($filePath, 'r+');

        $this->assertEquals('r', $reader->getCharacterContent($file, 2));
    }

    /**
     * @covers TextFile\Reader\SimpleReader::cleanLineContent
     */
    public function testCleanLineContent()
    {
        $reader = new SimpleReader(new SimpleWalker());

        $this->assertEmpty($reader->cleanLineContent(PHP_EOL));
    }
}
