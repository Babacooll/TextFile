<?php

namespace TextFile\Walker;

use TextFile\Exception\OutOfBoundsException;

/**
 * Interface WalkerInterface
 *
 * @package TextFile\Walker
 */
interface WalkerInterface
{
    /**
     * @param \SplFileObject $file
     * @param int            $lineNumber
     *
     * @throws OutOfBoundsException
     * @return \SplFileObject
     */
    public function goToLine(\SplFileObject $file, $lineNumber);

    /**
     * @param \SplFileObject $file
     * @param int            $characterNumber
     *
     * @throws OutOfBoundsException
     * @return \SplFileObject
     */
    public function goBeforeCharacter(\SplFileObject $file, $characterNumber);

    /**
     * @param \SplFileObject $file
     *
     * @return int
     */
    public function countLines(\SplFileObject $file);
}
