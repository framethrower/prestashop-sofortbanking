<!-- touchDesign | directebanking Module | http://www.touchdesign.de/loesungen/prestashop/sofortueberweisung.htm -->
<p class="payment_module">
	<a style="height:69px" href="javascript:$('#sofortueberweisung_form').submit();" title="{l s='Pay with sofortueberweisung.de' mod='sofortueberweisung'}">
	{if $cprotect == "Y"}
		<img style="float:left" src="{$module_template_dir}sofortueberweisungk_banner_{if $lang == "de"}de{else}en{/if}.jpg" alt="" title="{l s='Buy secure with customer protection by Sofort Bank' mod='sofortueberweisung'}" width="250" height="69" />
		{l s='Pay with sofortueberweisung.de' mod='sofortueberweisung'}
	{else}
		<img style="float:left" src="{$module_template_dir}sofortueberweisung.gif" alt="" title="{l s='Pay with sofortueberweisung.de' mod='sofortueberweisung'}" width="86" height="49" />
		{l s='Pay with sofortueberweisung.de' mod='sofortueberweisung'}
	{/if}
	</a>
</p>
<form method="post" action="{$gateway}" id="sofortueberweisung_form" class="hidden">
  <input type="hidden" name="user_id" value="{$su.user_id}" />
  <input type="hidden" name="project_id" value="{$su.project_id}" />
  <input type="hidden" name="sender_holder" value="{$su.sender_holder}" />
  <input type="hidden" name="sender_country_id" value="{$su.sender_country_id}" />
  <input type="hidden" name="amount" value="{$su.amount}" />
  <input type="hidden" name="sender_currency_id" value="{$su.sender_currency_id}" />
  <input type="hidden" name="reason_1" value="{$su.reason_1}" />
  <input type="hidden" name="reason_2" value="{$su.reason_2}" />
  <input type="hidden" name="user_variable_0" value="{$su.user_variable_0}" />
  <input type="hidden" name="user_variable_1" value="{$su.user_variable_1}" />
  <input type="hidden" name="user_variable_2" value="{$su.user_variable_2}" />
  <input type="hidden" name="user_variable_3" value="{$su.user_variable_3}" />
  <input type="hidden" name="user_variable_4" value="{$su.user_variable_4}" />
  <input type="hidden" name="user_variable_5" value="{$su.user_variable_5}" />
  <input type="hidden" name="hash" value="{$hash}" />
  <input type="hidden" name="interface_version" value="PrestaShop {$version}" />
</form>
<!-- touchDesign | directebanking Module | http://www.touchdesign.de/loesungen/prestashop/sofortueberweisung.htm -->