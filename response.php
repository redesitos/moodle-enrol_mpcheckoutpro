<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * This page handles responses from MercadoPago for failed payments.
 *
 * @package   enrol_mpcheckoutpro
 * @copyright 2020 Jonathan López <jonathan.lopez.garcia@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require("../../config.php");
require_once("lib.php");
require_once($CFG->libdir . '/enrollib.php');
require_once($CFG->libdir . '/filelib.php');

global $DB, $CFG;

require_login();

$payid = optional_param('payment_id', 0, PARAM_INT);
$status = optional_param('status', 'failed', PARAM_TEXT);
$extref = optional_param('external_reference', 'none', PARAM_TEXT);
$prefid = optional_param('preference_id', 'none', PARAM_TEXT);
$mcorid = optional_param('merchant_order_id', 0, PARAM_INT);
$pysts = optional_param('collection_status', 'pending', PARAM_TEXT);

if (!empty($pysts)) {
    if ($pysts != "approved" || $status != "approved") {
        $a = new stdClass();
        $a->payment_status = $pysts;
        redirect($CFG->wwwroot . '/my', get_string('paymentsorry', 'enrol_mpcheckoutpro', $a));
    }
}

if ($status == "approved" && $pysts == "approved" && $extref != "none") {
    try {
        list($courseid, $userid, $instanceid, $contextid) = explode("-", $extref);

        if (!is_null($courseid) && !is_null($userid)) {

            if ($DB->record_exists(
                'user',
                array(
                    'id' => $userid,
                    'deleted' => 0
                )
            ) && $DB->record_exists(
                'course',
                array(
                    'id' => $courseid
                    )
            )
            ) {
                $context = context_course::instance($courseid, MUST_EXIST);

                $record = new stdClass();
                $record->preference_id = $prefid;
                $record->courseid = $courseid;
                $record->userid = $userid;
                $record->instanceid = $instanceid;
                $record->contextid = $contextid;
                $record->payment_id = $payid;
                $record->payment_status = $pysts;
                $record->external_reference = $extref;
                $record->timeupdated = time();

                if ($newid = $DB->insert_record('enrol_mpcheckoutpro', $record, true)) {
                    // Success! $newid now holds the ID of the inserted record.
                    redirect(new moodle_url('update.php', array(
                        'id' => $newid
                    )), get_string('paymentconfirm', 'enrol_mpcheckoutpro', $record), 10);

                } else {
                    throw new Exception('not insert record for enrol');
                    // Insertion failed. Handle the error.
                }
            }
        } else {
            $a = new stdClass();
            $a->payment_status = "MercadoPago callback received with missing parameters. Message: failed payment";
        }
    } catch (Exception $e) {
        throw new Exception($e);
    }
} else {
    $a = new stdClass();
    $a->payment_status = "Payment ID: " . $payid . ", Status: " . $status .
        ", External Reference: " . $extref .
        ", Merchant Order ID: " . $mcorid . ", Message: pending confirmation";
    redirect($CFG->wwwroot . '/my', get_string('paymentsorry', 'enrol_mpcheckoutpro', $a));
}
