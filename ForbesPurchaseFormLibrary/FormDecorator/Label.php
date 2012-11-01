<?php
/**
 * This file defines the an improved form decorator for rendering labels.
 *
 * @author Benjamin Kalish <bkalish@forbeslibrary.org>
 * @package ForbesPurchaseForm
 * @subpackage library
 */

/**
 * An improved decorator for rendering labels.
 *
 * This decorator decides whether or not to prepend or append and
 * whether or not to insert new content by examining the class name of
 * the element being rendered. This makes it superior to the default
 * Zend decorators when you don't wish to manually configure the
 * decorators for each element.
 *
 * @author Benjamin Kalish <bkalish@forbeslibrary.org>
 * @package ForbesPurchaseForm
 * @subpackage library
 */
class ForbesPurchaseFormLibrary_FormDecorator_Label
    extends Zend_Form_Decorator_Abstract
{
    /**
     * An array of elements to which the label should be appended. (The
     * default is to prepend the label.
     *
     * @var array
     */
    protected $_appendElements = array('Zend_Form_Element_Checkbox');

    /**
     * An array of elements to which this decorator should not be
     * appended.
     *
     * @var array
     */
    protected $_skipElements = array('Zend_Form_Element_Submit');

    public function render($content)
    {
        $element = $this->getElement();
        $separator = $this->getSeparator();
        $elementClassName = get_class($element);
        $view = $element->getView();

        if (in_array($elementClassName, $this->_skipElements)) {
            return $content;
        }

        if (!method_exists($element, 'getLabel')) {
            return $content;
        }
        $label = $element->getLabel();

        if ($translator = $element->getTranslator()) {
            $label = $translator->translate($label);
        }
        
        if ($element->isRequired()) {
            $label = '* ' . $label;
        }
        
        $label = $view->formLabel(
            $element->getName(),
            $label,
            array('class' => 'element-label label-for-' . $elementClassName)
        );
        
        if (in_array($elementClassName, $this->_appendElements )) {
            return $content . $separator . $label;
        }
        return $label . $separator . $content;
    }
}
