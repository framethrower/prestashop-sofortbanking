{**
 * $Id$
 *
 * sofortbanking Module
 *
 * Copyright (c) 2009 touchdesign
 *
 * @category Payment
 * @version 1.2
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
 *}

<!-- touchdesign | sofortbanking Module | http://www.touchdesign.de/loesungen/prestashop/sofortueberweisung.htm -->

{capture name=path}{l s='sofortbanking payment' mod='sofortbanking'}{/capture}
{include file="$tpl_dir./breadcrumb.tpl"}

<h2>{l s='Order summary' mod='sofortbanking'}</h2>

{assign var='current_step' value='payment'}
{include file="$tpl_dir./order-steps.tpl"}

{if $nbProducts <= 0}
  <p class="warning">{l s='Your shopping cart is empty.' mod='sofortbanking'}</p>
{else}

<h3>{l s='sofortbanking payment' mod='sofortbanking'}</h3>

<p>{l s='Please wait a moment, redirect to soforbanking is in progress...' mod='sofortbanking'}</p>

<form action="{$gateway}" method="post" name="mod_sofortbanking" class="hidden">

  <input type="hidden" name="user_id" value="{$parameters.user_id}" />
  <input type="hidden" name="project_id" value="{$parameters.project_id}" />
  <input type="hidden" name="sender_holder" value="{$parameters.sender_holder}" />
  <input type="hidden" name="sender_country_id" value="{$parameters.sender_country_id}" />
  <input type="hidden" name="amount" value="{$parameters.amount}" />
  <input type="hidden" name="sender_currency_id" value="{$parameters.sender_currency_id}" />
  <input type="hidden" name="reason_1" value="{$parameters.reason_1}" />
  <input type="hidden" name="reason_2" value="{$parameters.reason_2}" />
  <input type="hidden" name="user_variable_0" value="{$parameters.user_variable_0}" />
  <input type="hidden" name="user_variable_1" value="{$parameters.user_variable_1}" />
  <input type="hidden" name="user_variable_2" value="{$parameters.user_variable_2}" />
  <input type="hidden" name="user_variable_3" value="{$parameters.user_variable_3}" />
  <input type="hidden" name="user_variable_4" value="{$parameters.user_variable_4}" />
  <input type="hidden" name="user_variable_5" value="{$parameters.user_variable_5}" />
  <input type="hidden" name="hash" value="{$hash}" />
  <input type="hidden" name="interface_version" value="PrestaShop {$version}" />

</form>
{/if}

<script language="JavaScript">
  document.mod_sofortbanking.submit();
</script>

<!-- touchdesign | sofortbanking Module | http://www.touchdesign.de/loesungen/prestashop/sofortueberweisung.htm -->