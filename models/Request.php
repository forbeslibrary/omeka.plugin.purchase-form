<?php
/**
 * This file defines the Request model, ForbesPurchaseForm_Model_Request
 *
 * @author Benjamin Kalish <bkalish@forbeslibrary.org>
 * @package ForbesPurchaseForm
 * @subpackage models
 */

/**
 * ForbesPurchaseForm_Model_Request provides methods for interacting
 * with a request. To retrieve or save a request, you must use
 * ForbesPurchaseForm_Model_Mapper_RequestMapper.
 */
class ForbesPurchaseForm_Model_Request {
    /**
     * An array of item ids.
     *
     * We will use this as a set so we will use the item id as both the
     * key and the value for each entry.
     *
     * @var array
     */
    protected $_itemIds = array();

    /**
     * A unique id for this Request.
     *
     * The request object does nothing to guarentee the uniqueness of
     * the $id. It is the responsibility of the user to avoid id
     * conflicts.
     *
     * @var string
     */
    public $id;

    /**
     * The full name of the person submitting the request.
     *
     * @var string
     */
    public $name;

    /**
     * The email address of the person submitting the request.
     *
     * @var string
     */
    public $email;

    /**
     * The phone number of the person submitting the request.
     *
     * @var string
     */
    public $phone;

    /**
     * The address of the person submitting the request.
     *
     * @var ForbesPurchaseFormLibrary_MailingAddress
     */
    public $address;
    
    /**
     * The name of the organization which would like to use the
     * requested materials.
     *
     * @var string
     */
    public $organizationName;

    /**
     * Whether or not the organization which would like to use the
     * requested materials is a non-profit.
     *
     * @var bool
     */
    public $isOrgNonProfit;

    /**
     * Whether or not the organization which would like to use the
     * requested materials is a government agency.
     *
     * @var bool
     */
    public $isOrgGovernment;

    /**
     * Whether or not the organization which would like to use the
     * requested materials is a public access television station in
     * Massachusetts.
     *
     * @var bool
     */
    public $isOrgPublicAccessTV;

    /**
     * Whether of not the person placing this request would like to
     * receive downloadable files.
     *
     * @var bool
     */
    public $wantsDownloadableFiles;

    /**
     * Whether of not the person placing this request would like to
     * receive small prints.
     *
     * @var bool
     */
    public $wantsSmallPrints;

    /**
     * Whether of not the person placing this request would like to
     * receive large prints.
     *
     * @var bool
     */
    public $wantsLargePrints;

    /**
     * Whether of not the person placing this request would like to
     * receive a disc with the files.
     *
     * @var bool
     */
    public $wantsDiscWithFiles;

    /**
     * Any special instructions from the person placing this request.
     *
     * @var bool
     */
    public $specialInstructions;

    /**
     * Whether or not the requestor has indicated that they understand
     * the use policy.
     *
     * @var bool
     */
    public $checkedUnderstandPolicyConfirmation;

    /**
     * Whether or not the questor has indicated they will use these
     * materials for personal use.
     *
     * @var bool
     */
    public $wantsForPersonalUse;

    /**
     * Returns true if the contact information is valid.
     *
     * @return bool True if the contact information is valid, False
     * otherwise.
     *
     * @todo replace this method with a general isValid() method. We
     * have no occasion to call this (we will rely on form validation
     * between form pages) but we should check with the model to make
     * sure a request is valid before submitting it.
     */
    public function isContactInfoValid() {
        $valid = True;
        if (isStringWithContent($this->name)) {
            $valid = False;
        }
        if (filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $valid = False;
        }
    }

    /**
     * Returns all the Item ids in the selection.
     *
     * @return array An array of Item ids
     */
    public function getItemIds() {
        return $this->_itemIds;
    }

    /**
     * Gets all the Items in the selection
     *
     * @return array An array of Items
     */
    public function getItems() {
        return array_map('get_item_by_id', $this->_itemIds);
    }

    /**
     * Sets the Item ids for the request.
     *
     * @param array An array of item ids
     */
    public function setItemIds($itemIds) {
        $this->_itemIds = $itemIds;
    }
}
