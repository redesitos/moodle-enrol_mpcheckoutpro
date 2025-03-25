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

if (!isset($_SESSION['mpcheckoutpro_token'])) {
    $_SESSION['mpcheckoutpro_token'] = bin2hex(random_bytes(32));
}

global $DB, $USER, $CFG;

$accesstoken = $this->get_config('accesstoken');
$publickey = $this->get_config('publickey');
$sdk = $this->get_config('sdk');
$ipn = $this->get_config('ipn');

$productinfo = $coursefullname;
$referencecode = $instance->courseid . $USER->id . rand();
$locale;
$_SESSION['timestamp'] = $timestamp = time();
$extra1 = $instance->courseid . '-' . $USER->id . '-' . $instance->id . '-' . $context->id;

if (!class_exists('MercadoPago\SDK')) {
    if (file_exists('/var/www/vendor/autoload.php')) {
        include_once('/var/www/vendor/autoload.php');
    }
    if (!class_exists('MercadoPago\SDK') && !empty($sdk) && file_exists($sdk)) {
        include_once($sdk); // Fallback on custom sdk path
    }
    if (!class_exists('MercadoPago\SDK')) {
        throw new Exception(get_string('sdkerr', 'enrol_mpcheckoutpro'));
    }
}

MercadoPago\SDK::setAccessToken($accesstoken);

$payer = new MercadoPago\Payer();
$payer->name = $USER->firstname;
$payer->surname = $USER->lastname;
$payer->email = $USER->email;
$payer->date_created = date("Y-m-d H:i:s");

$item = new MercadoPago\Item();
$item->id = random_int(1000, 9999);
$item->title = $referencecode;
$item->description = $productinfo;
$item->quantity = 1;
$item->unit_price = (int) $instance->cost;
$item->currency_id = $instance->currency;

$preference = new MercadoPago\Preference();

if ($item->currency_id == 'COP') {
    $payer->phone = array(
        "area_code" => "1",
        "number" => "2926419",
    );

    $payer->address = array(
        "street_name" => "zona rosa",
        "street_number" => 68,
        "zip_code" => "110111",
    );
    $locale = "es-CO";
} else {
    throw new Exception(get_string('mplangerr', 'enrol_mpcheckoutpro'));
}

$preference->external_reference = $extra1;
$preference->notification_url = $ipn;

$token = $_SESSION['mpcheckoutpro_token'];
$preference->back_urls = array(
    "success" => $CFG->wwwroot . '/enrol/mpcheckoutpro/response.php?token=' . $token,
    "failure" => $CFG->wwwroot . '/enrol/mpcheckoutpro/failure.php?token=' . $token,
    "pending" => $CFG->wwwroot . '/enrol/mpcheckoutpro/pending.php?token=' . $token,
);

$preference->auto_return = "approved";
$preference->items = array($item);
$preference->payer = $payer;

$preference->payment_methods = array(
   "excluded_payment_methods" => array(
        array("id" => "master")
    ),
    "excluded_payment_types" => array(
        array("id" => "credit_card"),
        array("id" => "debit_card"),
    ),
    "installments" => 1
);

$preference->expires = true;
$preference->expiration_date_from = date('Y-m-d H:i:s.vP');
$preference->expiration_date_to = date('Y-m-d H:i:s.vP', strtotime('+3 days'));

$preference->save();
?>

<div align="center">
    <p><?php echo get_string('paycourse', 'enrol_mpcheckoutpro'); ?></p>
    <p><b><?php echo $instancename; ?></b></p>
    <p><b><?php echo get_string("cost") . ": {$instance->currency} {$localisedcost}"; ?></b></p>
    <p><img alt="mercadopago"
            src="<?php echo $CFG->wwwroot; ?>/enrol/mpcheckoutpro/pix/pagos_procesados_por_mercadopago.gif"
            style="width:30%" /></p>
    <p>&nbsp;</p>
    <script src="https://www.mercadopago.com/v2/security.js" view="home"></script>
    <script src="https://sdk.mercadopago.com/js/v2"></script>
    <container class="cho-container" />
</div>

<script>
    const mp = new MercadoPago('<?php echo $publickey; ?>', {
        locale: '<?php echo $locale; ?>'
    });

    mp.checkout({
        preference: {
            id: '<?php echo $preference->id; ?>'
        },
        autoOpen: false,
        render: {
            container: '.cho-container',
            label: 'Pagar la compra',
        },
        theme: {
            elementsColor: '#c0392b',
            headerColor: '#c0392b',
        }
    });
</script>
