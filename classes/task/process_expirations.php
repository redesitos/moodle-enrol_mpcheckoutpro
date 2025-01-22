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
 * @package   enrol_mpcheckoutpro
 * @copyright 2019 Jonathan López <jonathan.lopez.garcia@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace enrol_mpcheckoutpro\task;

defined('MOODLE_INTERNAL') || die();

class process_expirations extends \core\task\scheduled_task
{

    /**
     * Name for this task.
     *
     * @return string
     */
    public function get_name()
    {
        return get_string('processexpirationstask', 'enrol_mpcheckoutpro');
    }

    /**
     * Run task for processing expirations.
     */
    public function execute()
    {
        global $DB, $CFG;
        $enrol = enrol_get_plugin('mpcheckoutpro');
        $trace = new \text_progress_trace();
        $enrol->process_expirations($trace);
    }
}