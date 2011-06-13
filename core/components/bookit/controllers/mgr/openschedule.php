<?php
$modx->regClientStartupScript($bookit->config['jsUrl'].'mgr/sections/openschedule.js');
$modx->regClientStartupScript($bookit->config['jsUrl'].'mgr/extra/combo.extra.js');

$modx->regClientStartupScript($bookit->config['jsUrl'].'mgr/widgets/openschedule.panel.js');

$modx->regClientStartupScript($bookit->config['jsUrl'].'mgr/widgets/openschedule.grid.js');





 
return '<div id="bookit-panel-openschedule-div"></div>';

