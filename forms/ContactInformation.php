<?php
/**
 * This file defines the contact information form,
 * ForbesPurchaseForm_Form_ContactInformation.
 *
 * @author Benjamin Kalish <bkalish@forbeslibrary.org>
 * @package ForbesPurchaseForm
 * @subpackage forms
 */

class ForbesPurchaseForm_Form_ContactInformation
    extends ForbesPurchaseFormLibrary_RequestBase
{
    public function init()
    {
        parent::init();
        $this->_addElements();
        $this->_addValidators();
        $this->_setRequiredElements();
        $this->_setDefaultValues();
    }

    protected function _addElements()
    {
        $displayGroup['contact'][] = new Zend_Form_Element_Text('name');
        $displayGroup['contact'][] = new Zend_Form_Element_Text('email');
        $displayGroup['contact'][] = new Zend_Form_Element_Text('addressLineOne');
        $displayGroup['contact'][] = new Zend_Form_Element_Text('addressLineTwo');
        $displayGroup['contact'][] = new Zend_Form_Element_Text('city');
        $displayGroup['contact'][] = new Zend_Form_Element_Text('stateOrRegion');
        $displayGroup['contact'][] = new Zend_Form_Element_Text('postalCode');
        $displayGroup['contact'][] = new Zend_Form_Element_Select('country');
        $displayGroup['contact'][] = new Zend_Form_Element_Text('phone');
        $displayGroup['organization'][] = new Zend_Form_Element_Text('organizationName');
        $displayGroup['organization'][] = new Zend_Form_Element_Checkbox('isOrgGovernment');
        $displayGroup['organization'][] = new Zend_Form_Element_Checkbox('isOrgNonProfit');
        $displayGroup['organization'][] = new Zend_Form_Element_Checkbox('isOrgPublicAccessTV');
        $displayGroup['submit'][] = new Zend_Form_Element_Submit('submit');

        foreach ($displayGroup as $name => $elements) {
            $this->addElements($elements);
            $this->addDisplayGroup($elements, "$name-group");
        }

        $countries = Zend_Locale::getTranslationList('Territory','en_US',2);
        unset($countries['ZZ']);
        asort($countries);
        $this->getElement('country')
            ->addMultiOptions($countries);

    }

    protected function _addValidators()
    {
        $this->getElement('email')->addValidator('EmailAddress', True);
    }
    
    protected function _setDefaultValues() {
        $this->getElement('country')->setValue('US');
    }
    
    protected function _setRequiredElements()
    {
        $this->getElement('name')->setRequired();
        $this->getElement('email')->setRequired();
        $this->getElement('addressLineOne')->setRequired();
        $this->getElement('city')->setRequired();
        $this->getElement('stateOrRegion')->setRequired();
        $this->getElement('country')->setRequired();
    }
}
