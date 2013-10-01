<?php
/**
 * $Id$
 *
 * sofortbanking Module
 *
 * Copyright (c) 2009 touchdesign
 *
 * @category Payment
 * @version 1.9
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
require_once dirname(__FILE__).'/lib/touchdesign.php';

$sofortbanking = new sofortbanking();

$order_id = Order::getOrderByCartId(intval(Tools::getValue('user_variable_1')));

$order = new Order($order_id);

if (version_compare(_PS_VERSION_, '1.4.0', '<')){
		touchdesign::redirect(__PS_BASE_URI__ . 'order-confirmation.php','id_cart=' . $order->id_cart 
			. '&id_module=' . $sofortbanking->id . '&id_order=' . $order_id 
			. '&key='.$order->secure_key);
}else{
		touchdesign::redirect(__PS_BASE_URI__ . 'index.php','controller=order-confirmation&id_cart=' . $order->id_cart 
			. '&id_module=' . $sofortbanking->id . '&id_order=' . $order_id 
			. '&key='.$order->secure_key);
}

?>