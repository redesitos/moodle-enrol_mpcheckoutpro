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

defined('MOODLE_INTERNAL') || die();
require_login();

if ($ADMIN->fulltree) {

    // Settings.
    $settings->add(
        new admin_setting_heading(
            'enrol_mpcheckoutpro_settings',
            '',
            get_string('pluginname_desc', 'enrol_mpcheckoutpro')
        )
    );

    $settings->add(
        new admin_setting_configtext(
            'enrol_mpcheckoutpro/accesstoken',
            get_string('accesstoken', 'enrol_mpcheckoutpro'),
            get_string('deskaccesstoken', 'enrol_mpcheckoutpro'),
            '',
            PARAM_RAW
        )
    );

    $settings->add(
        new admin_setting_configtext(
            'enrol_mpcheckoutpro/publickey',
            get_string('publickey', 'enrol_mpcheckoutpro'),
            get_string('deskpublickey', 'enrol_mpcheckoutpro'),
            '',
            PARAM_RAW
        )
    );

    $settings->add(
        new admin_setting_configtext(
            'enrol_mpcheckoutpro/sdk',
            get_string('sdk', 'enrol_mpcheckoutpro'),
            get_string('sdkdescription', 'enrol_mpcheckoutpro'),
            '/var/www/vendor/autoload.php',
            PARAM_RAW
        )
    );

    $settings->add(
        new admin_setting_configtext(
            'enrol_mpcheckoutpro/ipn',
            get_string('ipn', 'enrol_mpcheckoutpro'),
            get_string('ipn', 'enrol_mpcheckoutpro'),
            '',
            PARAM_RAW
        )
    );

    $options = array(
        ENROL_EXT_REMOVED_KEEP => get_string('extremovedkeep', 'enrol'),
        ENROL_EXT_REMOVED_SUSPENDNOROLES => get_string(
            'extremovedsuspendnoroles', 
            'enrol'
        ),
        ENROL_EXT_REMOVED_UNENROL => get_string('extremovedunenrol', 'enrol')
    );

    $settings->add(
        new admin_setting_configselect(
            'enrol_mpcheckoutpro/expiredaction',
            get_string('expiredaction', 'enrol_mpcheckoutpro'),
            get_string('expiredaction_help', 'enrol_mpcheckoutpro'),
            ENROL_EXT_REMOVED_SUSPENDNOROLES,
            $options
        )
    );

    $settings->add(
        new admin_setting_heading(
            'enrol_mpcheckoutpro_defaults',
            get_string('enrolinstancedefaults', 'admin'),
            get_string('enrolinstancedefaults_desc', 'admin')
        )
    );

    $enableoptions = array(
        ENROL_INSTANCE_ENABLED => get_string('yes'),
        ENROL_INSTANCE_DISABLED => get_string('no')
    );

    $settings->add(
        new admin_setting_configselect(
            'enrol_mpcheckoutpro/status',
            get_string('status', 'enrol_mpcheckoutpro'),
            get_string('status_desc', 'enrol_mpcheckoutpro'),
            ENROL_INSTANCE_DISABLED,
            $enableoptions,
        )
    );

    $settings->add(
        new admin_setting_configtext(
            'enrol_mpcheckoutpro/cost',
            get_string('cost', 'enrol_mpcheckoutpro'),
            '',
            0,
            PARAM_FLOAT,
            4,
        )
    );

    $settings->add(
        new admin_setting_configtext(
            'enrol_mpcheckoutpro/tax',
            get_string('tax', 'enrol_mpcheckoutpro'),
            '',
            0,
            PARAM_FLOAT,
            4,
        )
    );

    $currencies = enrol_get_plugin('mpcheckoutpro')->get_currencies();
    $settings->add(
        new admin_setting_configselect(
            'enrol_mpcheckoutpro/currency',
            get_string('currency', 'enrol_mpcheckoutpro'),
            '',
            'COP',
            $currencies
        )
    );
    if (!during_initial_install()) {
        $defoptions = get_default_enrol_roles(context_system::instance());
        $student = get_archetype_roles('student');
        $student = reset($student);
        $settings->add(
            new admin_setting_configselect(
                'enrol_mpcheckoutpro/roleid',
                get_string('defaultrole', 'enrol_mpcheckoutpro'),
                get_string('defaultrole_desc', 'enrol_mpcheckoutpro'),
                $student->id,
                $defoptions,
            )
        );
    }

    $settings->add(
        new admin_setting_configduration(
            'enrol_mpcheckoutpro/enrolperiod',
            get_string('enrolperiod', 'enrol_mpcheckoutpro'),
            get_string('enrolperiod_desc', 'enrol_mpcheckoutpro'),
            0
        )
    );
}
