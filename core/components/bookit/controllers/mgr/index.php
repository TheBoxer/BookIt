<?php
$modx->regClientStartupScript($bookit->config['jsUrl'].'mgr/widgets/openSchedule/openSchedule.grid.js');

$modx->regClientStartupScript($bookit->config['jsUrl'].'mgr/extra/combo.extra.js');

$modx->regClientStartupScript($bookit->config['jsUrl'].'mgr/widgets/board.grid.js');
$modx->regClientStartupScript($bookit->config['jsUrl'].'mgr/widgets/items.grid.js');
$modx->regClientStartupScript($bookit->config['jsUrl'].'mgr/widgets/home.panel.js');
$modx->regClientStartupScript($bookit->config['jsUrl'].'mgr/sections/index.js');


return '<div id="bookit-panel-home-div"></div>';

