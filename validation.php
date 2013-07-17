<?php
/**
 * $Id$
 *
 * sofortbanking Module
 *
 * Copyright (c) 2009 touchdesign
 *
 * @category Payment
 * @version 1.8
 * @copyright 19.08.2009, touchdesign
 * @author Christin Gruber, <www.touchdesign.de>
 * @link http://www.touchdesign.de/loesungen/prestashop/sofortueberweisung.htm
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 *
 * Description:
 *
 * Payment module sofortbanking
 *
 * --
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@touchdesign.de so we can send you a copy immediately.
 *
 */

require dirname(__FILE__).'/../../config/config.inc.php';
require dirname(__FILE__).'/sofortbanking.php';

$orderState = Configuration::get('SOFORTBANKING_OS_ERROR');
$password = Configuration::get('SOFORTBANKING_NOTIFY_PW')
	? Configuration::get('SOFORTBANKING_NOTIFY_PW')
	: Configuration::get('SOFORTBANKING_PROJECT_PW');

$requestData = array('transaction' => $_POST['transaction'] , 'user_id' => $_POST['user_id'] ,
	'project_id' => $_POST['project_id'] , 'sender_holder' => $_POST['sender_holder'] ,
	'sender_account_number' => $_POST['sender_account_number'] , 'sender_bank_code' => $_POST['sender_bank_code'] ,
	'sender_bank_name' => $_POST['sender_bank_name'] , 'sender_bank_bic' => $_POST['sender_bank_bic'] ,
	'sender_iban' => $_POST['sender_iban'] , 'sender_country_id' => $_POST['sender_country_id'] ,
	'recipient_holder' => $_POST['recipient_holder'] , 'recipient_account_number' => $_POST['recipient_account_number'] ,
	'recipient_bank_code' => $_POST['recipient_bank_code'] , 'recipient_bank_name' => $_POST['recipient_bank_name'] ,
	'recipient_bank_bic' => $_POST['recipient_bank_bic'] , 'recipient_iban' => $_POST['recipient_iban'] ,
	'recipient_country_id' => $_POST['recipient_country_id'] , 'international_transaction' => $_POST['international_transaction'] ,
	'amount' => $_POST['amount'] , 'currency_id' => $_POST['currency_id'] , 'reason_1' => $_POST['reason_1'] ,
	'reason_2' => $_POST['reason_2'] , 'security_criteria' => $_POST['security_criteria'] ,
	'user_variable_0' => $_POST['user_variable_0'] , 'user_variable_1' => $_POST['user_variable_1'] ,
	'user_variable_2' => $_POST['user_variable_2'] , 'user_variable_3' => $_POST['user_variable_3'] ,
	'user_variable_4' => $_POST['user_variable_4'] , 'user_variable_5' => $_POST['user_variable_5'] ,
	'created' => $_POST['created'] , 'project_password' => $password);

$cart = new Cart(intval($_POST['user_variable_1']));

if(class_exists('Context')){
	if (empty(Context::getContext()->link))
		Context::getContext()->link = new Link();
	Context::getContext()->language = new Language($cart->id_lang);
	Context::getContext()->currency = new Currency($cart->id_currency);
}
$sofortbanking = new Sofortbanking();

// Validate submited post vars
if($_POST['hash'] != sha1(implode('|', $requestData)))
	echo($sofortbanking->l('Fatal Error (1)'));
elseif(!is_object($cart) || !$cart)
	echo($sofortbanking->l('Fatal Error (2)'));
else
	$orderState = Configuration::get('SOFORTBANKING_OS_ACCEPTED');

$customer = new Customer((int)$cart->id_customer);

// Validate this card in store
if (version_compare(_PS_VERSION_, '1.4.0', '<')){
	$sofortbanking->validateOrder($cart->id, $orderState, floatval(number_format($cart->getOrderTotal(true, 3), 2, '.', '')),
		$sofortbanking->displayName, $sofortbanking->l('Directebanking transaction id: ').$_POST['transaction'],
		null, null, false);
}else{
	$sofortbanking->validateOrder($cart->id, $orderState, floatval(number_format($cart->getOrderTotal(true, 3), 2, '.', '')),
		$sofortbanking->displayName, $sofortbanking->l('Directebanking transaction id: ').$_POST['transaction'],
		null, null, false, $customer->secure_key);
}

?>