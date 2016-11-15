{**
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
 *}

{literal}
<style type="text/css">
fieldset a {
    color:#0099ff !important;
    text-decoration:underline;
}
fieldset a:hover {
    color:#000000;
    text-decoration:underline;
}
.level1 {
    font-size:1.2em
}
.level2 {
    font-size:0.9em
}
</style>
{/literal}

<div><img src="{$sofort.dfl.mod_lang.logo|escape:'htmlall':'UTF-8'}" alt="200x75.png" width="200" height="75" title="" /></div>
<form method="post" action="{$sofort.dfl.action|escape:'htmlall':'UTF-8'}">
<br />

<fieldset class="level1">
<legend><img src="{$sofort.dfl.path|escape:'htmlall':'UTF-8'}/logo.gif" width="16" height="16" alt="logo.gif" title="" />{l s='Over SOFORT Banking' mod='sofortbanking'}</legend>
    <b>{l s='SOFORT Banking is the direct payment method of SOFORT AG. SOFORT Banking allows the buyer to directly and automatically trigger a credit transfer during his online purchase with them online banking information. A transfer order is instantly confirmed to merchant allowing an instant delivery of goods and services. So you can send stock items and digital goods immediately - you will receive your purchases quickly. More about SOFORT Banking and SOFORT AG' mod='sofortbanking'}</b> <a target="_blank" href="https://sofort.com/"><b>{l s='sofort.com.' mod='sofortbanking'}</b></a><br />
</fieldset>
<br />

<fieldset class="level1">
    <legend><img src="{$sofort.dfl.path|escape:'htmlall':'UTF-8'}/logo.gif" width="16" height="16" alt="logo.gif" title="" />{l s='Setup and Configuration' mod='sofortbanking'}</legend>
    <b>{l s='To use SOFORT Banking a few steps are necessary:' mod='sofortbanking'}</b><br /><br />
    <fieldset class="level2">
        <legend><img src="{$sofort.dfl.img_path|escape:'htmlall':'UTF-8'}/step_1.png" width="16" height="16" alt="unknown.gif" title="">{l s='Registration' mod='sofortbanking'}</legend>
        <b>{l s='In order to offer SOFORT Banking you need a customer account with the SOFORT AG. You are not a customer?' mod='sofortbanking'}</b>
        <a target="_blank" href="https://www.sofortueberweisung.de/payment/users/register/284"><b>{l s='Register now!' mod='sofortbanking'}</b></a><br />
    </fieldset>
    <br />
    
    <fieldset class="level2">
        <legend><img src="{$sofort.dfl.img_path|escape:'htmlall':'UTF-8'}/step_3.png" width="16" height="16" alt="step_3.png" title="">{l s='Module configuration' mod='sofortbanking'}</legend>
        <b>{l s='Please leave your SOFORT-Project data and passwords in the fields below:' mod='sofortbanking'}</b><br /><br />
        <label>{l s='User ID?' mod='sofortbanking'}</label>
        <div class="margin-form">
            <input type="text" name="SOFORTBANKING_USER_ID" value="{$sofort.config.SOFORTBANKING_USER_ID|escape:'htmlall':'UTF-8'}" />
            <p>{l s='Leave it blank for disabling' mod='sofortbanking'}</p>
        </div>
        <div class="clear"></div>
        <label>{l s='Project ID?' mod='sofortbanking'}</label>
        <div class="margin-form">
            <input type="text" name="SOFORTBANKING_PROJECT_ID" value="{$sofort.config.SOFORTBANKING_PROJECT_ID|escape:'htmlall':'UTF-8'}" />
            <p>{l s='Leave it blank for disabling' mod='sofortbanking'}</p>
        </div>
        <div class="clear"></div>
        <label>{l s='API Key?' mod='sofortbanking'}</label>
        <div class="margin-form">
            <input type="password" name="SOFORTBANKING_API_KEY" value="{$sofort.config.SOFORTBANKING_API_KEY|escape:'htmlall':'UTF-8'}" />
            <p>{l s='Leave it blank for disabling' mod='sofortbanking'}</p>
        </div>
        <div class="clear"></div>
        <label>{l s='Order accepted status' mod='sofortbanking'}</label>
        <div class="margin-form">
            <select name="SOFORTBANKING_OS_ACCEPTED">
                {$sofort.order_states.accepted|escape:'UTF-8'}
            </select> <input type="checkbox" name="SOFORTBANKING_OS_ACCEPTED_IGNORE" {if $sofort.config.SOFORTBANKING_OS_ACCEPTED_IGNORE == "Y"}checked="checked"{/if} value="Y" /> {l s='No status update for this event' mod='sofortbanking'}<br />
            <br />
            <p>{l s='Order state for accepted payments' mod='sofortbanking'}</p>
        </div>
        <div class="clear"></div>
        <label>{l s='Order error status' mod='sofortbanking'}</label>
        <div class="margin-form">
            <select name="SOFORTBANKING_OS_ERROR">
                {$sofort.order_states.error|escape:'UTF-8'}
            </select> <input type="checkbox" name="SOFORTBANKING_OS_ERROR_IGNORE" {if $sofort.config.SOFORTBANKING_OS_ERROR_IGNORE == "Y"}checked="checked"{/if} value="Y" /> {l s='No status update for this event' mod='sofortbanking'}<br />
            <br />
            <p>{l s='Order state for failed payments' mod='sofortbanking'}</p>
        </div>
        <div class="clear"></div>
        <label>{l s='sofortbanking Logo?' mod='sofortbanking'}</label>
        <div class="margin-form">
            <select name="SOFORTBANKING_BLOCK_LOGO">
                <option {if $sofort.config.SOFORTBANKING_BLOCK_LOGO == "Y"}selected{/if} value="Y">{l s='Yes, display the logo (recommended)' mod='sofortbanking'}</option>
                <option {if $sofort.config.SOFORTBANKING_BLOCK_LOGO == "N"}selected{/if} value="N">{l s='No, do not display' mod='sofortbanking'}</option>
            </select>
            <p>{l s='Display logo and payment info block in left column' mod='sofortbanking'}</p>
        </div>
        <div class="clear"></div>
        <div class="margin-form clear pspace"><input type="submit" name="submitUpdate" value="{l s='Save' mod='sofortbanking'}" class="button" /></div>
    </fieldset>
</fieldset>
</form>
<br />

<fieldset class="level1 space">
    <legend><img src="{$sofort.dfl.path|escape:'htmlall':'UTF-8'}/logo.gif" width="16" height="16" alt="logo.gif" title="" />{l s='Help' mod='sofortbanking'}</legend>
    <b>{l s='For detailed instructions, please visit our' mod='sofortbanking'}</b> <a target="_blank" href="https://www.sofort.com/integrationCenter-ger-DE/integration/shopsysteme/PrestaShop/"><b>{l s='Website' mod='sofortbanking'}</b></a>.<br /><br />
    <b>{l s='We can assist you when ordering. Simply contact our' mod='sofortbanking'}</b> <a target="_blank" href="https://addons.prestashop.com/de/Write-to-developper?id_product=9176"><b>{l s='Support.' mod='sofortbanking'}</b></a><br />
</fieldset>
<br />

<fieldset class="level1">
    <legend><img src="../img/admin/unknown.gif" width="16" height="16" alt="unknown.gif" title="" />{l s='Author and Copyright:' mod='sofortbanking'}</legend>
    <a target="_blank" href="http://www.touchdesign.de"><b>touchdesign</b></a><br />
</fieldset>