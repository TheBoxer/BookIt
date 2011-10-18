<?php                   
$c = $modx->newQuery('BookItems'); 
$items = $modx->getIterator('BookItems', $c); 

  

/* iterate */

$list = array(); 

foreach ($items as $item) { 

    $itemArray = $item->toArray(); 

    $list[]= $itemArray; 

} 

return $this->outputArray($list);