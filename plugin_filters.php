<?
/**
 * Plugin filters for ForbesPurchasForm
 *
 * This file is required by plugin.php and defines the plugin filter
 * which are added to Omeka in that file.
 *
 * @author Benjamin Kalish <bkalish@forbeslibrary.org>
 * @package ForbesPurchaseForm
 * @see plugin.php
 * @see plugin_hooks.php
 */


/**
 * Modifies the main navigation to include a link to the shopping cart.
 */
function forbes_purchase_form_public_navigation_main($nav){
    $selectionMapper = new ForbesPurchaseForm_Model_Mapper_SelectionMapper();
    $selection = $selectionMapper->get();
    $count = $selection->count();
    $text = __('Cart');

    $nav["$text ($count)"] = uri(array(), 'forbes_purchase_form_show_selection');
    return $nav;
}
