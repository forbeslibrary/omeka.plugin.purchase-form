<?php
/**
 * A view script for showing the contact information form.
 *
 * Note that this script does not create the form (it is available as
 * the variable {@var $form}, but it is responsible for setting the
 * forms labels, descriptions, and custom decorators, as well as all
 * other content which should appear on the page.
 *
 * @author Benjamin Kalish <bkalish@forbeslibrary.org>
 * @package ForbesPurchaseForm
 * @subpackage view-scripts
 * @see ForbesPurchaseForm_Form_ContactInformation
 * @see ForbesPurchaseForm_RequestController
 * @todo add suitable decorators. This form is currently unreadable!
 */
queue_css('common');

head(array(
    'title'=>__('Contact Information'),
    'bodyid'=>'request-form',
    'bodyclass'=>'contact-information-form'
));
?>
<h1>Request For Reproductions</h1>
<p>Forbes Library is pleased to offer high quality reproductions of materials in
its archives. Reproductions are offered according to our <?php
echo $this->link($this->url(array(), 'forbes_purchase_form_terms'), 'Terms and Conditions')
?></p>

<p>Please note that Forbes Library does not hold copyright over many of the
images and illustrations in its collections. Reproduction and Use Fees are
charged for the images, based on Forbes Library's physical ownership of the
images, and not on copyright. <b>Responsibility for identifying and satisfying
any claimants of copyright must be assumed by those wishing to use the images.
</b></p>

<h2>Please provide your contact information</h1>
<p>Required fields are marked with an asterisk (*).</p>
<?php
echo flash();
$form->setLabels(array(
    'name' => __('Full name')
,   'addressLineOne' => __('Address line one')
,   'addressLineTwo' => __('Address line two')
,   'city' => __('City')
,   'stateOrRegion' => __('State/Province/Region')
,   'postalCode' => __('Postal code')
,   'country' => __('Country')
,   'email' => __('Email')
,   'phone' => __('Phone')
,   'organizationName' => __('Organization Name')
,   'isOrgNonProfit' => __('This organization is a 501(c)(3) non-profit')
,   'isOrgGovernment' => __('This organization is a Federal, State, or City Government agency')
,   'isOrgPublicAccessTV' => __('This organization is a public-access television station in Massachusetts')
,   'submit' => __('Continue')
    ));

$form->getElement('addressLineOne')->setDescription(__('Street address, P.O. box, company name, etc.'));
$form->getElement('addressLineTwo')->setDescription(__('Apartment, building, unit, etc.'));

$form->getDisplayGroup('organization-group')->setLegend(__('Organization Affiliation (if applicable)'));

echo $form;
foot();