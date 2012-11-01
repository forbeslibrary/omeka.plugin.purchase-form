<?php
/**
 * This file defines the Index controller, ForbesPurchaseForm_IndexController.
 *
 * @author Benjamin Kalish <bkalish@forbeslibrary.org>
 * @package ForbesPurchaseForm
 * @subpackage controllers
 */

/**
 * The controller for miscellaneous requests, unrelated to any model.
 *
 * @todo This class needs to be revaluated and possibly eliminated.
 * It is not currently used in any meaningful way.
 */
 class ForbesPurchaseForm_IndexController extends Omeka_Controller_Action {

    /**
     * Prepares the controller for use.
     */
    public function init() {
        $this->_redirector = $this->_helper->getHelper('Redirector');
        $this->_selectionMapper = new ForbesPurchaseForm_Model_Mapper_SelectionMapper();
   }

    /* Displays current selection.
     */
    public function infoAction() {
		$selection = $this->_selectionMapper->get();
        $this->view->selectedItems = $selection->getItems();
    }

    /* Displays reproduction fee information
     *
     * This simply renders the reproduction-fees view. None of the data
     * is stored programmatically.
     */
    public function reproductionFeesAction() {
    }

    public function termsAction() {
        //return $this->render('terms');
    }

    public function thankYouAction() {

    }

    public function useFeesAction() {
    }


}
