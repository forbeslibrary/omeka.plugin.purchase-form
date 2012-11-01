<?php
/**
 * This file defines a mapper for the Request model.
 *
 * @author Benjamin Kalish <bkalish@forbeslibrary.org>
 * @package ForbesPurchaseForm
 * @subpackage model-mappers
 */

/**
 * Provides methods to retrieve and save a request.
 */
class ForbesPurchaseForm_Model_Mapper_RequestMapper {

    protected static $_sessionNamespace;

    public function __construct() {
        if (!self::$_sessionNamespace) {
            self::$_sessionNamespace = new Zend_Session_Namespace('forbes_purchase_form_requests');
        }
        if (!self::$_sessionNamespace->requests) {
            self::$_sessionNamespace->requests = array();
        }
    }

    /**
     * Gets a request by id for the current user session.
     *
     * There is only ever one Selection to get, so this function does
     * not take any parameters.
     */
    public function get($id) {
        $requestData = self::$_sessionNamespace->requests[$id];
        if (is_null($requestData)) {
             throw new Exception('Could not find request with specified ID.');
        }
        $request = unserialize($requestData);
        if ($request===False) {
            throw new Exception('Could not unserialize request.');
        }
        return $request;
    }

    /**
     * Saves the request for the current user session.
     *
     * Note that saving is neccesary! Changes made to a request but
     * not saved may not be stick!
     */
    public function save($request) {
        // we fetch the array before modifying it to avoid a bug where modifying
        // an array inside a namespace may not work under PHP versions before 5.2.1
        $requests = self::$_sessionNamespace->requests;
        $requests[$request->id] = serialize($request);
        self::$_sessionNamespace->requests = $requests;
    }
}
