<?php

namespace TextFile\Tests;

use Symfony\Component\Filesystem\Filesystem;

/**
 * Class TextFileTestCase
 *
 * @package TextFile\Tests
 */
class TextFileTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    protected $workspace;

    /**
     * @var Filesystem
     */
    protected $filesystem;

    protected function setUp()
    {
        $this->filesystem = new Filesystem();
        $this->workspace  = rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.time().mt_rand(0, 1000);

        mkdir($this->workspace, 0777, true);

        $this->workspace = realpath($this->workspace);
    }

    protected function tearDown()
    {
        $this->filesystem->remove($this->workspace);
    }

    /**
     * @param string $fileName
     *
     * @return string
     */
    protected function createTestFileFromFixtures($fileName)
    {
        $this->filesystem->copy($this->getPathFixtureFile($fileName), $this->workspace.DIRECTORY_SEPARATOR.$fileName);

        return $this->workspace.DIRECTORY_SEPARATOR.$fileName;
    }

    /**
     * @param string $fileName
     *
     * @return string
     */
    protected function getPathFixtureFile($fileName)
    {
        return __DIR__.DIRECTORY_SEPARATOR.'Fixtures'.DIRECTORY_SEPARATOR.$fileName;
    }
}
