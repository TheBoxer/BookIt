<?php
include 'D:/Web/www/modx/bookit/ChromePhp.php';
ChromePhp::useFile('D:/Web/www/modx/chromelog', 'http://modx.localhost/chromelog');

$c = $modx->newQuery('BookItems');
$c->where(array('active'=>1));
$items = $modx->getIterator('BookItems', $c);
$fields = "";
$columns = "";
foreach ($items as $item) {
    $itemArray = $item->toArray(); 
    $fields .= "'item-".$itemArray["id"]."', ";
    $columns .= "{header: '".$itemArray["name"]."',dataIndex: 'item-".$itemArray["id"]."'},";
}

$fields = substr($fields, 0, -2);
$columns = substr($columns, 0, -1);



$modx->regClientStartupScript("<script type=\"text/javascript\">

var boarderFields = ['id', 'time', ".$fields."]

var columns = [{header: _('bookit.time'),dataIndex: 'time'},".$columns."]

</script>", 1);

$modx->regClientStartupScript($bookit->config['jsUrl'].'mgr/widgets/openSchedule/openSchedule.grid.js');

$modx->regClientStartupScript($bookit->config['jsUrl'].'mgr/extra/combo.extra.js');

$modx->regClientStartupScript($bookit->config['jsUrl'].'mgr/widgets/board.grid.js');
$modx->regClientStartupScript($bookit->config['jsUrl'].'mgr/widgets/items.grid.js');
$modx->regClientStartupScript($bookit->config['jsUrl'].'mgr/widgets/home.panel.js');
$modx->regClientStartupScript($bookit->config['jsUrl'].'mgr/sections/index.js');


return '<div id="bookit-panel-home-div"></div>';

