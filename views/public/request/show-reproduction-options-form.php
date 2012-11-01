<?php
/**
 * A view script for showing the reproduction options form.
 *
 * Note that this script does not create the form (it is available as
 * the variable {@var $form}, but it is responsible for setting the
 * forms labels, descriptions, and custom decorators, as well as all
 * other content which should appear on the page.
 *
 * @author Benjamin Kalish <bkalish@forbeslibrary.org>
 * @package ForbesPurchaseForm
 * @subpackage view-scripts
 * @see ForbesPurchaseForm_RequestController
 * @see ForbesPurchaseForm_Form_ReproductionOptions
 * @todo add suitable decorators. This form is currently unreadable!
 */
queue_css('common');

head(array(
    'title'=>__('Reproduction Options'),
    'bodyid'=>'request-form',
    'bodyclass'=>'reproduction-options-form'
));
?>
<h1>Reproduction Options</h1>
<?php echo flash();
$form->setLabels(array(
    'deliverables' => array(
        __('Formats'),
            'downloadableFiles' => __('Downloadable image files'),
            'discWithFiles' => __('Disc with image files'),
            'smallPrints' => __('Small print (up to 8.5" x 11")'),
            'largePrints' => __('Large print (up to 13" x 13")'),
            'noReproductions' => __('I already have all the reproductions'
                . ' I need, but am requesting permission for use.'),
        ),
    'reproductionInstructions' => __('Special instructions'),
    'intendedUse' => array(
        __('Intended use'),
            'personalUse' => __('Personal Research (materials will not be copied, reproduced, or publicly displayed)'),
            'otherUse' => __('Other use'),
        ),
    'checkedUnderstandPolicyConfirmation' => __('I have read terms of service.... blah blah'),
    'submit' => __('Continue'),
    ));

$form->getElement('deliverables')->setDescription(
    'Please mark the formats you would like to receive for these images.');

echo $form;
foot();
