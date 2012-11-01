<?php
/**
 * This file defines a form element for modifying a Selection.
 *
 * @author Benjamin Kalish <bkalish@forbeslibrary.org>
 * @package ForbesPurchaseForm
 * @subpackage form-elements
 * @see ForbesPurchaseForm_Model_Selection
 * @see ForbesPurchaseForm_Views_Helpers_FormItemSelection
 * @todo consider moving this, and all form elements, to the library
 */

/**
 * An extension of Zend_Form_Element_MultiCheckbox for selecting Omeka
 * Items from a list.
 *
 * Items can be added to the list using the setItemIds() method.
 *
 * The value of this element is an array, with each item in the list
 * represented by a $key => $value pair where $key is the item id and
 * $value is 0 for an unchecked item and the item id for a checked item.
 *
 * @see ForbesPurchaseForm_Model_Selection
 * @see ForbesPurchaseForm_Views_Helpers_FormItemSelection
 */
class ForbesPurchaseForm_Form_Element_ItemSelection extends Zend_Form_Element_MultiCheckbox {
    public $helper = 'FormItemSelection';

    /**
     * Sets the items in this checklist.
     */
    public function setItemIds($itemIds) {
        foreach ($itemIds as $itemId) {
            $this->addMultiOption($itemId, $itemId);
        }
    }

    /**
     * Initializes the element. In particular, this sets the custom
     * validators.
     */
    public function init() {
        $this->setRegisterInArrayValidator(False);
        // add validators
        $this->addValidator(new ForbesPurchaseForm_Validate_ItemSelection($this->getName()), true);
    }

}

/**
 * A validator which ensures that the ItemSelection is not empty.
 *
 * @todo Move this into it's own file.
 */
class ForbesPurchaseForm_Validate_ItemSelection extends Zend_Validate_Abstract
{
    const NOT_EMPTY = 'notEmpty';

    protected $_elementName = null;

    protected $_messageTemplates = array(
        self::NOT_EMPTY => "'%value%' must contain at least one item",
    );

    public function __construct($elementName) {
        $this->_elementName = $elementName;
    }

    public function isValid($value, $context=null)
    {
        $this->_setValue($this->_elementName);

        $isValid = true;

        // at least one must be checked
        $checkCount = count(array_filter($context[$this->_elementName]));
        if ($checkCount == 0) {
            $this->_error(self::NOT_EMPTY);
            $isValid = false;
        }

        return $isValid;
    }
}
