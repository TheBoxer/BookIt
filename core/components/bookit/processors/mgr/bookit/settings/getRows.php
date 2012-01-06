<?php
$isLimit = !empty($scriptProperties['limit']);
$start = $modx->getOption('start',$scriptProperties,0);
$limit = $modx->getOption('limit',$scriptProperties,10);
$sort = $modx->getOption('sort',$scriptProperties,'key');
$dir = $modx->getOption('dir',$scriptProperties,'ASC');


/* build query */
$c = $modx->newQuery('BookItSettigns');
$count = $modx->getCount('BookItSettigns',$c);


if ($isLimit) $c->limit($limit,$start);
$items = $modx->getIterator('BookItSettigns', $c);

 
/* iterate */
$list = array();
foreach ($items as $item) {
    $itemArray = $item->toArray();
    $list[]= $itemArray;
}
return $this->outputArray($list,$count);