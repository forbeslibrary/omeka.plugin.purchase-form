<?php
/**
 * Plugin hooks for ForbesPurchaseForm
 *
 * This file is required by plugin.php and defines the plugin hooks
 * which are added to Omeka in that file.
 *
 * @author Benjamin Kalish <bkalish@forbeslibrary.org>
 * @package ForbesPurchaseForm
 * @see plugin.php
 * @see plugin_filters.php
 */

/**
 * Initializes the ForbesPurchaseForm plugin.
 *
 * In particular, we configure the autoloader, require frequently used
 * library files, and perform any other tweaking that must be performed
 * before the plugin can be used.
 */
function forbes_purchase_form_initialize() {
    // set error reporting level
    error_reporting(E_ALL);

    // Require libraries
    require_once(HELPER_DIR.DIRECTORY_SEPARATOR.'ItemFunctions.php');
    require_once(FORBES_PURCHASE_FORM_DIR . DIRECTORY_SEPARATOR . 'convenience_functions.php');

    // Use a Application Module Autoloader for resources (models,
    // controllers, etc.)
    $loader = new Zend_Application_Module_Autoloader(array(
        'namespace'=>'ForbesPurchaseForm',
        'basePath'=>FORBES_PURCHASE_FORM_DIR
    ));
    $loader->addResourceType('element', 'forms/elements', 'Form_Element');

    // Use the standard Zend_Loader_Autoloader for the library
    set_include_path(get_include_path() . PATH_SEPARATOR . FORBES_PURCHASE_FORM_DIR);
    $autoloader = Zend_Loader_Autoloader::getInstance();
    $autoloader->registerNamespace('ForbesPurchaseFormLibrary_');

    // Use view helpers defined in this plugin
    $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
    $viewRenderer->view->addHelperPath(
        FORBES_PURCHASE_FORM_VIEW_HELPERS_DIR,
        'ForbesPurchaseForm_Views_Helpers'
    );
}

/**
 * Installs the plugin by making any neccesarry changes to the base
 * Omeka installation.
 *
 * Called by Omeka when installing the plugin.
 *
 * Currently the only thing we must do here is set some plugin options.
 *
 * @see forbes_purchase_form_uninstall()
 */
function forbes_purchase_form_install() {
    set_option('forbes_purchase_form_reply_from_email', get_option('administrator_email'));
    set_option('forbes_purchase_form_forward_to_email', get_option('administrator_email'));

}

/**
 * Uninstalls the plugin by removing any changes it has made to the base
 * Omeka installation.
 *
 * Called by Omeka when uninstalling the plugin.
 *
 * This should reverse the effects of forbes_purchase_form_install()
 *
 * @see forbes_purchase_form_install()
 */
function forbes_purchase_form_uninstall() {
    delete_option('forbes_purchase_form_reply_from_email');
    delete_option('forbes_purchase_form_forward_to_email');
}

/**
 * Adds the routes for this plugin to the router.
 *
 * Called by Omeka when it is ready to define the routes used by this
 * plugin.
 *
 * This function reads the route definitions from the routes.ini file in
 * the same directory.
 *
 * @param Zend_Controller_Router_Rewrite $router The router to which
 * we may add our new routes
 */
function forbes_purchase_form_define_routes($router){
    $config = new Zend_Config_Ini(FORBES_PURCHASE_FORM_DIR . 'routes.ini', 'routes');
    $router->addConfig($config, 'routes');
}

/**
 * Creates the configuration form for this plugin.
 *
 * Called by Omeka to create the configuration form in plugin settings.
 */
function forbes_purchase_form_config_form() {
    include 'config_form.php';
}

/**
 * Called by Omeka on the items/show page, this function shows a 'add to
 * cart' or 'item is in cart' link.
 */
function forbes_purchase_form_public_append_to_items_show() {
    $selectionMapper = new ForbesPurchaseForm_Model_Mapper_SelectionMapper();
    $selection = $selectionMapper->get();
    $item = get_current_item();
    if ($selection->containsItem($item)) {
        $url = uri(array(), 'forbes_purchase_form_show_selection');
        $text = __('Item is in cart - view');
        echo "<a href=\"$url\">$text</a>";
    } else {
        $url = uri(array('item'=>$item->id),'forbes_purchase_form_select_item');
        echo "<a href=\"$url\">add to cart</a>";
    }
}

/**
 * Proccesses the response to the config form.
 *
 * @see forbes_purchase_form_config_form
 */
function forbes_purchase_form_config() {
    set_option('forbes_purchase_form_reply_from_email', $_POST['reply_from_email']);
    set_option('forbes_purchase_form_forward_to_email', $_POST['forward_to_email']);
}
