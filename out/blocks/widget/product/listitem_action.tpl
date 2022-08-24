<div class="title">
    [{if $product->action }]
        <span class="text-danger">+++ [{$product->action}] +++</span><br>
    [{/if}]
    <a id="[{$testid}]" href="[{$_productLink}]" title="[{$product->oxarticles__oxtitle->value}] [{$product->oxarticles__oxvarselect->value}]">[{$product->oxarticles__oxtitle->value}] [{$product->oxarticles__oxvarselect->value}]</a>
</div>
