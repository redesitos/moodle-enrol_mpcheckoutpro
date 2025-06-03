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

$string['pluginname'] = 'mpcheckoutpro';
$string['pluginname_desc'] = 'The Mercadopago module allows you to set up paid courses.  If the cost for any course is zero, then students are not asked to pay for entry.  There is a site-wide cost that you set here as a default for the whole site and then a course setting that you can set for each course individually. The course cost overrides the site cost.';
$string['owner'] = 'innovandoweb';
$string['descriptionower'] = 'Mercadopago developed and maintained by jonathan.lopez.garcia@gmail.com';
$string['nocost'] = 'Not value defined, please update the value or change enrol method';
$string['pkey'] = 'Account pkey merchant.';
$string['publickey'] = 'Public key merchant.';
$string['accesstoken'] = 'Account token merchant.';
$string['deskaccesstoken'] = 'Access token from api prod & paste here';
$string['deskpublickey'] = 'Public key from api prod & paste here';
$string['merchantid'] = 'merchant id';
$string['accountid'] = 'account id';
$string['tax'] = 'tax $';
$string['taxerror'] = 'Error in tax definition';
$string['paycourse'] = 'This course requires a payment for entry.';
$string['merchantapi'] = 'merchant api';
$string['merchantkey'] = 'merchant key';
$string['merchantsalt'] = 'transaction salt';
$string['urlprod'] = 'url mercadopago webcheckout';
$string['mailadmins'] = 'Notify admin';
$string['mailstudents'] = 'Notify students';
$string['mailteachers'] = 'Notify teachers';
$string['expiredaction'] = 'Enrolment expiration action';
$string['expiredaction_help'] = 'Select action to carry out when user enrolment expires. Please note that some user data and settings are purged from course during course unenrolment.';
$string['cost'] = 'Enrol cost';
$string['costerror'] = 'The enrolment cost is not numeric';
$string['costorkey'] = 'Please choose one of the following methods of enrolment.';
$string['currency'] = 'Currency';
$string['assignrole'] = 'Assign role';
$string['defaultrole'] = 'Default role assignment';
$string['defaultrole_desc'] = 'Select role which should be assigned to users during mercadopago enrolments';
$string['enrolenddate'] = 'End date';
$string['enrolenddate_help'] = 'If enabled, users can be enrolled until this date only.';
$string['enrolenddaterror'] = 'Enrolment end date cannot be earlier than start date';
$string['enrolperiod'] = 'Enrolment duration';
$string['enrolperiod_desc'] = 'Default length of time that the enrolment is valid. If set to zero, the enrolment duration will be unlimited by default.';
$string['enrolperiod_help'] = 'Length of time that the enrolment is valid, starting with the moment the user is enrolled. If disabled, the enrolment duration will be unlimited.';
$string['enrolstartdate'] = 'Start date';
$string['enrolstartdate_help'] = 'If enabled, users can be enrolled from this date onward only.';
$string['mpcheckoutpro:config'] = 'Configure Mercadopago enrol instances';
$string['mpcheckoutpro:manage'] = 'Manage enrolled users';
$string['mpcheckoutpro:unenrol'] = 'Unenrol users from course';
$string['mpcheckoutpro:unenrolself'] = 'Unenrol self from the course (student)';
$string['mpcheckoutpro:receivemessages'] = 'Receive MercadoPago messages';
$string['status'] = 'Allow mercadopago enrolments';
$string['status_desc'] = 'Allow users to use mercadopago to enrol into a course by default.';
$string['unenrolselfconfirm'] = 'Do you really want to unenrol yourself from course "{$a}"?';
$string['errorinsert'] = 'Unable to insert record to pay, <br>reason: information not found, pleas contact site admin to validate pay and enrol course';
$string['privacy:metadata:enrol_mpcheckoutpro:enrol_mpcheckoutpro'] = 'Information mercadopago';
$string['privacy:metadata:enrol_mpcheckoutpro:mercadopago:preference_id'] = 'Description.';
$string['privacy:metadata:enrol_mpcheckoutpro:mercadopago:courseid'] = 'Course id.';
$string['privacy:metadata:enrol_mpcheckoutpro:mercadopago:userid'] = 'User id.';
$string['privacy:metadata:enrol_mpcheckoutpro:mercadopago:instanceid'] = 'Instance id.';
$string['privacy:metadata:enrol_mpcheckoutpro:mercadopago:amount'] = 'Amount.';
$string['privacy:metadata:enrol_mpcheckoutpro:mercadopago:contextid'] = 'Contextid.';
$string['privacy:metadata:enrol_mpcheckoutpro:mercadopago:external_reference'] = 'External reference.';
$string['privacy:metadata:enrol_mpcheckoutpro:mercadopago:paymen_status'] = 'Payment status.';
$string['privacy:metadata:enrol_mpcheckoutpro:mercadopago:payment_status_detail'] = 'Payment status detail.';
$string['privacy:metadata:enrol_mpcheckoutpro:mercadopago:payment_id'] = 'Payment id.';
$string['privacy:metadata:enrol_mpcheckoutpro:mercadopago:auth_json'] = 'Json payment.';
$string['privacy:metadata:enrol_mpcheckoutpro:mercadopago:timeupdated'] = 'Time update.';
$string['privacy:metadata:enrol_mpcheckoutpro:enrol_mpcheckoutpro:preference_id'] = 'Item date.';
$string['privacy:metadata:enrol_mpcheckoutpro:enrol_mpcheckoutpro:courseid'] = 'Course id.';
$string['privacy:metadata:enrol_mpcheckoutpro:enrol_mpcheckoutpro:userid'] = 'User id.';
$string['privacy:metadata:enrol_mpcheckoutpro:enrol_mpcheckoutpro:instanceid'] = 'Instance id.';
$string['privacy:metadata:enrol_mpcheckoutpro:enrol_mpcheckoutpro:amount'] = 'Amount.';
$string['privacy:metadata:enrol_mpcheckoutpro:enrol_mpcheckoutpro:contextid'] = 'Contextid.';
$string['privacy:metadata:enrol_mpcheckoutpro:enrol_mpcheckoutpro:external_reference'] = 'External reference.';
$string['privacy:metadata:enrol_mpcheckoutpro:enrol_mpcheckoutpro:payment_status'] = 'Payment status.';
$string['privacy:metadata:enrol_mpcheckoutpro:enrol_mpcheckoutpro:payment_status_detail'] = 'Payment status detail.';
$string['privacy:metadata:enrol_mpcheckoutpro:enrol_mpcheckoutpro:payment_id'] = 'Payment id.';
$string['privacy:metadata:enrol_mpcheckoutpro:enrol_mpcheckoutpro:auth_json'] = 'Json auth.';
$string['privacy:metadata:enrol_mpcheckoutpro:enrol_mpcheckoutpro:timeupdated'] = 'Time update.';
$string['privacy:metadata:enrol_mpcheckoutpro:mercadopago'] = 'The extensión mercadopag, send informationtoweb mercadopago.';
$string['verifypayment'] = '<div id="idpagomercadopago"><br>transaction has been received. We are in the process of verification, try course access in 45 minutes verify the income, otherwise contact the administrator.</div>';
$string['paymentconfirm'] = 'Course paid, resume: <div id="resume"><br>payment id: "{$a->payment_id}"<br>paymen status: "{$a->payment_status}"<br>Userid: "{$a->userid}"<br></div>';
$string['paymentreject'] = 'Thanks for your interest! Unfortunately, your payment has not been received.<br><br> reason: "{$a->payment_status}"<br>';
$string['paymentsorry'] = 'Thanks for your interest! Unfortunately, your payment has not been confirmed at this time, once you make the payment, try to enter the course in 45 minutes, if you continue to have problems, please contact the site administrator attaching the payment receipt in your application and username moodle to review transaction <br> Payment status: "{$a->payment_status}"<br>';
$string['messageprovider:mercadopago_enrolment'] = 'User enrol';
$string['syncenrolmentstask'] = 'Synchronise mercadopago enrolments task';
$string['processexpirationstask'] = 'Work expiration process for Mercado Pago';
$string['sdkerr'] = 'The path of the paid market sdk cannot be found, you must install the sdk following the instructions below: https://www.mercadopago.com.co/developers/en/docs/checkout-pro/integrate-preferences and https://getcomposer.org/download/ <br><br> Valid paths are: /var/www/ C:/xampp/ C:/wampp/  Inside must be the vendor directory of the sdk and autoload.php file';
$string['sdkdescription'] = 'Automatic enrollment, install the Mercadopago sdk in a directory that is not accessible from the web and indicate the full path of the sdk, some valid paths are: /var/www/vendor/autoload.php C:/xampp/vendor/autoload.php C:/wampp/vendor/autoload.php etc';
$string['sdk'] = 'Automatic enrollment';
$string['paymentthanks'] = '<div id="idpagomercadopago"><br>We are in the process of verification, try course access in 45 minutes verify the income, otherwise contact the administrator.<br><br>"{$a->payment_status}"<br></div>';
$string['ipn'] = 'Enter your url for call in new pay events (webhoot)';
$string['mplangerr'] = 'An additional coin has been added but there is no code to reference, a rewrite is necessary';
$string['messageprovider:mpcheckoutpro_enrolment'] = 'Notifications related with mercado pago inscriptions';
$string['notiferr'] = 'Payment failed on MercadoPago';
$string['notifdetailerror'] = 'There was a problem with your MercadoPago payment. Please review the details.';
$string['transactions'] = 'Transactions';
$string['errnoparameters'] = 'MercadoPago callback received with missing parameters. Message: failed payment';
$string['msgpending'] = 'Message: pending confirmation';