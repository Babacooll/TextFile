<?php

namespace TextFile\Walker;

use TextFile\Exception\OutOfBoundsException;

/**
 * Class SimpleWalker
 *
 * @package TextFile\Walker
 */
class SimpleWalker implements WalkerInterface
{
    /**
     * {@inheritdoc}
     */
    public function goToLine(\SplFileObject $file, $lineNumber)
    {
        if ($lineNumber < 0 || $lineNumber > $this->countLines($file)) {
            throw new OutOfBoundsException();
        }

        $file->rewind();

        for ($i = 0; $i < $lineNumber; $i++) {
            $file->next();
            $file->current();
        }

        return $file;
    }

    /**
     * {@inheritdoc}
     */
    public function goBeforeCharacter(\SplFileObject $file, $characterNumber)
    {
        // TODO : Allow to change line ?
        $originalLine = $file->key();

        $this->goToLine($file, $originalLine);

        if ($characterNumber < 0) {
            throw new OutOfBoundsException();
        }

        for ($i = 0; $i <= $characterNumber - 1; $i++) {
            $file->fgetc();
        }

        if ($file->key() !== $originalLine) {
            throw new OutOfBoundsException();
        }

        return $file;
    }

    /**
     * {@inheritdoc}
     */
    public function countLines(\SplFileObject $file)
    {
        $previous = $file->key();

        $file->seek($file->getSize());

        $count = $file->key();

        $file->seek($previous);

        return $count;
    }
}
