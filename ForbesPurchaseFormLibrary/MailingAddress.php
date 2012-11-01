<?php
/**
 * This file defines the MailingAddress class.
 *
 * @author Benjamin Kalish <bkalish@forbeslibrary.org>
 * @package ForbesPurchaseForm
 * @subpackage library
 */

/**
 * A simple Mailing address class
 */
 
 class ForbesPurchaseFormLibrary_MailingAddress {
    /**
     * The first line of the address.
     *
     * @var string
     */
    public $lineOne;

    /**
     * The second line of the address.
     *
     * @var string
     */
    public $lineTwo;

    /**
     * The city.
     *
     * @var string
     */
    public $city;

    /**
     * The state, region, or province.
     *
     * @var string
     */
    public $stateOrRegion;

    /**
     * The postal code.
     *
     * @var string
     */
    public $postalCode;

    /**
     * The country.
     *
     * This should be stored as a CLDR Teritory code as found in the
     * array keys found in
     * <code>Zend_Locale::getTranslationList('Territory','en_US',2);</code>
     *
     * @var string
     * @see http://www.unicode.org/cldr/charts/by_type/code_lists.territories.html
     */
    public $country = 'US';

}