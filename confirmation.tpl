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