<?php
$isLimit = !empty($scriptProperties['limit']);
$start = $modx->getOption('start',$scriptProperties,0);
$limit = $modx->getOption('limit',$scriptProperties,10);
$sort = $modx->getOption('sort',$scriptProperties,'name');
$dir = $modx->getOption('dir',$scriptProperties,'ASC');
 
/* build query */
$c = $modx->newQuery('BookItems');
$count = $modx->getCount('BookItems',$c);
$c->sortby($sort,$dir);
if ($isLimit) $c->limit($limit,$start);
$items = $modx->getIterator('BookItems', $c);
 
/* iterate */
$list = array();
foreach ($items as $item) {
    $itemArray = $item->toArray();
    if(!empty($itemArray['openschedule'])){
    	$os = $modx->getObject('OpenScheduleList', $itemArray['openschedule']);
    	$itemArray['openschedule'] = $os->get('name');
    }
    
    $list[]= $itemArray;
}
return $this->outputArray($list,$count);