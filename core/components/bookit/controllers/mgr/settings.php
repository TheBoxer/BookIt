<?php
if(!$modx->hasPermission('bookit.settings')) return $modx->error->failure($modx->lexicon('access_denied'));

$modx->regClientStartupScript($bookit->config['jsUrl'].'mgr/widgets/openSchedule/openSchedule.grid.js');

$modx->regClientStartupScript($bookit->config['jsUrl'].'mgr/extra/combo.extra.js');

$modx->regClientStartupScript($bookit->config['jsUrl'].'mgr/widgets/settings/settings.grid.js');
$modx->regClientStartupScript($bookit->config['jsUrl'].'mgr/widgets/items.grid.js');
$modx->regClientStartupScript($bookit->config['jsUrl'].'mgr/widgets/settings.panel.js');
$modx->regClientStartupScript($bookit->config['jsUrl'].'mgr/sections/index.js');


return '<div id="bookit-panel-home-div"></div>';

