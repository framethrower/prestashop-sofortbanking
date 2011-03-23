{**
 * $Id$
 *
 * sofortueberweisung Module
 *
 * Copyright (c) 2009 touchDesign
 *
 * @category Payment
 * @version 0.8
 * @copyright 19.08.2009, touchDesign
 * @author Christoph Gruber, <www.touchdesign.de>
 * @link http://www.touchdesign.de/loesungen/prestashop/sofortueberweisung.htm
 * @link http://www.homepage-community.de/index.php?topic=555.0
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

<!-- touchDesign | directebanking Module | http://www.touchdesign.de/loesungen/prestashop/sofortueberweisung.htm -->
<p class="payment_module">
  <a style="height:69px" href="{$this_path_ssl}payment.php" title="{l s='Pay with sofortueberweisung.de' mod='sofortueberweisung'}">
  {if $cprotect == "Y"}
    <img style="float:left" src="{$module_template_dir}sofortueberweisungk_banner_{if $lang == "de"}de{else}en{/if}.jpg" alt="" title="{l s='Buy secure with customer protection by Sofort Bank' mod='sofortueberweisung'}" width="250" height="69" />
    {l s='Pay with sofortueberweisung.de' mod='sofortueberweisung'}
  {else}
    <img style="float:left" src="{$module_template_dir}sofortueberweisung.gif" alt="" title="{l s='Pay with sofortueberweisung.de' mod='sofortueberweisung'}" width="86" height="49" />
    {l s='Pay with sofortueberweisung.de' mod='sofortueberweisung'}
  {/if}
  </a>
</p>
<!-- touchDesign | directebanking Module | http://www.touchdesign.de/loesungen/prestashop/sofortueberweisung.htm -->