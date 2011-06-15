<?php
$modx->regClientStartupScript($bookit->config['jsUrl'].'mgr/sections/openSchedule.js');
$modx->regClientStartupScript($bookit->config['jsUrl'].'mgr/extra/combo.extra.js');

$modx->regClientStartupScript($bookit->config['jsUrl'].'mgr/widgets/openSchedule.panel.js');

$modx->regClientStartupScript($bookit->config['jsUrl'].'mgr/widgets/openSchedule.grid.js');
$modx->regClientStartupScript($bookit->config['jsUrl'].'mgr/widgets/openSchedule.pricing.grid.js');




 
return '<div id="bookit-panel-openschedule-div"></div>';

