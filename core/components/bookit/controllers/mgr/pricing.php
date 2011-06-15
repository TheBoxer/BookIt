<?php
$modx->regClientStartupScript($bookit->config['jsUrl'].'mgr/sections/pricing.js');
$modx->regClientStartupScript($bookit->config['jsUrl'].'mgr/extra/combo.extra.js');

$modx->regClientStartupScript($bookit->config['jsUrl'].'mgr/widgets/pricing/pricing.panel.js');

$modx->regClientStartupScript($bookit->config['jsUrl'].'mgr/widgets/pricing/pricing.grid.js');

return '<div id="bookit-panel-pricing-div"></div>';

