<?php
/**
 * Kohana_Sniffs_NamingConventions_ValidVariableNameSniff.
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Matthew Turland <matt@ishouldbecoding.com> 
 * @license   http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @version   CVS: $Id$
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */

namespace Kohana\Sniffs\NamingConventions;

use PHP_CodeSniffer\Sniffs\AbstractVariableSniff;
use PHP_CodeSniffer\Files\File;

/**
 * Checks the naming of variables.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Matthew Turland <matt@ishouldbecoding.com> 
 * @license   http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @version   Release: @release_version@ 
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */
class ValidVariableNameSniff extends AbstractVariableSniff
{
    /**
     * Supporting method to validate variable names.
     *
     * @param File $phpcsFile File being scanned
     * @param int $stackPtr Position of the current token in the stack 
     *        passed in $tokens
     * @return bool TRUE if the variable name is valid, FALSE otherwise
     */
    private function validateName(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $variable = ltrim($tokens[$stackPtr]['content'], '$');

        // If the variable name is dynamic, just ignore it
        if (preg_match('/^\{.*\}$/', $variable)) {
            return;
        }

        if (!preg_match('#^(?:GLOBALS|_(?:SERVER|GET|POST|FILES|COOKIE|SESSION|REQUEST|ENV)|(?:[a-z_\x7f-\xff][a-z0-9_\x7f-\xff]*))$#', $variable)) {
            $phpcsFile->addError('Variable name $' . $variable . ' is not in all lowercase using underscores for word separators', $stackPtr, 'VariableNaming');
        }
    }

    /**
     * Processes class member variables.
     *
     * @param File $phpcsFile File being scanned
     * @param int $stackPtr Position of the current token in the stack 
     *        passed in $tokens
     * @return void
     */
    protected function processMemberVar(File $phpcsFile, $stackPtr)
    {
        $this->validateName($phpcsFile, $stackPtr);
    }

    /**
     * Processes normal variables.
     *
     * @param File $phpcsFile File where this token was found
     * @param int $stackPtr Position where the token was found
     * @return void
     */
    protected function processVariable(File $phpcsFile, $stackPtr)
    {
        $this->validateName($phpcsFile, $stackPtr);
    }

    /**
     * Processes interpolated variables in double quoted strings.
     *
     * @param File $phpcsFile File where this token was found
     * @param int $stackPtr Position where the token was found
     * @return void
     */
    protected function processVariableInString(File $phpcsFile, $stackPtr)
    {
        // Ignore these
        return;
    }
}

?>
