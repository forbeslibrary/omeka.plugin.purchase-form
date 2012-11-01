<?php
/**
 * This file defines a view helper for displaying a mailing address defined as a
 * ForbesPurchaseFormLibrary_MailingAddress
 *
 * @author Benjamin Kalish <bkalish@forbeslibrary.org>
 * @package ForbesPurchaseForm
 * @subpackage view-helpers
 * @see ForbesPurchaseForm_Form_Element_ItemSelection
 */

require_once 'Zend/View/Helper/HtmlElement.php';

class ForbesPurchaseForm_Views_Helpers_MailingAddress extends Zend_View_Helper_Abstract {

    /**
     * Displays a mailing address.
     *
     * @param string $url
     * @param string $content
     * @param array $attribs
     * @return string
     */
    public function mailingAddress($address)
    {
        $format = '%s<br>%s<br>%s<br>%s<br>%s';
        if ($address->country == 'US') {
            $format = '%s<br>%s, %s %s';
        }

        return sprintf($format,
            $address->lineTwo ? $address->lineOne . '<br>' . $address->lineTwo : $address->lineOne,
            $address->city,
            $address->stateOrRegion,
            $address->postalCode,
            $address->country);
    }

}
