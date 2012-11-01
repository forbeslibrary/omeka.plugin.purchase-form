<?
/**
 * Convenience functions for the ForbesPurchaseForm Omeka plugin
 *
 * @author Benjamin Kalish <bkalish@forbeslibrary.org>
 * @package ForbesPurchaseForm
 */

/**
 * Determine whether a variable is a string with at least one
 * non-whitespace character.
 *
 * @param mixed $data the variable to test
 * @return bool True if $data is a non-empty string, False otherwise.
 */
function isStringWithContent($data) {
    if (!is_string($data)) {
        return False;
    }
    if (trim($data)==='') {
        return False;
    }
    return True;
}
