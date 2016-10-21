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

require_once dirname(__FILE__) . '/../../config/config.inc.php';
require_once dirname(__FILE__) . '/../../init.php';
require_once dirname(__FILE__) . '/sofortbanking.php';
require_once dirname(__FILE__) . '/lib/sofortlib/core/sofortLibNotification.inc.php';
require_once dirname(__FILE__) . '/lib/sofortlib/core/sofortLibTransactionData.inc.php';

$sofortNotification = new SofortLibNotification();

if ((!$notification = $sofortNotification->getNotification(Tools::file_get_contents('php://input')))) {
    throw new \Exception('Invalid notification, nothing todo.');
}

$sofortTransaction = new SofortLibTransactionData(sprintf('%s:%s:%s',
    Configuration::get('SOFORTBANKING_USER_ID'),
    Configuration::get('SOFORTBANKING_PROJECT_ID'),
    Configuration::get('SOFORTBANKING_API_KEY')));
$sofortTransaction->addTransaction($notification);
$sofortTransaction->setApiVersion('2.0');
$sofortTransaction->sendRequest();

if ($sofortTransaction->isError()) {
    throw new \Exception(sprintf('SOFORT transaction data "%s".', $sofortTransaction->getError()));
} else {

    /* Join transaction datas */
    $transaction = array(
        'id' => $sofortTransaction->getTransaction(),
        'amount' => $sofortTransaction->getAmount(),
        'status' => $sofortTransaction->getStatus(),
        'cart_id' => $sofortTransaction->getUserVariable(),
        'secure_key' => $sofortTransaction->getUserVariable(0, 1)
    );

    try {
        if ((!$cart = new Cart((int) $transaction['cart_id'])) || !is_object($cart) || $cart->id === null) {
            throw new \Exception(sprintf('Unable to load cart by card id "%d".', $transaction['cart_id']));
        }
        if ((!$customer = new Customer($cart->id_customer)) || $customer->secure_key != $transaction['secure_key']) {
            throw new \Exception('Invalid or missing customer secure key for this transaction.');
        }
    } catch (\Exception $e) {
        throw $e;
    }

    /* Allocate new order state */
    switch ($transaction['status']) {
        case 'untraceable':
            $order_state = Configuration::get('SOFORTBANKING_OS_ACCEPTED');
            break;
        case 'pending':
            $order_state = Configuration::get('SOFORTBANKING_OS_ACCEPTED');
            break;
        case 'received':
            $order_state = Sofortbanking::OS_RECEIVED;
            break;
        case 'loss':
            $order_state = Configuration::get('SOFORTBANKING_OS_ERROR');
            break;
        case 'refunded':
            $order_state = Sofortbanking::OS_REFUNDED;
            break;
        default:
            $order_state = Configuration::get('SOFORTBANKING_OS_ERROR');
    }

    $sofortbanking = new Sofortbanking();
    $order = new Order(Order::getOrderByCartId($cart->id));

    if ($order_state == Configuration::get('SOFORTBANKING_OS_ACCEPTED')
        && $order->id === null) {

        $sofortbanking->validateOrder($cart->id, $order_state, $transaction['amount'], $sofortbanking->displayName,
            $sofortbanking->l(sprintf('SOFORT transaction ID: %s.', $transaction['id'])), array(
                'transaction_id' => $transaction['id']
            ), null, false, $transaction['secure_key'], null);
        $sofortbanking->saveTransaction($transaction['id'], $sofortbanking->currentOrder);

    } elseif ($order->id && $order->getCurrentState() != $order_state) {

        if ($order->getCurrentState() == Configuration::get('SOFORTBANKING_OS_ACCEPTED')
            && Configuration::get('SOFORTBANKING_OS_ACCEPTED_IGNORE') == 'Y') {
                throw new \Exception('Notification disabled for accepted order state, nothing todo.');
        }

        if ($order->getCurrentState() == Configuration::get('SOFORTBANKING_OS_ERROR')
            && Configuration::get('SOFORTBANKING_OS_ERROR_IGNORE') == 'Y') {
                throw new \Exception('Notification disabled for error order state, nothing todo.');
        }

        $history = new OrderHistory();
        $history->id_order = $order->id;
        $history->changeIdOrderState($order_state, $order->id);
        $history->addWithemail(true);

        $message = new Message();
        $message->message = $sofortbanking->l(sprintf('Order state successfully updated for transaction ID: %s.'), $transaction['id']);
        $message->private = 1;
        $message->id_order = $order->id;
        $message->add();

    }

}
