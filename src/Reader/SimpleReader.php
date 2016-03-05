<?php

namespace TextFile\Reader;

use TextFile\Exception\OutOfBoundsException;
use TextFile\Walker\WalkerInterface;

/**
 * Class SimpleReader
 *
 * @package TextFile\Reader
 */
class SimpleReader implements ReaderInterface
{
    /**
     * @var WalkerInterface
     */
    protected $walker;

    /**
     * {@inheritdoc}
     */
    public function __construct(WalkerInterface $walker)
    {
        $this->walker = $walker;
    }

    /**
     * {@inheritdoc}
     */
    public function getLinesRange(\SplFileObject $file, $from, $to)
    {
        if ($from < 0 || $to > $this->walker->countLines($file)) {
            throw new OutOfBoundsException();
        }

        return new \LimitIterator($file, $from, $to);
    }

    /**
     * {@inheritdoc}
     */
    public function getNextLineContent(\SplFileObject $file)
    {
        if ($file->key() + 1 > $this->walker->countLines($file)) {
            throw new OutOfBoundsException();
        }

        $file->next();

        $content = $this->getCurrentLineContent($file);

        $this->walker->goToLine($file, $file->key() - 1);

        return $content;
    }

    /**
     * {@inheritdoc}
     */
    public function getPreviousLineContent(\SplFileObject $file)
    {
        if ($file->key() - 1 < 0) {
            throw new OutOfBoundsException();
        }

        $file->seek($file->key() - 1);

        $content = $this->getCurrentLineContent($file);

        $this->walker->goToLine($file, $file->key() + 1);

        return $content;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentLineContent(\SplFileObject $file)
    {
        $file->seek($file->key());

        $content = $file->current();

        return $this->cleanLineContent(is_string($content) ? $content : '');
    }

    /**
     * {@inheritdoc}
     */
    public function getLineContent(\SplFileObject $file, $lineNumber)
    {
        if ($lineNumber > $this->walker->countLines($file) || $lineNumber < 0) {
            throw new OutOfBoundsException();
        }

        $originalLineNumber = $file->key();

        $this->walker->goToLine($file, $lineNumber);

        $content = $this->getCurrentLineContent($file);

        $this->walker->goToLine($file, $originalLineNumber);

        return $content;
    }

    /**
     * {@inheritdoc}
     */
    public function getNextCharacterContent(\SplFileObject $file)
    {
        $originalPosition = $file->ftell();

        $character = $file->fgetc();

        $this->walker->goBeforeCharacter($file, $originalPosition);

        return $character;
    }

    /**
     * {@inheritdoc}
     */
    public function getPreviousCharacterContent(\SplFileObject $file)
    {
        $originalPosition = $file->ftell();

        $this->walker->goBeforeCharacter($file, $originalPosition - 1);

        $character = $file->fgetc();

        $this->walker->goBeforeCharacter($file, $originalPosition);

        return $character;
    }

    /**
     * {@inheritdoc}
     */
    public function getCharacterContent(\SplFileObject $file, $characterNumber)
    {
        $originalPosition = $file->ftell();

        $this->walker->goBeforeCharacter($file, $characterNumber);

        $character = $this->getNextCharacterContent($file);

        $this->walker->goBeforeCharacter($file, $originalPosition);

        return $character;
    }

    /**
     * {@inheritdoc}
     */
    public function cleanLineContent($content)
    {
        return trim($content);
    }
}
