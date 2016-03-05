<?php

namespace TextFile\Reader;

use TextFile\Exception\OutOfBoundsException;
use TextFile\Walker\WalkerInterface;

/**
 * Interface ReaderInterface
 *
 * @package TextFile\Reader
 */
interface ReaderInterface
{
    /**
     * @param WalkerInterface $walker
     */
    public function __construct(WalkerInterface $walker);

    /**
     * @param \SplFileObject $file
     * @param int            $from
     * @param int            $to
     *
     * @return \LimitIterator
     */
    public function getLinesRange(\SplFileObject $file, $from, $to);

    /**
     * @param \SplFileObject $file
     *
     * @throws OutOfBoundsException
     * @return string
     */
    public function getNextLineContent(\SplFileObject $file);

    /**
     * @param \SplFileObject $file
     *
     * @throws OutOfBoundsException
     * @return string
     */
    public function getPreviousLineContent(\SplFileObject $file);

    /**
     * @param \SplFileObject $file
     *
     * @throws OutOfBoundsException
     * @return string
     */
    public function getCurrentLineContent(\SplFileObject $file);

    /**
     * @param \SplFileObject $file
     * @param int            $lineNumber
     *
     * @throws OutOfBoundsException
     * @return string
     */
    public function getLineContent(\SplFileObject $file, $lineNumber);

    /**
     * @param \SplFileObject $file
     *
     * @throws OutOfBoundsException
     * @return string
     */
    public function getNextCharacterContent(\SplFileObject $file);

    /**
     * @param \SplFileObject $file
     *
     * @throws OutOfBoundsException
     * @return string
     */
    public function getPreviousCharacterContent(\SplFileObject $file);

    /**
     * @param \SplFileObject $file
     * @param int            $characterNumber
     *
     * @throws OutOfBoundsException
     * @return string
     */
    public function getCharacterContent(\SplFileObject $file, $characterNumber);

    /**
     * @param string $content
     *
     * @return string
     */
    public function cleanLineContent($content);
}
