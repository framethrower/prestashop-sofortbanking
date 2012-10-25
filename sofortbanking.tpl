{**
 * $Id$
 *
 * sofortbanking Module
 *
 * Copyright (c) 2009 touchdesign
 *
 * @category Payment
 * @version 1.4
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
<p class="payment_module">
  <a href="{$this_path_ssl}payment.php" title="{l s='Pay with sofortbanking' mod='sofortbanking'}">
  {if $cprotect == "Y"}
    <img style="float:left" src="{$module_template_dir}img/banner_400x100_ks.png" alt="sofortbanking.png" title="{l s='Buy secure with customer protection by sofortbanking' mod='sofortbanking'}" width="400" height="100" />
  {else}
    <img style="float:left" src="{$module_template_dir}img/banner_300x100.png" alt="sofortbanking.png" title="{l s='Pay with sofortbanking' mod='sofortbanking'}"  width="300" height="100" />
  {/if}
  <br class="clear" />
  </a>
</p>
<!-- touchdesign | sofortbanking Module | http://www.touchdesign.de/loesungen/prestashop/sofortueberweisung.htm -->