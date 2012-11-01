<?php
/**
 * This file defines the base form from which all the request forms are
 * derived.
 *
 * @author Benjamin Kalish <bkalish@forbeslibrary.org>
 * @package ForbesPurchaseForm
 * @subpackage library
 */

/**
 * The base type from which all the forms used by the request controller
 * are derived.
 *
 * The request controller gathers data using a series of forms. This
 * class provides functionality for determining which form should be
 * proccessed and which request it belongs to.
 */
class ForbesPurchaseFormLibrary_RequestBase extends Zend_Form
{
    /**
     * The request associated with this form.
     *
     * @var ForbesPurchaseForm_Model_Request
     */
    protected $_request;

    /**
     * Creates a new instance of this form.
     *
     * @param ForbesPurchaseForm_Model_Request $request the request for
     * this form.
     * @param mixed $options Optional options to be passed to the
     * Zend_Form constructor.
     */
    public function __construct(ForbesPurchaseForm_Model_Request $request, $options = null)
    {
        if (is_null($request)) {
            throw Exception('request passed to ' . get_class($this) . ' cannot be NULL.');
        }
        $this->_request = $request;
        $this->setMethod('post');
        $this->addElement('hidden','requestId');
        $this->getElement('requestId')->setValue($this->_request->id);

        $this->addElement('hidden','formId');
        $formId = array_pop(explode('_', get_class($this)));
        $this->getElement('formId')->setValue($formId);
        parent::__construct($options);
    }

    /**
     * Sets the default decorators.
     */
    public function loadDefaultDecorators()
    {                     
        $this->setDecorators(array(
            'FormElements',
            'Form',
            array('Description', array('placement' => 'prepend')),
            array('FormErrors', array('placement' => 'prepend')),
        ));

        $this->setElementDecorators(array(
            'ViewHelper',
            array('Errors', array('placement' => 'prepend')),
            array('Description', array('placement' => 'prepend')),
            new ForbesPurchaseFormLibrary_FormDecorator_Label(),
            array('HtmlTag', array('tag' => 'div')),
        ));

        //Set decorators for the displaygroup:
        $this->setDisplayGroupDecorators(array(
            'FormElements',
            'Fieldset',
        ));
        return $this;
    }

    /**
     * Sets the labels for this form.
     *
     * This method can set all the labels for the form with a single
     * call and is ideal for setting form labels from a view script.
     *
     * @todo Complete the documentation for this method.
     */
    public function setLabels($labels)
    {
        foreach ($labels as $elementName => $label) {
            if (is_string($label)) {
                $this->getElement($elementName)->setLabel($label);
                continue;
            }
            if (is_array($label)) {
                $element = $this->getElement($elementName);
                $element->setLabel(array_shift($label));
                $options = $element->getMultiOptions();
                foreach ($label as $multiKey => $multiLabel) {
                    if (array_key_exists($multiKey, $options)) {
                        $options[$multiKey] = $multiLabel;
                    } else {
                        trigger_error("'$multiKey' not a valid multiOption key");
                    }
                }
                $element->setMultiOptions($options);
                continue;
            }
            trigger_error("Value for $elementName must be a string or array");
        }
    }

}
