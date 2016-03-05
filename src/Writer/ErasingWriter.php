<?php

namespace TextFile\Writer;

/**
 * Class ErasingWriter
 *
 * @package TextFile\Writer
 */
class ErasingWriter implements WriterInterface
{
    /**
     * {@inheritdoc}
     */
    public function write(\SplFileObject $file, $text, $newLineAtEnd = false)
    {
        $file->fwrite($text . ($newLineAtEnd ? PHP_EOL : ''));

        return $file;
    }
}
