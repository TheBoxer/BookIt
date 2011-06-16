<?php
$modx->regClientStartupScript($bookit->config['jsUrl'].'mgr/sections/pricingItems.js');
$modx->regClientStartupScript($bookit->config['jsUrl'].'mgr/extra/combo.extra.js');

$modx->regClientStartupScript($bookit->config['jsUrl'].'mgr/widgets/pricing/items/pricingItems.panel.js');

$modx->regClientStartupScript($bookit->config['jsUrl'].'mgr/widgets/pricing/items/pricingItems.grid.js');


return '<div id="bookit-panel-pricing-items-div"></div>';

