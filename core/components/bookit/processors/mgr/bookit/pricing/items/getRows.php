<?php
$isLimit = !empty($scriptProperties['limit']);
$start = $modx->getOption('start',$scriptProperties,0);
$limit = $modx->getOption('limit',$scriptProperties,10);
$sort = $modx->getOption('sort',$scriptProperties,'priceDay');
$dir = $modx->getOption('dir',$scriptProperties,'ASC');

$filterDay = $modx->getOption('filterDay',$scriptProperties,'');

/* build query */
$c = $modx->newQuery('PricingListItem');
$count = $modx->getCount('PricingListItem',$c);

$c->where(array('pricing_list' => $scriptProperties['pricing_list']));

if ($filterDay != NULL) {
    $c->where(array(
        'PRICEDay' => $filterDay
    ));
}

$c->sortby($sort,$dir);
$c->sortby("priceFrom",$dir);

if ($isLimit) $c->limit($limit,$start);
$items = $modx->getIterator('PricingListItem', $c);
 
 
/* iterate */
$list = array();
foreach ($items as $item) {
    $itemArray = $item->toArray();

    $priceFromArray = explode(":", $itemArray["priceFrom"]);
    $priceFromArray[1] = (array_key_exists(1, $priceFromArray))? $priceFromArray[1] : 0;
    
    $priceToArray = explode(":", $itemArray["priceTo"]);
    $priceToArray[1] = (array_key_exists(1, $priceToArray))? $priceToArray[1] : 0;
    
    $itemArray["priceFrom"] = date("G:i", mktime($priceFromArray[0], $priceFromArray[1], 0, 0, 0, 0));
    $itemArray["priceTo"] = date("G:i", mktime($priceToArray[0], $priceToArray[1], 0, 0, 0, 0));
    $list[]= $itemArray;
}
return $this->outputArray($list,$count);