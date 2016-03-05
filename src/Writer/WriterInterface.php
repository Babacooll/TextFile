<?php

namespace TextFile\Writer;

/**
 * Interface WriterInterface
 *
 * @package TextFile\Writer
 */
interface WriterInterface
{
    /**
     * @param \SplFileObject $file
     * @param string         $text
     * @param bool           $newLineAtEnd
     *
     * @return \SplFileInfo
     */
    public function write(\SplFileObject $file, $text, $newLineAtEnd = false);
}
