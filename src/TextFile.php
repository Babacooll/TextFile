<?php

namespace TextFile;

use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\Filesystem\Filesystem;
use TextFile\Exception\OutOfBoundsException;

/**
 * Class TextFile
 *
 * @package TextFile
 */
class TextFile
{
    const MODE_WRITE_PREPEND = 'prepend';
    const MODE_WRITE_REPLACE = 'replace';

    /**
     * @var \SplFileObject
     */
    protected $splFileObject;

    /**
     * @var string
     */
    protected $fileName;

    /**
     * @var Filesystem
     */
    protected $fileSystem;

    /**
     * @var bool
     */
    protected $isRealFile = false;

    /**
     * @var int
     */
    protected $currentLine = 0;

    /**
     * TextFile constructor.
     *
     * @param string $fileName
     */
    public function __construct($fileName = null)
    {
        $this->fileSystem = new Filesystem();
        $this->fileName   = $fileName;

        if ($fileName) {
            $this->open($fileName);
        } else {
            $this->createEmpty();
        }
    }

    /**
     * @param string $fileName
     *
     * @return TextFile
     */
    public function open($fileName)
    {
        if (!$this->fileSystem->exists($fileName)) {
            throw new FileNotFoundException($fileName);
        }

        $this->splFileObject = new \SplFileObject($fileName, 'r+b');
        $this->isRealFile = true;

        return $this;
    }

    /**
     * @return TextFile
     */
    public function createEmpty()
    {
        $this->splFileObject = new \SplFileObject('php://memory');
        $this->isRealFile    = false;

        return $this;
    }

    /**
     * @param int $from
     * @param int $to
     *
     * @return \LimitIterator
     * @throws OutOfBoundsException
     */
    public function getLinesRange($from, $to)
    {
        if ($from < 0 || $to > $this->countLines()) {
            throw new OutOfBoundsException();
        }

        return new \LimitIterator($this->splFileObject, $from, $to);
    }

    /**
     * @return int
     */
    public function countLines()
    {
        $previous = $this->splFileObject->key();

        $this->splFileObject->seek($this->splFileObject->getSize());

        $count = $this->splFileObject->key();

        $this->splFileObject->seek($previous);

        return $count;
    }

    /**
     * @param string $newFileName
     *
     * @return $this
     */
    public function save($newFileName = null)
    {
        if (!$this->isRealFile && !$newFileName) {
            // TODO : Throw exception
        }

        $this->splFileObject->fflush();

        $this->isRealFile = true;

        return $this;
    }

    /**
     * @param int $lineNumber
     *
     * @return $this
     * @throws OutOfBoundsException
     */
    public function goToLine($lineNumber)
    {
        if ($lineNumber < 0 || $lineNumber > $this->countLines()) {
            throw new OutOfBoundsException();
        }

        $this->splFileObject->rewind();

        for ($i = 0; $i < $lineNumber; $i++) {
            $this->splFileObject->next();
            $this->splFileObject->current();
        }

        return $this;
    }

    /**
     * @param int $characterNumber
     *
     * @return string
     * @throws OutOfBoundsException
     */
    public function goToCharacter($characterNumber)
    {
        $originalLne = $this->splFileObject->key();

        $this->goToLine($originalLne);

        if ($characterNumber < 0) {
            throw new OutOfBoundsException();
        }

        for ($i = 0; $i <= $characterNumber; $i++) {
            $character = $this->splFileObject->fgetc();
        }

        if ($this->splFileObject->key() !== $originalLne) {
            throw new OutOfBoundsException();
        }

        return $character;
    }

    /**
     * @return string
     * @throws OutOfBoundsException
     */
    public function getNextLineContent()
    {
        if ($this->splFileObject->key() + 1 > $this->countLines()) {
            throw new OutOfBoundsException();
        }

        $this->splFileObject->next();

        $content = $this->cleanLineContent($this->splFileObject->current());

        $this->goToLine($this->splFileObject->key() - 1);

        return $content;
    }

    /**
     * @return string
     * @throws OutOfBoundsException
     */
    public function getPreviousLineContent()
    {
        if ($this->splFileObject->key() - 1 < 0) {
            throw new OutOfBoundsException();
        }

        $this->splFileObject->seek($this->splFileObject->key() - 1);

        $content = $this->cleanLineContent($this->splFileObject->current());

        $this->goToLine($this->splFileObject->key() + 1);

        return $content;
    }

    /**
     * @return string
     */
    public function getCurrentLineContent()
    {
        $this->splFileObject->seek($this->splFileObject->key());

        return $this->cleanLineContent($this->splFileObject->current());
    }

    /**
     * @param string $content
     * @param string $mode
     * @param bool   $newLine
     */
    public function writeToLine($content, $mode = self::MODE_WRITE_PREPEND, $newLine = false)
    {
        if ($mode === self::MODE_WRITE_PREPEND) {
            $originalSeek = $this->splFileObject->ftell();

            // Refresh file size
            clearstatcache($this->fileName);

            $contentAfter = $this->splFileObject->fread($this->splFileObject->getSize() - $this->splFileObject->ftell());

            $this->splFileObject->fseek($originalSeek);

            $this->splFileObject->fwrite($content . ($newLine ? PHP_EOL : ''));

            $this->splFileObject->fwrite($contentAfter);
        } else {
            $this->splFileObject->fwrite($content);
        }
    }

    /**
     * @param string $content
     * @param string $mode
     */
    public function writeToNewLine($content, $mode = self::MODE_WRITE_PREPEND)
    {
        $this->writeToLine($content, $mode, true);
    }

    /**
     * @param string $content
     *
     * @return string
     */
    protected function cleanLineContent($content)
    {
        return trim($content);
    }
}
