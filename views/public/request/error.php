<?php
/**
 * A view script for showing an error.
 *
 * The controller rendering this script may optionally describe the
 * error using flashError(). This script must then display it with a
 * call to flash().
 *
 * @author Benjamin Kalish <bkalish@forbeslibrary.org>
 * @package ForbesPurchaseForm
 * @subpackage view-scripts
 * @see ForbesPurchaseForm_RequestController
 */
head(array('title'=>__('Error'), 'bodyid'=>'request-form', 'bodyclass'=>'error'));

?>
<h1>Oh no!</h1>
<p>We encountered an error! We're very sorry!</p>
<?php

echo flash();
foot();
