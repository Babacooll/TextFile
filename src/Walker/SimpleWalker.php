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
        $file->rewind();

        if ($characterNumber < 0 || $characterNumber > $file->getSize()) {
            throw new OutOfBoundsException();
        }

        for ($i = 0; $i <= $characterNumber - 1; $i++) {
            $file->fgetc();
        }

        return $file;
    }

    /**
     * {@inheritdoc}
     */
    public function countLines(\SplFileObject $file)
    {
        // Refresh file size
        clearstatcache($file->getFilename());

        $previous = $file->key();

        $file->seek($file->getSize());

        $count = $file->key();

        $file->seek($previous);

        return $count;
    }
}
