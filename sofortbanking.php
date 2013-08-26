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

class Sofortbanking extends PaymentModule
{
	/** @var string HTML */
	private $_html = '';
	
	/** @var string Supported languages */
	private $_languages = array('en','de','es','fr','it','nl','pl','gb');

	/**
	 * Build module
	 *
	 * @see PaymentModule::__construct()
	 */
	public function __construct()
	{
		$this->name = 'sofortbanking';
		if (version_compare(_PS_VERSION_, '1.4.0', '<'))
			$this->tab = 'Payment';
		else
			$this->tab = 'payments_gateways';
		$this->version = '1.9';
		$this->author = 'touchdesign';
		$this->module_key = '65af9f83d2ae6fbe6dbdaa91d21f952a';
		$this->currencies = true;
		$this->currencies_mode = 'radio';
		parent::__construct();
		$this->page = basename(__FILE__, '.php');
		$this->displayName = $this->l('sofortbanking');
		$this->description = $this->l('Accepts payments by sofortbanking');
		$this->confirmUninstall = $this->l('Are you sure you want to delete your details?');
		if(isset($this->context))
			$this->language = $this->context->language;
		else{
			global $cookie;
			$this->language = new Language($cookie->id_lang);
		}
	}

	/**
	 * Install module
	 *
	 * @see PaymentModule::install()
	 */
	public function install()
	{
		if (!parent::install() || !Configuration::updateValue('SOFORTBANKING_USER_ID', '') ||
				!Configuration::updateValue('SOFORTBANKING_PROJECT_ID', '') ||
				!Configuration::updateValue('SOFORTBANKING_PROJECT_PW', '') ||
				!Configuration::updateValue('SOFORTBANKING_NOTIFY_PW', '') ||
				!Configuration::updateValue('SOFORTBANKING_BLOCK_LOGO', 'Y') ||
				!Configuration::updateValue('SOFORTBANKING_CPROTECT', 'N') ||
				!Configuration::updateValue('SOFORTBANKING_OS_ERROR', 8) ||
				!Configuration::updateValue('SOFORTBANKING_OS_ACCEPTED', 2) ||
				!Configuration::updateValue('SOFORTBANKING_REDIRECT', 'N') ||
				!$this->registerHook('payment') ||
				!$this->registerHook('paymentReturn') ||
				!$this->registerHook('leftColumn'))
			return false;
		return true;
	}

	/**
	 * Uninstall module
	 *
	 * @see PaymentModule::uninstall()
	 */
	public function uninstall()
	{
		if (!Configuration::deleteByName('SOFORTBANKING_USER_ID') ||
				!Configuration::deleteByName('SOFORTBANKING_PROJECT_ID') ||
				!Configuration::deleteByName('SOFORTBANKING_PROJECT_PW') ||
				!Configuration::deleteByName('SOFORTBANKING_NOTIFY_PW') ||
				!Configuration::deleteByName('SOFORTBANKING_BLOCK_LOGO') ||
				!Configuration::deleteByName('SOFORTBANKING_OS_ERROR') ||
				!Configuration::deleteByName('SOFORTBANKING_OS_ACCEPTED') ||
				!Configuration::deleteByName('SOFORTBANKING_CPROTECT') ||
				!Configuration::deleteByName('SOFORTBANKING_REDIRECT') ||
				!parent::uninstall())
			return false;
		return true;
	}

	/**
	 * Validate submited data
	 */
	private function _postValidation()
	{
		if (Tools::getValue('submitUpdate')){
			if (!Tools::getValue('SOFORTBANKING_USER_ID'))
				$this->_postErrors[] = $this->l('sofortueberweisung "user id" is required.');
			if (!Tools::getValue('SOFORTBANKING_PROJECT_ID'))
				$this->_postErrors[] = $this->l('sofortueberweisung "project id" is required.');
			if (!Tools::getValue('SOFORTBANKING_PROJECT_PW'))
				$this->_postErrors[] = $this->l('sofortueberweisung "project password" is required.');
		}
	}

	/**
	 * Update submited configurations
	 */
	public function getContent()
	{
		$this->_html = '<h2>'.$this->displayName.'</h2>';
		if (Tools::isSubmit('submitUpdate')){
			Configuration::updateValue('SOFORTBANKING_USER_ID', Tools::getValue('SOFORTBANKING_USER_ID'));
			Configuration::updateValue('SOFORTBANKING_PROJECT_ID', Tools::getValue('SOFORTBANKING_PROJECT_ID'));
			Configuration::updateValue('SOFORTBANKING_PROJECT_PW', Tools::getValue('SOFORTBANKING_PROJECT_PW'));
			Configuration::updateValue('SOFORTBANKING_NOTIFY_PW', Tools::getValue('SOFORTBANKING_NOTIFY_PW'));
			Configuration::updateValue('SOFORTBANKING_BLOCK_LOGO', Tools::getValue('SOFORTBANKING_BLOCK_LOGO'));
			Configuration::updateValue('SOFORTBANKING_CPROTECT', Tools::getValue('SOFORTBANKING_CPROTECT'));
			Configuration::updateValue('SOFORTBANKING_REDIRECT', Tools::getValue('SOFORTBANKING_REDIRECT'));
		}

		$this->_postValidation();
		if (isset($this->_postErrors) && sizeof($this->_postErrors))
			foreach ($this->_postErrors AS $err)
				$this->_html .= '<div class="alert error">'. $err .'</div>';
		elseif(Tools::getValue('submitUpdate') && !isset($this->_postErrors))
			$this->getSuccessMessage();

		return $this->_displayForm();
	}

	/**
	 * Get success message for submited and updated datas
	 */
	public function getSuccessMessage()
	{
		$this->_html.='
		<div class="conf confirm">
			<img src="../img/admin/ok.gif" alt="'.$this->l('Confirmation').'" />
			'.$this->l('Settings updated').'
		</div>';
	}

	/**
	 * Build and display admin form for configurations
	 */
	private function _displayForm()
	{
		$this->_html.= '
			<style type="text/css">
			fieldset a {
				color:#0099ff;
				text-decoration:underline;"
			}
			fieldset a:hover {
				color:#000000;
				text-decoration:underline;"
			}
			</style>';

		$this->_html .= '
			<div><img src="'.$this->_path.'img/'.$this->isSupportedLang($this->language->iso_code).'/sofortbanking.png" alt="sofortbanking.png" title="" /></div>
			<form method="post" action="'.$_SERVER['REQUEST_URI'].'">
			<fieldset>
				<legend><img src="'.$this->_path.'logo.gif" />'.$this->l('Settings').'</legend>
				<label>'.$this->l('sofortbanking user ID?').'</label>
				<div class="margin-form">
					<input type="text" name="SOFORTBANKING_USER_ID" value="'.Configuration::get('SOFORTBANKING_USER_ID').'" />
					<p>'.$this->l('Leave it blank for disabling').'</p>
				</div>
				<div class="clear"></div>
				<label>'.$this->l('sofortbanking project ID?').'</label>
				<div class="margin-form">
					<input type="text" name="SOFORTBANKING_PROJECT_ID" value="'.Configuration::get('SOFORTBANKING_PROJECT_ID').'" />
					<p>'.$this->l('Leave it blank for disabling').'</p>
				</div>
				<div class="clear"></div>
				<label>'.$this->l('sofortbanking project password?').'</label>
				<div class="margin-form">
					<input type="password" name="SOFORTBANKING_PROJECT_PW" value="'.Configuration::get('SOFORTBANKING_PROJECT_PW').'" />
					<p>'.$this->l('Leave it blank for disabling').'</p>
				</div>
				<div class="clear"></div>
				<label>'.$this->l('sofortbanking notify password?').'</label>
				<div class="margin-form">
					<input type="password" name="SOFORTBANKING_NOTIFY_PW" value="'.Configuration::get('SOFORTBANKING_NOTIFY_PW').'" />
					<p>'.$this->l('Leave it blank for disabling').'</p>
				</div>
				<div class="clear"></div>
				<label>'.$this->l('sofortbanking Logo?').'</label>
				<div class="margin-form">
					<select name="SOFORTBANKING_BLOCK_LOGO">
						<option '.(Configuration::get('SOFORTBANKING_BLOCK_LOGO') == "Y" ? "selected" : "").' value="Y">'.$this->l('Yes, display the logo (recommended)').'</option>
						<option '.(Configuration::get('SOFORTBANKING_BLOCK_LOGO') == "N" ? "selected" : "").' value="N">'.$this->l('No, do not display').'</option>
					</select>
					<p>'.$this->l('Display logo and payment info block in left column').'</p>
				</div>
				<div class="clear"></div>
				<label>'.$this->l('Customer protection active:').'</label>
				<div class="margin-form">
					<select name="SOFORTBANKING_CPROTECT">
						<option '.(Configuration::get('SOFORTBANKING_CPROTECT') == "Y" ? "selected" : "").' value="Y">'.$this->l('Yes').'</option>
						<option '.(Configuration::get('SOFORTBANKING_CPROTECT') == "N" ? "selected" : "").' value="N">'.$this->l('No').'</option>
					</select>
					<p>
						'.$this->l('You need a bank account with') .
						' <a target="_blank" href="http://www.sofort-bank.com" target="_blank">Sofort Bank</a> ' .
						$this->l('You need a bank account with and customer protection must be enabled in your project settings. Please check with') .
						' <a target="_blank" href="https://kaeuferschutz.sofort-bank.com/consumerProtections/index/'.Configuration::get('SOFORTBANKING_PROJECT_ID').'">'.
						$this->l('this link') .
						'</a> ' .
						$this->l('if customer protection is activated and enabled before enabling it here.') . '
					</p>
				</div>
				<div class="clear"></div>
				<label>'.$this->l('Force redirect?').'</label>
				<div class="margin-form">
					<select name="SOFORTBANKING_REDIRECT">
						<option '.(Configuration::get('SOFORTBANKING_REDIRECT') == "Y" ? "selected" : "").' value="Y">'.$this->l('Yes, force redirect.').'</option>
						<option '.(Configuration::get('SOFORTBANKING_REDIRECT') == "N" ? "selected" : "").' value="N">'.$this->l('No, let the customer confirm the order first.').'</option>
					</select>
					<p>'.$this->l('Force redirect to soforbanking payment page (skip confirm page).').'</p>
				</div>
				<div class="clear"></div>
				<div class="margin-form clear pspace"><input type="submit" name="submitUpdate" value="'.$this->l('Update').'" class="button" /></div>
			</fieldset>
			</form><br />
			<fieldset>
				<legend><img src="'.$this->_path.'logo.gif" />'.$this->l('URLs').'</legend>
				<b>'.$this->l('Confirmation-Url:').' '.$this->l('(Method POST)').'</b><br /><textarea rows=1 style="width:98%;">'.(Configuration::get('PS_SSL_ENABLED') == 1 ? 'https://' : 'http://').$_SERVER['HTTP_HOST']._MODULE_DIR_.$this->name.'/validation.php</textarea>
				<br /><br />
				<b>'.$this->l('Success-Url:').'</b><br /><textarea rows=1 style="width:98%;">'.(Configuration::get('PS_SSL_ENABLED') == 1 ? 'https://' : 'http://').$_SERVER['HTTP_HOST']._MODULE_DIR_.$this->name.'/confirmation.php?user_variable_1=-USER_VARIABLE_1-</textarea>
				<br /><br />';
		if(version_compare(_PS_VERSION_, '1.5.0', '<'))
			$this->_html .= '<b>'.$this->l('Cancel-Url:').'</b><br /><textarea rows=1 style="width:98%;">'.(Configuration::get('PS_SSL_ENABLED') == 1 ? 'https://' : 'http://').$_SERVER['HTTP_HOST'].__PS_BASE_URI__.'order.php?step=3</textarea>';
		else
			$this->_html .= '<b>'.$this->l('Cancel-Url:').'</b><br /><textarea rows=1 style="width:98%;">'.(Configuration::get('PS_SSL_ENABLED') == 1 ? 'https://' : 'http://').$_SERVER['HTTP_HOST'].__PS_BASE_URI__.'index.php?controller=order&step=3</textarea>';
		$this->_html .= '
			</fieldset>';

		$this->_html .= '
			<fieldset class="space">
				<legend><img src="../img/admin/unknown.gif" alt="" class="middle" />'.$this->l('Help').'</legend>
				<b>'.$this->l('@Link:').'</b> <a target="_blank" href="http://www.touchdesign.de/ico/paymentnetwork.htm">'.$this->l('sofortbanking.com').'</a><br />
				'.$this->l('@Author and Copyright:').' <a target="_blank" href="http://www.touchdesign.de/loesungen/prestashop/sofortueberweisung.htm">touchdesign</a><br />
				<b>'.$this->l('@Description:').'</b><br /><br />
				'.$this->l('sofortbanking is the direct payment method of Payment Network AG. sofortbanking allows you to directly and automatically trigger a credit transfer during your online purchase with your online banking information. A transfer order is instantly confirmed to merchant allowing an instant delivery of goods and services.').'
			</fieldset><br />';

		return $this->_html;
	}
	
	/**
	 * Check supported languages
	 *
	 * @param string $iso
	 * @return string iso
	 */
	private function isSupportedLang($iso=null)
	{
		global $cart;
	
		if($iso === null)
			$iso = Language::getIsoById(intval($cart->id_lang));
		if(in_array($iso,$this->_languages))
			return $iso;
		else
			return 'en';
	}
	
	/**
	 * Build and display payment button
	 * 
	 * @param array $params
	 * @return string Templatepart
	 */
	public function hookPayment($params)
	{
		global $smarty, $cart;

		$smarty->assign('this_path',$this->_path);
		$smarty->assign('this_path_ssl',Tools::getHttpHost(true, true).__PS_BASE_URI__.'modules/'.$this->name.'/');
		$smarty->assign('cprotect',Configuration::get('SOFORTBANKING_CPROTECT'));
		$smarty->assign('lang',Language::getIsoById(intval($params['cart']->id_lang)));
		$smarty->assign('mod_lang',$this->isSupportedLang());

		return $this->display(__FILE__, 'sofortbanking.tpl');
	}
	
	/**
	 * Build and display confirmation
	 *
	 * @param array $params
	 * @return string Templatepart
	 */
	public function hookPaymentReturn($params)
	{
		global $smarty;

		if (!$this->isPayment())
			return false;

		$state = $params['objOrder']->getCurrentState();
		if ($state == Configuration::get('SOFORTBANKING_OS_ACCEPTED'))
			$smarty->assign(array(
				'total_to_pay' => Tools::displayPrice($params['total_to_pay'], $params['currencyObj'], false),
				'status' => 'accepted'
			)
		);

		return $this->display(__FILE__, 'confirmation.tpl');
	}

	/**
	 * Build and display left column banner
	 *
	 * @param array $params
	 * @return string Templatepart
	 */
	public function hookLeftColumn($params)
	{
		global $smarty;
		if(Configuration::get('SOFORTBANKING_BLOCK_LOGO') == "N")
			return false;
		$smarty->assign('mod_lang',$this->isSupportedLang());
		return $this->display(__FILE__, 'block_sofortbanking_logo.tpl');
	}

	/**
	 * Check if payment is active
	 *
	 * @return boolean
	 */
	public function isPayment()
	{
		if (!$this->active)
			return false;
		
		if (!Configuration::get('SOFORTBANKING_USER_ID')
				|| !Configuration::get('SOFORTBANKING_PROJECT_ID')
				|| !Configuration::get('SOFORTBANKING_PROJECT_PW'))
			return false;
		return true;
	}

	/**
	 * Build and display payment page
	 *
	 * @param object $cart
	 * @return string Templatepart
	 */
	public function execPayment($cart)
	{
		global $cookie, $smarty;

		if (!$this->isPayment())
			return false;

		$address = new Address(intval($cart->id_address_invoice));
		$customer = new Customer(intval($cart->id_customer));
		$currency = $this->getCurrency();
		$country = new Country(intval($address->id_country));
		$lang = Language::getIsoById(intval($cart->id_lang));

		if (!Configuration::get('SOFORTBANKING_USER_ID'))
			return $this->l($this->displayName.' Error: (invalid or undefined userId)');
		if (!Configuration::get('SOFORTBANKING_PROJECT_ID'))
			return $this->l($this->displayName.' Error: (invalid or undefined projectId)');
		if (!Validate::isLoadedObject($address)
				|| !Validate::isLoadedObject($customer)
				|| !Validate::isLoadedObject($currency))
			return $this->l($this->displayName.' Error: (invalid address or customer)');

		$parameters = array(
			'user_id' => Configuration::get('SOFORTBANKING_USER_ID'),'project_id' => Configuration::get('SOFORTBANKING_PROJECT_ID'),
			'sender_holder' => '','','','sender_country_id' => $country->iso_code,
			'amount' => number_format($cart->getOrderTotal(), 2, '.', ''),
			'currency_id' => $currency->iso_code,'reason_1' => $this->l('CartId:').' '.time().'-'.intval($cart->id),
			'reason_2' => $customer->firstname.' '.ucfirst(strtolower($customer->lastname)),
			'user_variable_0' => $customer->secure_key,'user_variable_1' => intval($cart->id),
			'user_variable_2' => '','user_variable_3' => '','user_variable_4' => '','user_variable_5' => '',
			'project_password' => Configuration::get('SOFORTBANKING_PROJECT_PW'),
		);

		$smarty->assign(array(
			'this_path' => $this->_path,
			'this_path_ssl' => Tools::getHttpHost(true, true).__PS_BASE_URI__.'modules/'.$this->name.'/',
			'nbProducts' => $cart->nbProducts(),
			'cust_currency' => $cookie->id_currency,
			'currencies' => $this->getCurrency(),
			'total' => $cart->getOrderTotal(),
			'isoCode' => Language::getIsoById(intval($cookie->id_lang)),
			'version' => _PS_VERSION_,
			'hash' => sha1(implode('|',$parameters)),
			'gateway' => 'https://www.sofortueberweisung.de/payment/start',
			'lang' => $lang,
			'cprotect' => Configuration::get('SOFORTBANKING_CPROTECT'),
			'parameters' => $parameters,
			'mod_lang',$this->isSupportedLang()
		));

		return $this->display(__FILE__, (Configuration::get('SOFORTBANKING_REDIRECT') == 'Y'
			? 'payment_redirect.tpl' : 'payment_execution.tpl'));
	}

}

?>