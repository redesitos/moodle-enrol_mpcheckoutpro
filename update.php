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
require_once($CFG->libdir . '/enrollib.php');
require_once($CFG->libdir . '/filelib.php');

global $DB, $CFG;

require_login();

$id = required_param('id', PARAM_INT);

$enrol_mpcheckoutpro = $DB->get_record("enrol_mpcheckoutpro", array(
    "id" => $id
));

$data = new StdClass();
$data->userid = $enrol_mpcheckoutpro->userid;
$data->courseid = $enrol_mpcheckoutpro->courseid;
$data->instanceid = $enrol_mpcheckoutpro->instanceid;
$data->payment_gross = $enrol_mpcheckoutpro->payment_status;

$user = $DB->get_record("user", array(
    "id" => $data->userid
), "*", MUST_EXIST);

$course = $DB->get_record("course", array(
    "id" => $data->courseid
), "*", MUST_EXIST);

$context = context_course::instance($course->id, MUST_EXIST);

$PAGE->set_context($context);

$plugin_instance = $DB->get_record("enrol", array(
    "id" => $data->instanceid,
    "enrol" => "mpcheckoutpro",
    "status" => 0
), "*", MUST_EXIST);

$plugin = enrol_get_plugin('mpcheckoutpro');

if ($plugin_instance->enrolperiod) {
    $timestart = time();
    $timeend = $timestart + $plugin_instance->enrolperiod;
} else {
    $timestart = 0;
    $timeend = 0;
}

// Enrol user
$plugin->enrol_user($plugin_instance, $user->id, $plugin_instance->roleid, $timestart, $timeend);

// Pass $view=true to filter hidden caps if the user cannot see them
if ($users = get_users_by_capability($context, 'moodle/course:update', 'u.*', 'u.id ASC', '', '', '', '', false, true)) {
    $users = sort_by_roleassignment_authority($users, $context);
    $teacher = array_shift($users);
} else {
    $teacher = false;
}

if (
    !$course = $DB->get_record("course", array(
        "id" => $data->courseid
    ))
) {
    redirect($CFG->wwwroot);
}
if (
    !$user = $DB->get_record("user", array(
        "id" => $data->userid
    ))
) {
    redirect($CFG->wwwroot);
}

if (!empty($SESSION->wantsurl)) {
    $destination = $SESSION->wantsurl;
    unset($SESSION->wantsurl);
} else {
    $destination = "$CFG->wwwroot/course/view.php?id=$course->id";
}

$fullname = format_string($course->fullname, true, array(
    'context' => $context
));

if (is_enrolled($context, $user, '', true)) { // TODO: use real pay check
    redirect(new moodle_url('/course/view.php', array(
        'id' => $course->id
    )), get_string('paymentthanks', '', $fullname));
} else { // / Somehow they aren't enrolled yet! :-(
    $PAGE->set_url($destination);
    echo $OUTPUT->header();
    $a = new stdClass();
    $a->teacher = get_string('defaultcourseteacher');
    $a->fullname = $fullname;
    notice(get_string('paymentsorry', '', $a), $destination);
}

?>