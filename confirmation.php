<?php
/**
 * $Id$
 *
 * sofortueberweisung Module
 *
 * Copyright (c) 2009 touchDesign
 *
 * @category Payment
 * @version 0.7
 * @copyright 19.08.2009, touchDesign
 * @author Christoph Gruber, <www.touchdesign.de>
 * @link http://www.touchdesign.de/loesungen/prestashop/sofortueberweisung.htm
 * @link http://www.homepage-community.de/index.php?topic=569.0
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 *
 * Description:
 *
 * Payment module directebanking
 *
 */

include(dirname(__FILE__).'/../../config/config.inc.php');
include(dirname(__FILE__).'/sofortueberweisung.php');

$touchDirectEBank = new Sofortueberweisung();

$order_id = Order::getOrderByCartId(intval($_GET['user_variable_1']));

$order = new Order($order_id);

Tools::redirectLink(__PS_BASE_URI__ . 'order-confirmation.php?id_cart=' . $order->id_cart 
	. '&id_module=' . $touchDirectEBank->id . '&id_order=' . $order_id
	. '&key='.$order->secure_key);

?>