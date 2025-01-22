<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
// See the GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License along with Moodle.
// If not, see <http://www.gnu.org/licenses/>.

/**
 * Lang strings.
 *
 * This files lists lang strings related to enrol_mpcheckoutpro.
 *
 * @package enrol_mpcheckoutpro
 * @copyright 2020 Jonathan López <jonathan.lopez.garcia@gmail.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require("../../config.php");
require_once("lib.php");
global $CFG;
require_login();

$payment_id = optional_param('payment_id', 0, PARAM_INT);
$status = optional_param('status', 'failed', PARAM_TEXT);
$external_reference = optional_param('external_reference', 'none', PARAM_TEXT);
$merchant_order_id = optional_param('merchant_order_id', 0, PARAM_INT);

$a = new stdClass();
if ($payment_id && $status && $external_reference && $merchant_order_id) {
    $a->payment_status = "Payment ID: " . $payment_id . ", Status: " . $status .
        ", External Reference: " . $external_reference .
        ", Merchant Order ID: " . $merchant_order_id . ", Message: pending confirmation";

} else {
    $a->payment_status = "MercadoPago callback received with missing parameters. Message: failed payment";
}
redirect($CFG->wwwroot . '/my', get_string('paymentreject', 'enrol_mpcheckoutpro', $a));
?>