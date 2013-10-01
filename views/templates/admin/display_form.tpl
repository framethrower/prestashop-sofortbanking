{literal}
<style type="text/css">
fieldset a {
	color:#0099ff;
	text-decoration:underline;"
}
fieldset a:hover {
	color:#000000;
	text-decoration:underline;"
}
</style>
{/literal}

<div><img src="{$sofort.dfl.img_path}/sofortbanking.png" width="200" height="75" alt="sofortbanking.png" title="" /></div>
<form method="post" action="{$sofort.dfl.action}">
<fieldset>
    <legend><img src="{$sofort.dfl.path}/logo.gif" width="16" height="16" alt="logo.gif" title="" />{l s='Settings'}</legend>
    <label>{l s='sofortbanking user ID?'}</label>
    <div class="margin-form">
        <input type="text" name="SOFORTBANKING_USER_ID" value="{$sofort.config.SOFORTBANKING_USER_ID}" />
        <p>{l s='Leave it blank for disabling'}</p>
    </div>
    <div class="clear"></div>
    <label>{l s='sofortbanking project ID?'}</label>
    <div class="margin-form">
        <input type="text" name="SOFORTBANKING_PROJECT_ID" value="{$sofort.config.SOFORTBANKING_PROJECT_ID}" />
        <p>{l s='Leave it blank for disabling'}</p>
    </div>
    <div class="clear"></div>
    <label>{l s='sofortbanking project password?'}</label>
    <div class="margin-form">
        <input type="password" name="SOFORTBANKING_PROJECT_PW" value="{$sofort.config.SOFORTBANKING_PROJECT_PW}" />
        <p>{l s='Leave it blank for disabling'}</p>
    </div>
    <div class="clear"></div>
    <label>{l s='sofortbanking notify password?'}</label>
    <div class="margin-form">
        <input type="password" name="SOFORTBANKING_NOTIFY_PW" value="{$sofort.config.SOFORTBANKING_NOTIFY_PW}" />
        <p>{l s='Leave it blank for disabling'}</p>
    </div>
    <div class="clear"></div>
    <label>{l s='sofortbanking Logo?'}</label>
    <div class="margin-form">
        <select name="SOFORTBANKING_BLOCK_LOGO">
            <option {if $sofort.config.SOFORTBANKING_BLOCK_LOGO == "Y"}selected{/if} value="Y">{l s='Yes, display the logo (recommended)'}</option>
            <option {if $sofort.config.SOFORTBANKING_BLOCK_LOGO == "N"}selected{/if} value="N">{l s='No, do not display'}</option>
        </select>
        <p>{l s='Display logo and payment info block in left column'}</p>
    </div>
    <div class="clear"></div>
    <label>{l s='Customer protection active:'}</label>
    <div class="margin-form">
        <select name="SOFORTBANKING_CPROTECT">
            <option {if $sofort.config.SOFORTBANKING_CPROTECT == "Y"}selected{/if} value="Y">{l s='Yes'}</option>
            <option {if $sofort.config.SOFORTBANKING_CPROTECT == "N"}selected{/if} value="N">{l s='No'}</option>
        </select>
        <p>
            {l s='You need a bank account with'}
            <a target="_blank" href="http://www.sofort-bank.com" target="_blank">Sofort Bank</a>
            {l s='You need a bank account with and customer protection must be enabled in your project settings. Please check with'}
            <a target="_blank" href="https://kaeuferschutz.sofort-bank.com/consumerProtections/index/{$sofort.config.SOFORTBANKING_PROJECT_ID}">{l s='this link'}</a>
            {l s='if customer protection is activated and enabled before enabling it here.'}
        </p>
    </div>
    <div class="clear"></div>
    <label>{l s='Force redirect?'}</label>
    <div class="margin-form">
        <select name="SOFORTBANKING_REDIRECT">
            <option {if $sofort.config.SOFORTBANKING_REDIRECT == "Y"}selected{/if} value="Y">{l s='Yes, force redirect.'}</option>
            <option {if $sofort.config.SOFORTBANKING_REDIRECT == "N"}selected{/if} value="N">{l s='No, let the customer confirm the order first.'}</option>
        </select>
        <p>{l s='Force redirect to soforbanking payment page (skip confirm page).'}</p>
    </div>
    <div class="clear"></div>
    <div class="margin-form clear pspace"><input type="submit" name="submitUpdate" value="{l s='Update'}" class="button" /></div>
</fieldset>
</form><br />

<fieldset>
    <legend><img src="{$sofort.dfl.path}/logo.gif" width="16" height="16" alt="logo.gif" title="" />{l s='URLs'}</legend>
    <b>{l s='Confirmation-Url:'} {l s='(Method POST)'}</b><br /><textarea rows=1 style="width:98%;">{$sofort.link.validation}</textarea>
    <br /><br />
    <b>{l s='Success-Url:'}</b><br /><textarea rows=1 style="width:98%;">{$sofort.link.success}</textarea>
    <br /><br />
    <b>{l s='Cancel-Url:'}</b><br /><textarea rows=1 style="width:98%;">{$sofort.link.cancellation}</textarea>
</fieldset>

<fieldset class="space">
	<legend><img src="../img/admin/unknown.gif" width="16" height="16" alt="unknown.gif" title="" />{l s='Help'}</legend>
	<b>{l s='@Link:'}</b> <a target="_blank" href="http://www.touchdesign.de/ico/paymentnetwork.htm">{l s='sofortbanking.com'}</a><br />
	{l s='@Author and Copyright:'} <a target="_blank" href="http://www.touchdesign.de/loesungen/prestashop/sofortueberweisung.htm">touchdesign</a><br />
	<b>{l s='@Description:'}</b><br /><br />
	{l s='sofortbanking is the direct payment method of Payment Network AG. sofortbanking allows you to directly and automatically trigger a credit transfer during your online purchase with your online banking information. A transfer order is instantly confirmed to merchant allowing an instant delivery of goods and services.'}
</fieldset><br />