<?php
/**
 * This file defines the Request controller, ForbesPurchaseForm_RequestController.
 *
 * @author Benjamin Kalish <bkalish@forbeslibrary.org>
 * @package ForbesPurchaseForm
 * @subpackage controllers
 */

/**
 * The controller for web requests related to reproduction and image use
 * requests.
 *
 * @see ForbesPurchaseForm_Model_Request
 */
class ForbesPurchaseForm_RequestController extends Omeka_Controller_Action {

    /**
     * Prepares the controller for use.
     */
    public function init() {
        $this->_redirector = $this->_helper->getHelper('Redirector');
        $this->_selectionMapper = new ForbesPurchaseForm_Model_Mapper_SelectionMapper();
        $this->_requestMapper = new ForbesPurchaseForm_Model_Mapper_RequestMapper();
        $this->_urlHelper = $this->_helper->getHelper('Url');
    }

    /**
     * Displays and proccess forms for new requests.
     */
    public function showFormAction() {
        // Set the default view script for this action.
        // We will only end up using the default view script if
        // something goes wrong, so we set it to an error page.
        $this->_helper->viewRenderer->setRender('error');

        // The URL for submitting forms to this actions
        $this->showFormActionUrl = $this->_urlHelper->url(array(), 'forbes_purchase_form_request_form');

        // Once we have created a request, each form should pass its id back in
        // $_POST. If we can't find $_POST['requestId'] it must be a new request
        if (!isset($_POST['requestId'])) {
            $this->_startNewRequest();
            return;
        }

        // Fetch the saved request
        // TODO: handle failure due to session experation
        $request = $this->_requestMapper->get($_POST['requestId']);

        // Each form also sends back a form id so we which form to
        // validate and proccess. We dynamically call the approriate
        // form handler based upon the value in $_POST['formId']
        // Each form handler should render a view script, so we can
        // return after this call.
        if (isset($_POST['formId'])) {
            $methodName = '_handle'.$_POST['formId'].'Form';
            $this->$methodName($request);
            return;
        }

        // We should never get this far. If we have, it is an error.
        $this->flashError(__('There was an error processing your request.'));
    }

    //== Form Handlers ===============================================//
    // Each form handler must render a view script!

    protected function _handleContactInformationForm($request) {
        $form = new ForbesPurchaseForm_Form_ContactInformation($request);
        if (!$form->isValid($_POST)) {
            // Failed validation; redisplay form
            $this->view->form = $form;
            $this->render('show-contact-information-form');
            return;
        }
        // passed validation, set values
        $request->name = $_POST['name'];
        $request->email = $_POST['email'];
        $request->phone = $_POST['phone'];
        
        $address = new ForbesPurchaseFormLibrary_MailingAddress();
        $address->lineOne = $_POST['addressLineOne'];
        $address->lineTwo = $_POST['addressLineTwo'];
        $address->city = $_POST['city'];
        $address->stateOrRegion = $_POST['stateOrRegion'];
        $address->postalCode = $_POST['postalCode'];
        $address->country = $_POST['country'];
        $request->address = $address;

        $this->_requestMapper->save($request);

        // Create and render the ReproductionOptions form
        $form = new ForbesPurchaseForm_Form_ReproductionOptions($request);
        $form->setAction($this->showFormActionUrl);
        $this->view->form = $form;
        $this->render('show-reproduction-options-form');

    }

    protected function _handleReproductionOptionsForm($request) {
        $form = new ForbesPurchaseForm_Form_ReproductionOptions($request);
        if (!$form->isValid($_POST)) {
            // Failed validation; redisplay form
            $this->view->form = $form;
            $this->render('show-reproduction-options-form');
            return;
        }
        // passed validation, set values
        $deliverables = $_POST['deliverables'];
        $request->wantsDownloadableFiles = False;
        if (in_array('downloadableFiles', $deliverables)) {
            $request->wantsDownloadableFiles = True;
        }
        $request->wantsDiscWithFiles = False;
        if (in_array('discWithFiles', $deliverables)) {
            $request->wantsDiscWithFiles = True;
        }
        $request->wantsSmallPrints = False;
        if (in_array('smallPrints', $deliverables)) {
            $request->wantsSmallPrints = True;
        }
        $request->wantsLargePrints = False;
        if (in_array('largePrints', $deliverables)) {
            $request->wantsLargePrints = True;
        }
        $request->specialInstructions =
            $_POST['reproductionInstructions'];
        $request->checkedUnderstandPolicyConfirmation =
            $_POST['checkedUnderstandPolicyConfirmation'];
        $request->wantsForPersonalUse = False;
        if ($_POST['intendedUse'] == 'personalUse') {
            $request->wantsForPersonalUse = True;
        }
        $this->_requestMapper->save($request);

        // if personal use, submit request, otherwise display next form
        if ($request->wantsForPersonalUse) {
            $this->_submitRequest($request);
            return;
        }
        /*$form = new ForbesPurchaseForm_Form_OrganizationInformation($request); // TODO implement class
        $form->setAction($this->showFormActionUrl);
        $this->view->form = $form;
        $this->render('show-reproduction-options-form');*/
    }

    /**
     * Creates a new request for POSTed items and shows the contact information
     * form to initiate the request process.
     */
    protected function _startNewRequest() {
        // The item ids of the items to request should be found in $_POST
        // If no items were specified, send the user back to the selection form
        if (!is_array($_POST['items']) || count($_POST['items'])==0) {
            $this->flashError(__('Requests require at least one item.'));
            $this->_forward('index','selection');
            return;
        }

        // Create a new Request object and save it for later use
        $request = new ForbesPurchaseForm_Model_Request();
        $request->id = uniqid();
        $request->setItemIds(array_filter($_POST['items']));
        $this->_requestMapper->save($request);

        // Create and render the ContactInformation form
        $form = new ForbesPurchaseForm_Form_ContactInformation($request);
        $form->setAction($this->showFormActionUrl);
        $this->view->form = $form;
        $this->render('show-contact-information-form');
    }

    /**
     * Sends email notifications.
     */
    protected function _submitRequest($request) {
        $this->view->request = $request;
        $this->render('email-notification');
        
        /*
        //notify the admin
        //use the admin email specified in the plugin configuration.
        $forwardToEmail = get_option('forbes_purchase_form_forward_to_email');
        if (!empty($forwardToEmail)) {
            $mail = new Zend_Mail();
            $mail->setBodyHtml($this->view->render('request-form/email-notification.php'));
            $mail->setFrom($formEmail, $formName);
            $mail->addTo($forwardToEmail);
            $mail->setSubject(get_option('site_title') . ' - ' . 'test');
            $mail->send();
        }*/

        //notify the user who sent the message
        /*$replyToEmail = get_option('forbes_purchase_form_reply_from_email');
        if (!empty($replyToEmail)) {
            $mail = new Zend_Mail();
            $mail->setBodyText(get_option('forbes_purchase_form_user_notification_email_message_header') . "\n\n" . $formMessage);
            $mail->setFrom($replyToEmail);
            $mail->addTo($formEmail, $formName);
            $mail->setSubject(get_option('site_title') . ' - ' . get_option('forbes_purchase_form_user_notification_email_subject'));
            $mail->send();
        }*/
    }
}
