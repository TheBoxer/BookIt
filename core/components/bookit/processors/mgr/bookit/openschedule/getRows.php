<?php
$isLimit = !empty($scriptProperties['limit']);
$start = $modx->getOption('start',$scriptProperties,0);
$limit = $modx->getOption('limit',$scriptProperties,10);
$sort = $modx->getOption('sort',$scriptProperties,'openDay');
$dir = $modx->getOption('dir',$scriptProperties,'ASC');


$filterDay = $modx->getOption('filterDay',$scriptProperties,'');
 
/* build query */
$c = $modx->newQuery('BookItemsOpen');
$count = $modx->getCount('BookItemsOpen',$c);
$c->where(array("idItem" => $scriptProperties['idItem']));

if ($filterDay != NULL) {
    $c->where(array(
        'openDay' => $filterDay
    ));
}

$c->sortby($sort,$dir);
$c->sortby("openFrom",$dir);

if ($isLimit) $c->limit($limit,$start);
$items = $modx->getIterator('BookItemsOpen', $c);
 
 
/* iterate */
$list = array();
foreach ($items as $item) {
    $itemArray = $item->toArray();

    $openFromArray = explode(":", $itemArray["openFrom"]);
    $openFromArray[1] = (array_key_exists(1, $openFromArray))? $openFromArray[1] : 0;
    
    $openToArray = explode(":", $itemArray["openTo"]);
    $openToArray[1] = (array_key_exists(1, $openToArray))? $openToArray[1] : 0;
    
    $itemArray["openFrom"] = date("G:i", mktime($openFromArray[0], $openFromArray[1], 0, 0, 0, 0));
    $itemArray["openTo"] = date("G:i", mktime($openToArray[0], $openToArray[1], 0, 0, 0, 0));
    $list[]= $itemArray;
}
return $this->outputArray($list,$count);