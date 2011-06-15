<?php
$isLimit = !empty($scriptProperties['limit']);
$start = $modx->getOption('start',$scriptProperties,0);
$limit = $modx->getOption('limit',$scriptProperties,10);
$sort = $modx->getOption('sort',$scriptProperties,'name');
$dir = $modx->getOption('dir',$scriptProperties,'ASC');


/* build query */
$c = $modx->newQuery('OpenScheduleList');
$count = $modx->getCount('OpenScheduleList',$c);

$c->sortby($sort,$dir);

if ($isLimit) $c->limit($limit,$start);
$items = $modx->getIterator('OpenScheduleList', $c);
 
 
/* iterate */
$list = array();
foreach ($items as $item) {
    $itemArray = $item->toArray();
    $list[]= $itemArray;
}
return $this->outputArray($list,$count);