<!-- touchDesign | directebanking Module | http://www.touchdesign.de/loesungen/prestashop/sofortueberweisung.htm -->
{capture name=path}{l s='Directebanking payment' mod='sofortueberweisung'}{/capture}
{include file=$tpl_dir./breadcrumb.tpl}

<h2>{l s='Order summary' mod='sofortueberweisung'}</h2>

{assign var='current_step' value='payment'}
{include file=$tpl_dir./order-steps.tpl}

{if $nbProducts <= 0}
  <p class="warning">{l s='Your shopping cart is empty.'}</p>
{else}

<h3>{l s='Directebanking payment' mod='sofortueberweisung'}</h3>

<form action="{$gateway}" method="post">

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

  <p><img src="{$this_path}sofortueberweisung.gif" alt="sofortueberweisung.gif" mod='sofortueberweisung'}" /></p>
  <p>{l s='You have chosen to pay by directebanking.' mod='sofortueberweisung'} {l s='the total amount of your order is' mod='sofortueberweisung'} <span id="amount" class="price">{displayPrice price=$total}</span> {l s='(tax incl.)' mod='sofortueberweisung'}</p>
  <p style="margin-top:20px;"><b>{l s='Please confirm your order by clicking \'I confirm my order\'.' mod='sofortueberweisung'}</b></p>

  <p class="cart_navigation">
    <a href="{$base_dir_ssl}order.php?step=3" class="button_large">{l s='Other payment methods' mod='sofortueberweisung'}</a>
    <input type="submit" name="submit" value="{l s='I confirm my order' mod='sofortueberweisung'}" class="exclusive_large" />
  </p>

</form>
{/if}
<!-- touchDesign | directebanking Module | http://www.touchdesign.de/loesungen/prestashop/sofortueberweisung.htm -->