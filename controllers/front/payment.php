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

require_once dirname(__FILE__) . '/../../lib/sofortlib/payment/sofortLibSofortueberweisung.inc.php';

class SofortbankingPaymentModuleFrontController extends ModuleFrontController
{
    public $ssl = true;

    /**
     *
     * @see FrontController::initContent()
     */
    public function initContent()
    {
        $this->display_column_left = false;
        $this->display_column_right = false;

        parent::initContent();

        if (!$this->isTokenValid()) {
            throw new \Exception(sprintf('%s Error: (Invalid token)', $this->module->displayName));
        }

        if (!$this->module->isPayment()) {
            throw new \Exception(sprintf('%s Error: (Inactive or incomplete module configuration)', $this->module->displayName));
        }

        $cart = $this->context->cart;
        $address = new Address((int) $cart->id_address_invoice);
        $customer = new Customer((int) $cart->id_customer);
        $currency = $this->context->currency;

        if (!Validate::isLoadedObject($address)
            || !Validate::isLoadedObject($customer)
            || !Validate::isLoadedObject($currency)) {
            throw new \Exception(sprintf('%s Error: (Invalid address or customer object)', $this->module->displayName));
        }

        $sofortueberweisung = new Sofortueberweisung(sprintf('%s:%s:%s',
            Configuration::get('SOFORTBANKING_USER_ID'),
            Configuration::get('SOFORTBANKING_PROJECT_ID'),
            Configuration::get('SOFORTBANKING_API_KEY')));

        $sofortueberweisung->setUserVariable(array(
            $cart->id,
            $customer->secure_key
        ));
        $sofortueberweisung->setAmount(number_format($cart->getOrderTotal(), 2, '.', ''));
        $sofortueberweisung->setCurrencyCode($currency->iso_code);
        $sofortueberweisung->setReason(sprintf('%09d - %s %s',
            $cart->id,
            $customer->firstname,
            Tools::ucfirst(Tools::strtolower($customer->lastname))));

        $url = array(
            'notification' => $this->context->shop->getBaseURL() . 'modules/' . $this->module->name . '/notification.php',
            'success' => $this->context->shop->getBaseURL() . 'modules/' . $this->module->name . '/confirmation.php?transaction=-TRANSACTION-',
            'cancellation' => $this->context->shop->getBaseURL() . 'index.php?controller=order&step=3'
        );

        $sofortueberweisung->setSuccessUrl($url['success']);
        $sofortueberweisung->setAbortUrl($url['cancellation']);
        $sofortueberweisung->setNotificationUrl($url['notification'], 'untraceable,pending,received,loss,refunded');

        $sofortueberweisung->setVersion(sprintf('PrestaShop_%s/Module_%s', _PS_VERSION_, $this->module->version));

        $sofortueberweisung->sendRequest();
        if ($sofortueberweisung->isError()) {
            throw new \Exception(sprintf('Sofortbanking module configuration error: %s', $sofortueberweisung->getError()));
        } else {
            Tools::redirect($sofortueberweisung->getPaymentUrl());
        }
    }
}
