<?php

/**
 * This page handles responses from MercadoPago for failed payments.
 *
 * @package   enrol_mpcheckoutpro
 * @copyright 2020 Jonathan López <jonathan.lopez.garcia@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require "../../config.php";
require_once "lib.php";

global $CFG;

require_login();

$payment_id = optional_param('payment_id', 0, PARAM_INT);
$status = optional_param('status', 'failed', PARAM_TEXT);
$externalReference = optional_param('external_reference', 'none', PARAM_TEXT);
$merchantOrderId = optional_param('merchant_order_id', 0, PARAM_INT);

$a = new stdClass();
if ($payment_id && $status && $externalReference && $merchantOrderId) {
    $a->payment_status = "Payment ID: " . $payment_id . ", Status: " . $status .
        ", External Reference: " . $externalReference .
        ", Merchant Order ID: " . $merchantOrderId . ", Message: pending confirmation";

} else {
    $a->payment_status = "MercadoPago callback received with missing parameters. Message: failed payment";
}
redirect($CFG->wwwroot . '/my', get_string('paymentreject', 'enrol_mpcheckoutpro', $a));