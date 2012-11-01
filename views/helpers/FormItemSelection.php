<?php
/**
 * This file defines a view helper for use with the
 * ForbesPurchaseForm_Form_Element_ItemSelection.
 *
 * @author Benjamin Kalish <bkalish@forbeslibrary.org>
 * @package ForbesPurchaseForm
 * @subpackage view-helpers
 * @see ForbesPurchaseForm_Form_Element_ItemSelection
 */

require_once 'Zend/View/Helper/HtmlElement.php';

/**
 * A view helper for use with ForbesPurchaseForm_Form_Element_ItemSelection.
 *
 * @author Benjamin Kalish <bkalish@forbeslibrary.org>
 * @package ForbesPurchaseForm
 * @subpackage view-helpers
 * @see ForbesPurchaseForm_Form_Element_ItemSelection
 */
class ForbesPurchaseForm_Views_Helpers_FormItemSelection extends Zend_View_Helper_FormElement {

     public function formItemSelection($name, $values = null, $attribs = null, $options = null) {
        $info = $this->_getInfo($name, $values, $attribs, $options);
        extract($info); // Move paramaters into variable namespace

        // remove the '[]' from the end of the name
        $name = substr($name, 0, -2);

        // assign the $view variable for convenience
        $view = $this->view;

        // assign the id for the container element (a table)
        $tableId = $name.'-element';

        // Label and opening table tag
        $html = $this->_getJavascript($tableId);
        $html .= '<table id="'.$tableId.'">';

        // Table row with checkbox for each item
        foreach ($options as $itemId => $value) {
            set_current_item(get_item_by_id($itemId));

            // is this image checked?
            $checked = '';
            if ($values[$itemId]==$itemId) {
                $checked='checked="checked"';
            }

            // table row
            $hidden = "<input id=\"${name}-$itemId-hidden\" type=\"hidden\" name=\"${name}[$itemId]\" value=\"0\">";
            $checkbox = "<input id=\"${name}-$itemId\" type=\"checkbox\" name=\"${name}[$itemId]\" value=\"$itemId\" $checked/>";
            $title = item('Dublin Core','Title',array('snippet'=>30));
            $title = link_to_item($title, array('target'=>'_blank'));
            $identifier = item('Dublin Core','Identifier') ? item('Dublin Core','Identifier') : 'omeka:'.$view->escape($itemId);
            $thumb = item_square_thumbnail(array('alt'=>'', 'style'=>'height:3em; width:3em; vertical-align:middle;'));

            $html .= "<tr><td>{$hidden}{$checkbox}</td><td><label for=\"${name}-$itemId\"?>$thumb$identifier</label></td><td>$title</td></tr>";
        };
        $html .= '</table>';
        return $html;
     }

     /**
      * Inserts a javascript which enchances this elemnet by adding a
      * 'Select/Deselect All' checkbox.
      */
     protected function _getJavascript($tableId) {
         return <<<JAVASCRIPT
<script>
jQuery(document).ready( function () {
    if (jQuery('#${tableId} input[type=checkbox]').length < 2 ) { return; }
    var magicCheckboxId = '$tableId-magicCheckbox';
    magicCheckbox = jQuery('<input type="checkbox"/>');
    magicCheckbox.attr('id',magicCheckboxId);
    magicCheckbox.change(
    function() {
        if (magicCheckbox.is(':checked')) {
            jQuery('#${tableId} input[type=checkbox]').prop('checked','checked');
        } else {
            jQuery('#${tableId} input[type=checkbox]').prop('checked','');
        }
        });
    var cell = jQuery('<td></td>').append(magicCheckbox);
    var row = jQuery('<tr></tr>').append(cell);
    var label = jQuery('<label>Select/Deselect All</label>').attr('for',magicCheckboxId);
    cell = jQuery('<td></td>').append(label);
    row.append(cell);
    row.prependTo('#${tableId}')
});
</script>
JAVASCRIPT;
    }
}
