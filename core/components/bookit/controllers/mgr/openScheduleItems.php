<?php
$modx->regClientStartupScript($bookit->config['jsUrl'].'mgr/sections/openSchedule.js');
$modx->regClientStartupScript($bookit->config['jsUrl'].'mgr/extra/combo.extra.js');

$modx->regClientStartupScript($bookit->config['jsUrl'].'mgr/widgets/openSchedule/items/openScheduleItems.panel.js');

$modx->regClientStartupScript($bookit->config['jsUrl'].'mgr/widgets/openSchedule/items/openScheduleItems.grid.js');





 
return '<div id="bookit-panel-openschedule-items-div"></div>';

