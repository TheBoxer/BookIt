<?php                   
$c = $modx->newQuery('OpenScheduleList'); 
$schedules = $modx->getIterator('OpenScheduleList', $c); 


/* iterate */

$list = array(); 

foreach ($schedules as $schedule) { 

    $scheduleArray = $schedule->toArray(); 

    $list[]= $scheduleArray; 

} 

return $this->outputArray($list);