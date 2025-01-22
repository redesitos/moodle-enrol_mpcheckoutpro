<?php

/**
 * This page handles responses from MercadoPago for failed payments.
 *
 * @package   enrol_mpcheckoutpro
 * @copyright 2020 Jonathan López <jonathan.lopez.garcia@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require("../../config.php");
require_once("lib.php");

global $CFG;

require_login();

$paymentid = optional_param('payment_id', 0, PARAM_INT);
$status = optional_param('status', 'failed', PARAM_TEXT);
$externalreference = optional_param('external_reference', 'none', PARAM_TEXT);
$merchantorderid = optional_param('merchant_order_id', 0, PARAM_INT);

$a = new stdClass();
if ($paymentid && $status && $externalreference && $merchantorderid) {
    $a->payment_status = "Payment ID: " . $paymentid . ", Status: " . $status .
        ", External Reference: " . $externalreference .
        ", Merchant Order ID: " . $merchantorderid . ", Message: pending confirmation";

} else {
    $a->payment_status = "MercadoPago callback received with missing parameters. Message: failed payment";
}
redirect($CFG->wwwroot . '/my', get_string('paymentreject', 'enrol_mpcheckoutpro', $a));
