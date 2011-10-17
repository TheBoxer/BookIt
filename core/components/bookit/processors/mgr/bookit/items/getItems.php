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
    	$itemArray['openschedule_label'] = $os->get('name');
    	
    	if(!empty($itemArray['pricing'])){
    		$pr = $modx->getObject('PricingList', $itemArray['pricing']);
    		$itemArray['pricing_label'] = $pr->get('name');
    	}else{
    		$itemArray['pricing_label'] = "";
    	}
    	
    }else{
    	$itemArray['openschedule_label'] = "";
    }
    
    
    
    $list[]= $itemArray;
}
return $this->outputArray($list,$count);