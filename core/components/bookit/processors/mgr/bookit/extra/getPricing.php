<?php           
if((empty($scriptProperties['itemid']) || ($scriptProperties['itemid'] == 0))){
	return null;
}


$item = $modx->getObject('BookItems', $scriptProperties['itemid']);

$c = $modx->newQuery('PricingList'); 

$c->where(array('openschedule_list' => $item->get('openschedule')));

$schedules = $modx->getIterator('PricingList', $c); 

  

/* iterate */

$list = array(); 

foreach ($schedules as $schedule) { 

    $scheduleArray = $schedule->toArray(); 

    $list[]= $scheduleArray; 

} 

return $this->outputArray($list);