<?php
/**
 * Start file for the ForbesPurchaseForm Omeka plugin
 *
 * The plugin.php file is included by Omeka and must add any plugin
 * hooks or filters which we want Omeka to know about.
 *
 * We also define a few contstants here, which will be useful in our
 * plugins and hooks.
 *
 * @author Benjamin Kalish <bkalish@forbeslibrary.org>
 * @package ForbesPurchaseForm
 * @see plugin_hooks.php
 * @see plugin_filters.php
 */

// == Define constants == //
/**
 * The base directory for this plugin.
 */
define('FORBES_PURCHASE_FORM_DIR', dirname(__FILE__).DIRECTORY_SEPARATOR);

/**
 * The view helpers directory for this plugin.
 *
 * forbes_purchase_form_initialize is probably the only function that
 * will need this, but we define it here for convenience.
 */
define('FORBES_PURCHASE_FORM_VIEW_HELPERS_DIR', FORBES_PURCHASE_FORM_DIR.'views/helpers');

// == Add plugin hooks === //
add_plugin_hook('install', 'forbes_purchase_form_install');
add_plugin_hook('initialize', 'forbes_purchase_form_initialize');
add_plugin_hook('uninstall', 'forbes_purchase_form_uninstall');
add_plugin_hook('define_routes', 'forbes_purchase_form_define_routes');
add_plugin_hook('config_form', 'forbes_purchase_form_config_form');
add_plugin_hook('config', 'forbes_purchase_form_config');
add_plugin_hook('public_append_to_items_show','forbes_purchase_form_public_append_to_items_show');

// == Add filters == //
add_filter('public_navigation_main', 'forbes_purchase_form_public_navigation_main');

// == Require plugin and filter hooks == //
require_once('plugin_hooks.php');
require_once('plugin_filters.php');
