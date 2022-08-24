[{if $Action }]
<div class="row pb-3">
                <div class="col-12">
                        <div class="card">
                                <div class="card-body">
                                        <h2 class="text-danger">+++ [{ $Action.title }] +++</h2>
                                        <p class="text-info h4">[{ $Action.longdesc }]</p>
                                        [{if $Action.timeleft > 0}]
					        <p class="text-success h5">[{oxmultilang ident="ACTION_LIFETIME" }] [{ $Action.timeleft }] [{if $Action.timeleft > 1}][{oxmultilang ident="DAYS"}][{else}][{oxmultilang ident="DAY"}][{/if}].</p>
                                        [{/if}]
                                </div>
                        </div>
                </div>
</div>
[{/if}]
