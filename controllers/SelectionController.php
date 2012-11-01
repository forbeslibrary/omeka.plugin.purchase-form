<?php
/**
 * This file defines the Selection controller, ForbesPurchaseForm_SelectionController.
 *
 * @author Benjamin Kalish <bkalish@forbeslibrary.org>
 * @package ForbesPurchaseForm
 * @subpackage controllers
 */

/**
 * The controller for web requests related to Selections, i.e., shopping
 * carts.
 *
 * @see ForbesPurchaseForm_Model_Selection
 */
class ForbesPurchaseForm_SelectionController extends Omeka_Controller_Action {
    public function init() {
        $this->_redirector = $this->_helper->getHelper('Redirector');
        $this->_selectionMapper = new ForbesPurchaseForm_Model_Mapper_SelectionMapper();
        $this->_urlHelper = $this->_helper->getHelper('Url');
    }

    /**
     *  Adds the specified item to the selection.
     */
    public function addItemAction() {
        $itemId = $this->_getParam('item');

        $selection = $this->_selectionMapper->get();
        $selection->addItemById($itemId);
        $this->_selectionMapper->save($selection);

        $this->flashSuccess(__('The item has been added to your selection.'));

        $this->_redirector->gotoRoute(array(), 'forbes_purchase_form_show_selection');
    }

    /**
     * Clears the selection
     */
    public function emptyAction() {
        $selection = $this->_selectionMapper->get();
        $selection->removeAll();
        $this->_selectionMapper->save($selection);

        $this->_redirector->gotoRoute(array(), 'forbes_purchase_form_show_selection');
   }

    /**
     *  Displays selected items.
     */
    public function indexAction() {
        $selection = $this->_selectionMapper->get();
        $this->view->selectedItems = $selection->getItems();

        $form = new ForbesPurchaseForm_Form_SelectionForm($selection->getItemIds());
        $form->setAction($this->_urlHelper->url(array(), 'forbes_purchase_form_show_selection'));
        $this->view->form = $form;

        // Process Form submissions
        if (count($_POST) > 0) {
            if (!$form->isValid($_POST)) {
                // Failed validation; redisplay form
                $this->view->form = $form;
                return $this->render('index');
            }

            if (isset($_POST['purchase'])) {
                $this->_forward('show-form','request');
            }

            if (isset($_POST['empty'])) {
                $this->_forward('empty');
            }

            if (isset($_POST['removeselected'])) {
                $this->_forward('remove-items');
            }
        }
    }

    /**
     * Removes the item from the selection.
     */
    public function removeItemAction() {
        $itemId = $this->_getParam('item');

        $selection = $this->_selectionMapper->get();
        $selection->removeItemById($itemId);
        $this->_selectionMapper->save($selection);

        $this->flashSuccess(__('The item has been removed from your selection.'));

        $this->_redirector->gotoRoute(array(), 'forbes_purchase_form_show_selection');
    }

    /**
     * Removes multiple items from the selection.
     */
    public function removeItemsAction() {
        $itemIds = array_filter($_POST['items']);

        $selection = $this->_selectionMapper->get();
        $selection->removeItemsById($itemIds);
        $this->_selectionMapper->save($selection);

        if (count($itemIds)==1) {
            $this->flashSuccess(__('The selected item has been removed from your selection.'));
        } else {
            $this->flashSuccess(__('The selected items have been removed from your selection.'));
        }

        $this->_redirector->gotoRoute(array(), 'forbes_purchase_form_show_selection');
    }

}
