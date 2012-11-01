<?php
/**
 * This file defines a mapper for the selection model.
 *
 * @author Benjamin Kalish <bkalish@forbeslibrary.org>
 * @package ForbesPurchaseForm
 * @subpackage model-mappers
 */

/**
 * Provides methods to retrieve and save the current selection.
 */
class ForbesPurchaseForm_Model_Mapper_SelectionMapper {

    protected static $_sessionNamespace;

    public function __construct() {
        if (!self::$_sessionNamespace) {
            self::$_sessionNamespace = new Zend_Session_Namespace('forbes_purchase_form_selections');
        }
        if (!self::$_sessionNamespace->selectedItems) {
            self::$_sessionNamespace->selectedItems = array();
        }
    }

    /**
     * Gets the Selection for the current user session.
     *
     * There is only ever one Selection to get, so this function does
     * not take any parameters.
     */
    public function get() {
        $selection = new ForbesPurchaseForm_Model_Selection();
        $selection->setItemIds(self::$_sessionNamespace->selectedItems);
        return $selection;
    }

    /**
     * Saves the Selection for the current user session.
     *
     * Note that saving is neccesary! Changes made to a selection but
     * not saved may not be stick!
     */
    public function save($selection) {
        self::$_sessionNamespace->selectedItems = $selection->getItemIds();
    }
}
