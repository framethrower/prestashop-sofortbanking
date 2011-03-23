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