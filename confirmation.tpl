{**
 * $Id$
 *
 * sofortueberweisung Module
 *
 * Copyright (c) 2009 touchDesign
 *
 * @category Payment
 * @version 0.9
 * @copyright 19.08.2009, touchDesign
 * @author Christoph Gruber, <www.touchdesign.de>
 * @link http://www.touchdesign.de/loesungen/prestashop/sofortueberweisung.htm
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 *
 * Description:
 *
 * Payment module directebanking
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

<!-- directebanking module | http://www.touchdesign.de/loesungen/prestashop/sofortueberweisung.htm -->
{if $status == 'accepted' || $status == 'pending'}
  <p>
    {l s='Your order on' mod='sofortueberweisung'} <span class="bold">{$shop_name}</span> {l s='is complete.' mod='sofortueberweisung'}
    <br /><br />
    {l s='The total amount of this order is' mod='sofortueberweisung'} <span class="price">{$total_to_pay}</span>
  </p>
{else}
  <p class="warning">
    {l s='We noticed a problem with your order. If you think this is an error, you can contact our' mod='sofortueberweisung'} 
    <a href="{$base_dir_ssl}contact-form.php">{l s='customer support' mod='sofortueberweisung'}</a>.
  </p>
{/if}
<!-- directebanking module | http://www.touchdesign.de/loesungen/prestashop/sofortueberweisung.htm -->