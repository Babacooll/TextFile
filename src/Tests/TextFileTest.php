<?php

namespace TextFile\Tests;

use TextFile\TextFile;

/**
 * Class TextFileTest
 *
 * @package TextFile\Tests
 */
class TextFileTest extends TextFileTestCase
{
    /**
     * @covers TextFile\TextFile::open
     * @covers TextFile\TextFile::__construct
     * @covers TextFile\TextFile::getSplFileObject
     */
    public function testOpenNonExisting()
    {
        $filePath = $this->workspace . DIRECTORY_SEPARATOR . mt_rand(0, 1000) . '.txt';

        $this->assertFalse($this->filesystem->exists($filePath));

        $textFile = new TextFile($filePath);

        $this->assertTrue($this->filesystem->exists($filePath));
        $this->assertInstanceOf('\SplFileObject', $textFile->getSplFileObject());
        $this->assertSame($filePath, $textFile->getSplFileObject()->getRealPath());
    }

    /**
     * @covers TextFile\TextFile::open
     * @covers TextFile\TextFile::__construct
     * @covers TextFile\TextFile::getSplFileObject
     */
    public function testOpenExisting()
    {
        $filePath = $this->createTestFileFromFixtures('simple_multiline_file.txt');

        $this->assertTrue($this->filesystem->exists($filePath));

        $textFile = new TextFile($filePath);

        $this->assertTrue($this->filesystem->exists($filePath));
        $this->assertInstanceOf('\SplFileObject', $textFile->getSplFileObject());
        $this->assertSame($filePath, $textFile->getSplFileObject()->getRealPath());
    }
}
