<?php
/**
 * A view script for showing the selection, i.e. the shopping cart.
 *
 * Note that this script does not create the form (it is available as
 * the variable {@var $form}, but it is responsible for setting the
 * forms labels, descriptions, and custom decorators, as well as all
 * other content which should appear on the page.
 *
 * @author Benjamin Kalish <bkalish@forbeslibrary.org>
 * @package ForbesPurchaseForm
 * @subpackage view-scripts
 * @see ForbesPurchaseForm_Form_SelectionForm
 * @see ForbesPurchaseForm_SelectionController
 */
$view = __v();

// Style form
$form->getElement('empty')->setLabel(__('Remove All'));
$form->getElement('removeselected')->setLabel(__('Remove Selected'));
$form->getElement('purchase')->setLabel(__('Purchase Selected'));

// html head tag
head(array('title' => __('Cart'), 'bodyid'=>'cart','bodyclass' => 'index'));

// flash messages from controller
echo flash();

$n = count($this->selectedItems);
?>
<h1>Selected Items</h1>
<div>
    <p><?php echo __('%1$s %2$s in cart', $n, $n==1 ? __('item') : __('items'));?></p>
    <?php if ($n>0) { echo $form; }?>
</div>
<?php foot(); ?>
