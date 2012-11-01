<?php
/**
 * This file defines a form which shows the current selection (i.e.,
 * cart) and lets the user modify it by removing items or take an action
 * on some subset of the selection.
 *
 * Currently the only supported action is placing a reproduction
 * request.
 *
 * @author Benjamin Kalish <bkalish@forbeslibrary.org>
 * @package ForbesPurchaseForm
 * @subpackage forms
 */

class ForbesPurchaseForm_Form_SelectionForm extends Zend_Form
{
    protected $_itemIds;

    public function __construct($itemIds, $options = null) {
        $this->_itemIds = $itemIds;
        parent::__construct($options);
    }

    public function loadDefaultDecorators() {
        $this->setDecorators(array(
            'FormElements',
            'Form'
        ));

        //Set decorators for the displaygroup:
        $this->setDisplayGroupDecorators(array(
            'FormElements',
            'Fieldset',
        ));
        return $this;
    }

    public function init() {
        parent::init();
        $this->setMethod('post');
        $this->_addElements();
        $this->_addValidators();
        $this->_setRequiredElements();
    }

    public function isValid($data) {
        // Skip default validators for certain submissions
        if (isset($data['empty'])) {
            return True;
        }
        return parent::isValid($data);
    }

    protected function _addElements() {
        $items = new ForbesPurchaseForm_Form_Element_ItemSelection('items');
        $items->setLabel('Selected Items');
        $items->setValue($this->_itemIds);
        $items->setItemIds(array_keys($this->_itemIds));
        $this->addElement($items)
            ->addElement('submit', 'empty')
            ->addElement('submit', 'removeselected')
            ->addElement('submit','purchase');
    }

    protected function _addValidators() {
        // no additional validators for this form
    }

    protected function _setRequiredElements() {
        // no required elements for this form
    }
}


