<?php
/**
 * sofortbanking Module
 *
 * Copyright (c) 2009 touchdesign
 *
 * @category  Payment
 * @author    Christin Gruber, <www.touchdesign.de>
 * @copyright 19.08.2009, touchdesign
 * @link      http://www.touchdesign.de/loesungen/prestashop/sofortueberweisung.htm
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
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
 */

require_once dirname(__FILE__).'/../../config/config.inc.php';
require_once dirname(__FILE__).'/../../init.php';
require_once dirname(__FILE__).'/sofortbanking.php';

$sofortbanking = new Sofortbanking();

$i = 0;
do {
	$order = $sofortbanking->getOrderByTransaction(Tools::getValue('transaction'));
	if($i >= $sofortbanking::TIMEOUT || $order->id) {
		break;
	}
	$i++;
	sleep(1);
} while (!$order->id);

if(!$order || !is_object($order) || $order->id === null) {
	Tools::redirect('index.php');
}

Tools::redirect('index.php?controller=order-confirmation&id_cart='.$order->id_cart
	.'&id_module='.$sofortbanking->id.'&id_order='.$order->id
	.'&key='.$order->secure_key);

?>