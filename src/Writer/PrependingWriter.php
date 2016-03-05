<?php

namespace TextFile\Writer;

/**
 * Class PrependingWriter
 *
 * @package TextFile\Writer
 */
class PrependingWriter implements WriterInterface
{
    /**
     * {@inheritdoc}
     */
    public function write(\SplFileObject $file, $text, $newLineAtEnd = false)
    {
        $originalSeek = $file->ftell();

        // Refresh file size
        clearstatcache($file->getFilename());

        if ($file->getSize() - $file->ftell() > 0) {
            $contentAfter = $file->fread($file->getSize() - $file->ftell());
        } else {
            $contentAfter = '';
        }

        $file->fseek($originalSeek);

        $file->fwrite($text . ($newLineAtEnd ? PHP_EOL : ''));

        $file->fwrite($contentAfter);

        return $file;
    }
}
