<?php
/**
 * This file defines the Selection model, ForbesPurchaseForm_Model_Selection
 *
 * @author Benjamin Kalish <bkalish@forbeslibrary.org>
 * @package ForbesPurchaseForm
 * @subpackage models
 */

/**
 * A selection is a list of items, coresponding to a user's selection.
 *
 * ForbesPurchaseForm_Model_Selection provides methods for interacting with
 * a selection. To retrieve or save a selection, you must use
 * ForbesPurchaseForm_Model_Mapper_SelectionMapper.
 */
class ForbesPurchaseForm_Model_Selection {
    /**
     * An array of item ids.
     *
     * We will use this as a set so we will use the item id as both the
     * key and the value for each entry.
     */
    protected $_itemIds = array();

    /**
     * Adds an item given its id.
     */
    public function addItemById($itemId) {
        $this->_itemIds[$itemId] = $itemId;
    }

    /**
     * Returns True if the item is in the selection.
     */
    public function containsItem($item) {
        return in_array($item->id, $this->_itemIds);
    }

    /**
     * Returns the number of items in the selection
     */
    public function count() {
        return count($this->_itemIds);
    }

    /**
     * Returns all the item ids in the selection.
     */
    public function getItemIds() {
        return $this->_itemIds;
    }

    /**
     * Gets all the items in the selection
     */
    public function getItems() {
        return array_map('get_item_by_id', $this->_itemIds);
    }

    /**
     * Removes all items from selection.
     */
    public function removeAll() {
        $this->_itemIds = array();
    }

    /**
     * Remove the item with the specified id from the selection.
     */
    public function removeItemById($itemId) {
        unset($this->_itemIds[$itemId]);
    }

    /**
     * Remove multiple items specified by a list of ids.
     */
    public function removeItemsById($itemIds) {
        $this->_itemIds = array_diff($this->_itemIds, $itemIds);
    }

    /**
     * Removes the current selection, replacing it with the items with
     * the specified ids.
     */
    public function setItemIds($itemIds) {
        $this->_itemIds = $itemIds;
    }
}
