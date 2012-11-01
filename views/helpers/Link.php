<?php
/**
 * This file defines a view helper for programatically creating
 * anchor elements (links) in html.
 *
 * @author Benjamin Kalish <bkalish@forbeslibrary.org>
 * @package ForbesPurchaseForm
 * @subpackage view-helpers
 * @see ForbesPurchaseForm_Form_Element_ItemSelection
 */

require_once 'Zend/View/Helper/HtmlElement.php';

class ForbesPurchaseForm_Views_Helpers_Link extends Zend_View_Helper_HtmlElement {

    /**
     * Creates an anchor (link) element.
     *
     * @param string $url
     * @param string $content
     * @param array $attribs
     * @return string
     */
    public function link($url, $content = '', $attribs = null)
    {
        $attribs = $this->_htmlAttribs($attribs);

        $content = empty($content) ? $url : $content;

        $html = '<a '
                . 'href="'.$url.'"'
                . $attribs
                . '>'
                . $content
                . '</a>';

        return $html;
    }

}
