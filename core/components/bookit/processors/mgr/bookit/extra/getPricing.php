<?php                   
ChromePhp::warn($scriptProperties);


if((empty($scriptProperties['id']) || ($scriptProperties['id'] == 0))){
	//return null;
}


$c = $modx->newQuery('PricingList'); 

//$c->where(array('openschedule_list' => $scriptProperties['id']));

$schedules = $modx->getIterator('PricingList', $c); 

  

/* iterate */

$list = array(); 

foreach ($schedules as $schedule) { 

    $scheduleArray = $schedule->toArray(); 

    $list[]= $scheduleArray; 

} 

return $this->outputArray($list);