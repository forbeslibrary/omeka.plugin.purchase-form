<?php
/**
 * This file defines the reproduction options form,
 * ForbesPurchaseForm_Form_ReproductionOptions.
 *
 * @author Benjamin Kalish <bkalish@forbeslibrary.org>
 * @package ForbesPurchaseForm
 * @subpackage forms
 */

 class ForbesPurchaseForm_Form_ReproductionOptions
    extends ForbesPurchaseFormLibrary_RequestBase
{
    public function init()
    {
        parent::init();
        $this->_addElements();
        $this->_addValidators();
        $this->_setRequiredElements();
    }

    protected function _addElements()
    {
        $displayGroup['options'][] = new Zend_Form_Element_MultiCheckbox('deliverables');
        $displayGroup['instructions'][] = new Zend_Form_Element_Textarea('reproductionInstructions');
        $displayGroup['use'][] = new Zend_Form_Element_Radio('intendedUse');
        $displayGroup['use'][] = new Zend_Form_Element_Checkbox('checkedUnderstandPolicyConfirmation');
        $displayGroup['submit'][] = new Zend_Form_Element_Submit('submit');

        foreach ($displayGroup as $name => $elements) {
            $this->addElements($elements);
            $this->addDisplayGroup($elements, "$name-group");
        }

        $this->getElement('deliverables')->setMultiOptions(array_flip(array(
            'downloadableFiles',
            'discWithFiles',
            'smallPrints',
            'largePrints',
            'noReproductions',
            )));

        $this->getElement('intendedUse')->setMultiOptions(array_flip(array(
            'personalUse',
            'otherUse',
            )));
    }

    /**
     * Adds validators.
     *
     * @todo add validator requiring otherUse if noReproductions is set
     * @todo add validator making noReproductions mutually exclusive
     * with other deliverables.
     */
    protected function _addValidators()
    {
    }

    protected function _setRequiredElements()
    {
        $this->getElement('intendedUse');
        $this->getElement('checkedUnderstandPolicyConfirmation')->setUncheckedValue('');
        $this->getElement('checkedUnderstandPolicyConfirmation')->setRequired();
    }
}
