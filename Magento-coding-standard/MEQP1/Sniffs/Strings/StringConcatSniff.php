<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace MEQP1\Sniffs\Strings;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Util\Tokens;

/**
 * Class StringConcatSniff
 * Detects string concatenation via '+' operator.
 */
class StringConcatSniff implements Sniff
{
    /**
     * Violation severity.
     *
     * @var int
     */
    protected $severity = 8;

    /**
     * String representation of warning.
     *
     * @var string
     */
    protected $warningMessage = 'Use of + operator to concatenate two strings detected';

    /**
     * Warning violation code.
     *
     * @var string
     */
    protected $warningCode = 'ImproperStringConcatenation';

    /**
     * @inheritdoc
     */
    public function register()
    {
        return [T_PLUS];
    }

    /**
     * @inheritdoc
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $prev = $phpcsFile->findPrevious(T_WHITESPACE, $stackPtr - 1, null, true);
        $next = $phpcsFile->findNext(T_WHITESPACE, $stackPtr + 1, null, true);
        if ($prev === false || $next === false) {
            return;
        }
        $beforePrev = $phpcsFile->findPrevious(T_WHITESPACE, $prev - 1, null, true);
        $stringTokens = Tokens::$stringTokens;
        if ($tokens[$beforePrev]['code'] === T_STRING_CONCAT
            || in_array($tokens[$prev]['code'], $stringTokens)
            || in_array($tokens[$next]['code'], $stringTokens)
        ) {
            $phpcsFile->addWarning($this->warningMessage, $stackPtr, $this->warningCode, [], $this->severity);
        }
    }
}
