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

class Sofortueberweisung extends PaymentModule
{
	private $_html = '';

	public function __construct()
	{
		$this->name = 'sofortueberweisung';
		$this->tab = 'Payment';
		$this->version = '0.7';
		$this->currencies = true;
		$this->currencies_mode = 'radio';
		parent::__construct();
		$this->page = basename(__FILE__, '.php');
		$this->displayName = $this->l('sofortueberweisung.de');
		$this->description = $this->l('Accepts payments by sofortueberweisung.de');
		$this->confirmUninstall = $this->l('Are you sure you want to delete your details?');
	}

	public function install()
	{
		if (!parent::install() ||
			!Configuration::updateValue('SOFORTUEBERWEISUNG_USER_ID', '') ||
			!Configuration::updateValue('SOFORTUEBERWEISUNG_PROJECT_ID', '') ||
			!Configuration::updateValue('SOFORTUEBERWEISUNG_PROJECT_PW', '') ||
			!Configuration::updateValue('SOFORTUEBERWEISUNG_NOTIFY_PW', '') ||
			!Configuration::updateValue('SOFORTUEBERWEISUNG_BLOCK_LOGO', 'Y') ||
			!Configuration::updateValue('SOFORTUEBERWEISUNG_CPROTECT', 'N') ||
			!Configuration::updateValue('SOFORTUEBERWEISUNG_OS_ERROR', 8) ||
			!Configuration::updateValue('SOFORTUEBERWEISUNG_OS_ACCEPTED', 2) ||
			!$this->registerHook('payment') ||
			!$this->registerHook('paymentReturn') ||
			!$this->registerHook('leftColumn')
		){
			return false;
		}

		return true;
	}

	public function uninstall()
	{
		if (!Configuration::deleteByName('SOFORTUEBERWEISUNG_USER_ID') ||
			!Configuration::deleteByName('SOFORTUEBERWEISUNG_PROJECT_ID') ||
			!Configuration::deleteByName('SOFORTUEBERWEISUNG_PROJECT_PW') ||
			!Configuration::deleteByName('SOFORTUEBERWEISUNG_NOTIFY_PW') ||
			!Configuration::deleteByName('SOFORTUEBERWEISUNG_BLOCK_LOGO') ||
			!Configuration::deleteByName('SOFORTUEBERWEISUNG_OS_ERROR') ||
			!Configuration::deleteByName('SOFORTUEBERWEISUNG_OS_ACCEPTED') ||
			!Configuration::deleteByName('SOFORTUEBERWEISUNG_CPROTECT') ||
			!parent::uninstall()
		){
			return false;
		}

		return true;
	}

	private function _postValidation()
	{
		if (Tools::getValue('submitUpdate')){
			if (!Tools::getValue('SOFORTUEBERWEISUNG_USER_ID')){
				$this->_postErrors[] = $this->l('sofortueberweisung.de "user id" is required.');
			}
			if (!Tools::getValue('SOFORTUEBERWEISUNG_PROJECT_ID')){
				$this->_postErrors[] = $this->l('sofortueberweisung.de "project id" is required.');
			}
			if (!Tools::getValue('SOFORTUEBERWEISUNG_PROJECT_PW')){
				$this->_postErrors[] = $this->l('sofortueberweisung.de "project password" is required.');
			}
		}
	}

	public function getContent()
	{
		$this->_html = '<h2>'.$this->displayName.'</h2>';
		if (Tools::isSubmit('submitUpdate')){
			Configuration::updateValue('SOFORTUEBERWEISUNG_USER_ID', Tools::getValue('SOFORTUEBERWEISUNG_USER_ID'));
			Configuration::updateValue('SOFORTUEBERWEISUNG_PROJECT_ID', Tools::getValue('SOFORTUEBERWEISUNG_PROJECT_ID'));
			Configuration::updateValue('SOFORTUEBERWEISUNG_PROJECT_PW', Tools::getValue('SOFORTUEBERWEISUNG_PROJECT_PW'));
			Configuration::updateValue('SOFORTUEBERWEISUNG_NOTIFY_PW', Tools::getValue('SOFORTUEBERWEISUNG_NOTIFY_PW'));
			Configuration::updateValue('SOFORTUEBERWEISUNG_BLOCK_LOGO', Tools::getValue('SOFORTUEBERWEISUNG_BLOCK_LOGO'));
			Configuration::updateValue('SOFORTUEBERWEISUNG_CPROTECT', Tools::getValue('SOFORTUEBERWEISUNG_CPROTECT'));
		}

		$this->_postValidation();
		if (isset($this->_postErrors) && sizeof($this->_postErrors)){
			foreach ($this->_postErrors AS $err){
				$this->_html .= '<div class="alert error">'. $err .'</div>';
			}
		}elseif(Tools::getValue('submitUpdate') && !isset($this->_postErrors)){
		  $this->getSuccessMessage();
		}

		return $this->_displayForm();
	}

	public function getSuccessMessage() 
	{
		$this->_html.='
		<div class="conf confirm">
			<img src="../img/admin/ok.gif" alt="'.$this->l('Confirmation').'" />
			'.$this->l('Settings updated').'
		</div>';
	}

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
			<div><img src="'.$this->_path.'logoBig.gif" alt="logoBig.gif" title="" /></div>
			<form method="post" action="'.$_SERVER['REQUEST_URI'].'">
			<fieldset>
				<legend><img src="'.$this->_path.'logo.gif" />'.$this->l('Settings').'</legend>
				<label>'.$this->l('Sofortueberweisung user ID?').'</label>
				<div class="margin-form">
					<input type="text" name="SOFORTUEBERWEISUNG_USER_ID" value="'.Configuration::get('SOFORTUEBERWEISUNG_USER_ID').'" />
					<p>'.$this->l('Leave it blank for disabling').'</p>
				</div>
				<div class="clear"></div>
				<label>'.$this->l('Sofortueberweisung project ID?').'</label>
				<div class="margin-form">
					<input type="text" name="SOFORTUEBERWEISUNG_PROJECT_ID" value="'.Configuration::get('SOFORTUEBERWEISUNG_PROJECT_ID').'" />
					<p>'.$this->l('Leave it blank for disabling').'</p>
				</div>
				<div class="clear"></div>
				<label>'.$this->l('Sofortueberweisung project password?').'</label>
				<div class="margin-form">
					<input type="password" name="SOFORTUEBERWEISUNG_PROJECT_PW" value="'.Configuration::get('SOFORTUEBERWEISUNG_PROJECT_PW').'" />
					<p>'.$this->l('Leave it blank for disabling').'</p>
				</div>
				<div class="clear"></div>
				<label>'.$this->l('Sofortueberweisung notify password?').'</label>
				<div class="margin-form">
					<input type="password" name="SOFORTUEBERWEISUNG_NOTIFY_PW" value="'.Configuration::get('SOFORTUEBERWEISUNG_NOTIFY_PW').'" />
					<p>'.$this->l('Leave it blank for disabling').'</p>
				</div>
				<div class="clear"></div>
				<label>'.$this->l('sofortueberweisung.de Logo?').'</label>
				<div class="margin-form">
					<select name="SOFORTUEBERWEISUNG_BLOCK_LOGO">
						<option '.(Configuration::get('SOFORTUEBERWEISUNG_BLOCK_LOGO') == "Y" ? "selected" : "").' value="Y">'.$this->l('Yes, display the logo (recommended)').'</option>
						<option '.(Configuration::get('SOFORTUEBERWEISUNG_BLOCK_LOGO') == "N" ? "selected" : "").' value="N">'.$this->l('No, do not display').'</option>
					</select>
					<p>'.$this->l('Display logo and payment info block in left column').'</p>
				</div>
				<div class="clear"></div>
				<label>'.$this->l('Customer protection active:').'</label>
				<div class="margin-form">
					<select name="SOFORTUEBERWEISUNG_CPROTECT">
						<option '.(Configuration::get('SOFORTUEBERWEISUNG_CPROTECT') == "Y" ? "selected" : "").' value="Y">'.$this->l('Yes').'</option>
						<option '.(Configuration::get('SOFORTUEBERWEISUNG_CPROTECT') == "N" ? "selected" : "").' value="N">'.$this->l('No').'</option>
					</select>
					<p>
						'.$this->l('You need a bank account with') . 
						' <a target="_blank" href="http://www.sofort-bank.com" target="_blank">Sofort Bank</a> ' . 
						$this->l('You need a bank account with and customer protection must be enabled in your project settings. Please check with') . 
						' <a target="_blank" href="https://kaeuferschutz.sofort-bank.com/consumerProtections/index/'.Configuration::get('SOFORTUEBERWEISUNG_PROJECT_ID').'">'. 
						$this->l('this link') . 
						'</a> ' . 
						$this->l('if customer protection is activated and enabled before enabling it here.') . '
					</p>
				</div>
				<div class="clear"></div>
				<div class="margin-form clear pspace"><input type="submit" name="submitUpdate" value="'.$this->l('Update').'" class="button" /></div>
			</fieldset>
			</form><br />
			<fieldset>
				<legend><img src="'.$this->_path.'logo.gif" />'.$this->l('URLs').'</legend>
				<b>'.$this->l('Confirmation-Url:').'</b><br /><textarea rows=1 style="width:98%;">'.(Configuration::get('PS_SSL_ENABLED') == 1 ? 'https://' : 'http://').$_SERVER['HTTP_HOST']._MODULE_DIR_.$this->name.'/validation.php</textarea>
				<br /><br />
				<b>'.$this->l('Success-Url:').'</b><br /><textarea rows=1 style="width:98%;">'.(Configuration::get('PS_SSL_ENABLED') == 1 ? 'https://' : 'http://').$_SERVER['HTTP_HOST']._MODULE_DIR_.$this->name.'/confirmation.php?user_variable_1=-USER_VARIABLE_1-</textarea>
				<br /><br />
				<b>'.$this->l('Cancel-Url:').'</b><br /><textarea rows=1 style="width:98%;">'.(Configuration::get('PS_SSL_ENABLED') == 1 ? 'https://' : 'http://').$_SERVER['HTTP_HOST'].__PS_BASE_URI__.'order.php?step=3</textarea>
			</fieldset>
		';

		$this->_html .= '
			<fieldset class="space">
				<legend><img src="../img/admin/unknown.gif" alt="" class="middle" />'.$this->l('Help').'</legend>
				<b>'.$this->l('@Link:').'</b> <a target="_blank" href="https://www.sofortueberweisung.de/payment/users/register/284">'.$this->l('DIRECTebanking.com').'</a><br />
				'.$this->l('@Vendor:').' Payment Network AG<br />
				'.$this->l('@Author:').' <a target="_blank" href="http://www.touchdesign.de/loesungen/prestashop/sofortueberweisung.htm">touchDesign</a><br />
				<b>'.$this->l('@Description:').'</b><br /><br />
				'.$this->l('DIRECTebanking.com is the direct payment method of Payment Network AG. DIRECTebanking.com allows you to directly and automatically trigger a credit transfer during your online purchase with your online banking information. A transfer order is instantly confirmed to merchant allowing an instant delivery of goods and services.').'
			</fieldset><br />';

		return $this->_html;
	}

	public function hookPayment($params)
	{
		if (!$this->isPayment())
			return false;

		global $smarty;

		$address = new Address(intval($params['cart']->id_address_invoice));
		$customer = new Customer(intval($params['cart']->id_customer));
		$currency = $this->getCurrency();
		$country = new Country(intval($address->id_country));
		$lang = Language::getIsoById(intval($params['cart']->id_lang));

		if (!Configuration::get('SOFORTUEBERWEISUNG_USER_ID'))
			return $this->l($this->displayName.' Error: (invalid or undefined userId)');
		if (!Configuration::get('SOFORTUEBERWEISUNG_PROJECT_ID'))
			return $this->l($this->displayName.' Error: (invalid or undefined projectId)');
		if (!Validate::isLoadedObject($address) 
			|| !Validate::isLoadedObject($customer) 
			|| !Validate::isLoadedObject($currency))
			return $this->l($this->displayName.' Error: (invalid address or customer)');

		$su = array(
			'user_id' => Configuration::get('SOFORTUEBERWEISUNG_USER_ID'),'project_id' => Configuration::get('SOFORTUEBERWEISUNG_PROJECT_ID'),
			'sender_holder' => '','','','sender_country_id' => $country->iso_code,
			'amount' => number_format(Tools::convertPrice($params['cart']->getOrderTotal(), $currency), 2, '.', ''),
			'sender_currency_id' => $currency->iso_code,'reason_1' => $this->l('CartId:').' '.time().'-'.intval($params['cart']->id),
			'reason_2' => $customer->firstname.' '.ucfirst(strtolower($customer->lastname)),
			'user_variable_0' => $customer->secure_key,'user_variable_1' => intval($params['cart']->id),
			'user_variable_2' => '','user_variable_3' => '','user_variable_4' => '','user_variable_5' => '',
			'project_password' => Configuration::get('SOFORTUEBERWEISUNG_PROJECT_PW'),
		);

		$smarty->assign('version',_PS_VERSION_);
		$smarty->assign('hash',sha1(implode('|',$su)));
		$smarty->assign('gateway','https://www.sofortueberweisung.de/payment/start');
		$smarty->assign('lang',$lang);
		$smarty->assign('cprotect',Configuration::get('SOFORTUEBERWEISUNG_CPROTECT'));
		$smarty->assign('su',$su);

		return $this->display(__FILE__, 'sofortueberweisung.tpl');
	}

	public function hookPaymentReturn($params)
	{
		global $smarty;

		if (!$this->isPayment())
			return false;

		$state = $params['objOrder']->getCurrentState();
		if ($state == Configuration::get('SOFORTUEBERWEISUNG_OS_ACCEPTED'))
			$smarty->assign(array(
				'total_to_pay' => Tools::displayPrice($params['total_to_pay'], $params['currencyObj'], false, false),
				'status' => 'accepted'
			)
		);

		return $this->display(__FILE__, 'confirmation.tpl');
	}

	public function hookLeftColumn($params)
	{
		if(Configuration::get('SOFORTUEBERWEISUNG_BLOCK_LOGO') == "N")
			return false;

		return $this->display(__FILE__, 'blocksofortueberweisunglogo.tpl');
	}

	public function isPayment()
	{
		if (!$this->active)
		  return false;

		if (!Configuration::get('SOFORTUEBERWEISUNG_USER_ID') 
			|| !Configuration::get('SOFORTUEBERWEISUNG_PROJECT_ID') 
			|| !Configuration::get('SOFORTUEBERWEISUNG_PROJECT_PW'))
			return false;

		return true;
	}

}

?>