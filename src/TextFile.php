<?php

namespace TextFile;

use Symfony\Component\Filesystem\Filesystem;
use TextFile\Exception\InvalidReaderException;
use TextFile\Exception\InvalidWalkerException;
use TextFile\Exception\InvalidWriterException;
use TextFile\Exception\OutOfBoundsException;
use TextFile\Factory\ReaderFactory;
use TextFile\Factory\WalkerFactory;
use TextFile\Factory\WriterFactory;
use TextFile\Reader\SimpleReader;
use TextFile\Walker\SimpleWalker;
use TextFile\Writer\PrependingWriter;

/**
 * Class TextFile
 *
 * @package TextFile
 */
class TextFile
{
    /** @var \SplFileObject */
    protected $splFileObject;

    /** @var string */
    protected $fileName;

    /** @var Filesystem */
    protected $fileSystem;

    /** @var int */
    protected $currentLine = 0;

    /** @var WriterFactory */
    protected $writerFactory;

    /** @var WalkerFactory */
    protected $walkerFactory;

    /** @var ReaderFactory */
    protected $readerFactory;

    /**
     * TextFile constructor.
     *
     * @param string $fileName
     */
    public function __construct($fileName)
    {
        $this->fileSystem    = new Filesystem();
        $this->fileName      = $fileName;
        $this->writerFactory = new WriterFactory();
        $this->walkerFactory = new WalkerFactory();
        $this->readerFactory = new ReaderFactory();

        $this->open($fileName);
    }

    /**
     * @param string $fileName
     */
    public function open($fileName)
    {
        if (!$this->fileSystem->exists($fileName)) {
            $this->createEmpty($fileName);
        }

        $this->splFileObject = new \SplFileObject($fileName, 'r+b');
    }

    /**
     * @return \SplFileObject
     */
    public function getSplFileObject()
    {
        return $this->splFileObject;
    }

    /**
     * @param int    $from
     * @param int    $to
     * @param string $readerClass
     * @param string $walkerClass
     *
     * @return \LimitIterator
     * @throws InvalidReaderException
     * @throws InvalidWalkerException
     * @throws OutOfBoundsException
     */
    public function getLinesRange($from, $to, $readerClass = SimpleReader::class, $walkerClass = SimpleWalker::class)
    {
        $walker = $this->walkerFactory->createWalker($walkerClass);

        return $this->readerFactory->createReader($readerClass, $walker)->getLinesRange($this->splFileObject, $from, $to);
    }

    /**
     * @param string $walkerClass
     *
     * @return int
     * @throws InvalidWalkerException
     */
    public function countLines($walkerClass = SimpleWalker::class)
    {
        return $this->walkerFactory->createWalker($walkerClass)->countLines($this->splFileObject);
    }

    /**
     * @param int    $lineNumber
     * @param string $walkerClass
     *
     * @throws OutOfBoundsException
     * @throws InvalidWalkerException
     */
    public function goToLine($lineNumber, $walkerClass = SimpleWalker::class)
    {
        $this->walkerFactory->createWalker($walkerClass)->goToLine($this->splFileObject, $lineNumber);
    }

    /**
     * @param int    $characterNumber
     * @param string $walkerClass
     *
     * @return string
     * @throws OutOfBoundsException
     */
    public function goBeforeCharacter($characterNumber, $walkerClass = SimpleWalker::class)
    {
        $this->walkerFactory->createWalker($walkerClass)->goBeforeCharacter($this->splFileObject, $characterNumber);
    }

    /**
     * @param string $readerClass
     * @param string $walkerClass
     *
     * @return string
     * @throws InvalidReaderException
     * @throws OutOfBoundsException
     */
    public function getNextLineContent($readerClass = SimpleReader::class, $walkerClass = SimpleWalker::class)
    {
        $walker = $this->walkerFactory->createWalker($walkerClass);

        return $this->readerFactory->createReader($readerClass, $walker)->getNextLineContent($this->splFileObject);
    }

    /**
     * @param string $readerClass
     * @param string $walkerClass
     *
     * @return string
     * @throws InvalidReaderException
     * @throws OutOfBoundsException
     */
    public function getPreviousLineContent($readerClass = SimpleReader::class, $walkerClass = SimpleWalker::class)
    {
        $walker = $this->walkerFactory->createWalker($walkerClass);

        return $this->readerFactory->createReader($readerClass, $walker)->getPreviousLineContent($this->splFileObject);
    }

    /**
     * @param string $readerClass
     * @param string $walkerClass
     *
     * @return string
     * @throws InvalidReaderException
     * @throws OutOfBoundsException
     */
    public function getCurrentLineContent($readerClass = SimpleReader::class, $walkerClass = SimpleWalker::class)
    {
        $walker = $this->walkerFactory->createWalker($walkerClass);

        return $this->readerFactory->createReader($readerClass, $walker)->getCurrentLineContent($this->splFileObject);
    }

    /**
     * @param int    $lineNumber
     * @param string $readerClass
     * @param string $walkerClass
     *
     * @return string
     * @throws InvalidReaderException
     * @throws OutOfBoundsException
     */
    public function getLineContent($lineNumber, $readerClass = SimpleReader::class, $walkerClass = SimpleWalker::class)
    {
        $walker = $this->walkerFactory->createWalker($walkerClass);

        return $this->readerFactory->createReader($readerClass, $walker)->getLineContent($this->splFileObject, $lineNumber);
    }

    /**
     * @param string $readerClass
     * @param string $walkerClass
     *
     * @return string
     * @throws InvalidReaderException
     * @throws OutOfBoundsException
     */
    public function getNextCharacterContent($readerClass = SimpleReader::class, $walkerClass = SimpleWalker::class)
    {
        $walker = $this->walkerFactory->createWalker($walkerClass);

        return $this->readerFactory->createReader($readerClass, $walker)->getNextCharacterContent($this->splFileObject);
    }

    /**
     * @param string $readerClass
     * @param string $walkerClass
     *
     * @return string
     * @throws InvalidReaderException
     * @throws OutOfBoundsException
     */
    public function getPreviousCharacterContent($readerClass = SimpleReader::class, $walkerClass = SimpleWalker::class)
    {
        $walker = $this->walkerFactory->createWalker($walkerClass);

        return $this->readerFactory->createReader($readerClass, $walker)->getPreviousCharacterContent($this->splFileObject);
    }

    /**
     * @param int    $characterNumber
     * @param string $readerClass
     * @param string $walkerClass
     *
     * @return string
     * @throws InvalidReaderException
     * @throws OutOfBoundsException
     */
    public function getCharacterContent($characterNumber, $readerClass = SimpleReader::class, $walkerClass = SimpleWalker::class)
    {
        $walker = $this->walkerFactory->createWalker($walkerClass);

        return $this->readerFactory->createReader($readerClass, $walker)->getCharacterContent($this->splFileObject, $characterNumber);
    }

    /**
     * @param string $content
     * @param bool   $newLine
     * @param string $writerClass
     *
     * @throws InvalidWriterException
     */
    public function writeToLine($content, $newLine = false, $writerClass = PrependingWriter::class)
    {
        $this->writerFactory->createWriter($writerClass)->write($this->splFileObject, $content, $newLine);
    }

    /**
     * @param string $fileName
     */
    protected function createEmpty($fileName)
    {
        $this->fileSystem->touch($fileName);
    }
}
