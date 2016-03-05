<?php

namespace TextFile\Tests\Walker;

use TextFile\Tests\TextFileTestCase;
use TextFile\Walker\SimpleWalker;

/**
 * Class SimpleWalkerTest
 *
 * @package TextFile\Tests\Walker
 */
class SimpleWalkerTest extends TextFileTestCase
{
    /**
     * @covers TextFile\Walker\SimpleWalker::goToLine
     */
    public function testGoToLine()
    {
        $filePath = $this->createTestFileFromFixtures('simple_multiline_file.txt');
        $lineNumber = 21;

        for ($i = 0; $i <= $lineNumber; $i++) {
            $file = new \SplFileObject($filePath, 'r+');

            $walker = new SimpleWalker();

            $walker->goToLine($file, $i);

            $this->assertEquals($i, $file->key());
        }
    }

    /**
     * @covers TextFile\Walker\SimpleWalker::goToLine
     * @expectedException \TextFile\Exception\OutOfBoundsException
     */
    public function testGoToLineTooHigh()
    {
        $filePath = $this->createTestFileFromFixtures('simple_multiline_file.txt');

        $file = new \SplFileObject($filePath, 'r+');

        $walker = new SimpleWalker();

        $walker->goToLine($file, 40);
    }

    /**
     * @covers TextFile\Walker\SimpleWalker::goToLine
     * @expectedException \TextFile\Exception\OutOfBoundsException
     */
    public function testGoToLineTooLow()
    {
        $filePath = $this->createTestFileFromFixtures('simple_multiline_file.txt');

        $file = new \SplFileObject($filePath, 'r+');

        $walker = new SimpleWalker();

        $walker->goToLine($file, -1);
    }

    /**
     * @covers TextFile\Walker\SimpleWalker::countLines
     */
    public function testCountLines()
    {
        $filePath = $this->createTestFileFromFixtures('simple_multiline_file.txt');

        $file = new \SplFileObject($filePath, 'r+');

        $walker = new SimpleWalker();

        $this->assertEquals(21, $walker->countLines($file));

        $file->seek(21);
        $file->fwrite('test' . PHP_EOL);

        // Evaluate if correctly refreshed after modification
        $this->assertEquals(22, $walker->countLines($file));
    }

    /**
     * @covers TextFile\Walker\SimpleWalker::goBeforeCharacter
     */
    public function testGoBeforeCharacter()
    {
        $filePath = $this->createTestFileFromFixtures('simple_multiline_file.txt');

        $file = new \SplFileObject($filePath, 'r+');

        $walker = new SimpleWalker();

        $walker->goBeforeCharacter($file, 0);

        $this->assertEquals(0, $file->fgetc());

        $walker->goBeforeCharacter($file, 1);

        $this->assertEquals(PHP_EOL, $file->fgetc());

        $walker->goBeforeCharacter($file, 2);

        $this->assertEquals(1, $file->fgetc());
    }

    /**
     * @covers TextFile\Walker\SimpleWalker::goBeforeCharacter
     * @expectedException \TextFile\Exception\OutOfBoundsException
     */
    public function testGoBeforeCharacterTooLow()
    {
        $filePath = $this->createTestFileFromFixtures('simple_multiline_file.txt');

        $file = new \SplFileObject($filePath, 'r+');

        $walker = new SimpleWalker();

        $walker->goBeforeCharacter($file, -1);
    }

    /**
     * @covers TextFile\Walker\SimpleWalker::goBeforeCharacter
     * @expectedException \TextFile\Exception\OutOfBoundsException
     */
    public function testGoBeforeCharacterTooHigh()
    {
        $filePath = $this->createTestFileFromFixtures('simple_multiline_file.txt');

        $file = new \SplFileObject($filePath, 'r+');

        $walker = new SimpleWalker();

        $walker->goBeforeCharacter($file, $file->getSize() + 1);
    }
}
