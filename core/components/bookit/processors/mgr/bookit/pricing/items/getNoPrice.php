<?php

if (empty($scriptProperties['id'])) return $modx->error->failure();

$schedulelist = $modx->getObject('PricingList', $scriptProperties['id']);
$schedulelistId = $schedulelist->get('openschedule_list');

$s = $modx->newQuery('OpenScheduleListItem');
$s->where(array('openschedule_list' => $schedulelistId));

$items = $modx->getIterator('OpenScheduleListItem', $s);

$schedule = array();

foreach ($items as $item){
	$itemArray = $item->toArray();
	$openFromArray = explode(":", $itemArray["openFrom"]);
    $openFromArray[1] = (array_key_exists(1, $openFromArray))? $openFromArray[1] : 0;
    
    $openToArray = explode(":", $itemArray["openTo"]);
    $openToArray[1] = (array_key_exists(1, $openToArray))? $openToArray[1] : 0;
    
    $itemArray["openFrom"] = date("G:i", mktime($openFromArray[0], $openFromArray[1], 0, 0, 0, 0));
    $itemArray["openTo"] = date("G:i", mktime($openToArray[0], $openToArray[1], 0, 0, 0, 0));
    
	$schedule[$itemArray['openDay']][] = array('openFrom' => $itemArray['openFrom'], 'openTo' => $itemArray['openTo']);
}

$d = array( 0 => 'monday', 1 => 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday');

$output = "";

foreach($schedule as $k => $v){
	$output .= '<p>'.$modx->lexicon('bookit.'.$d[$k]) .": ";
	foreach($v as $day){
		$output .= $day['openFrom'].' - '.$day['openTo'].', ';
	}
	$output = substr($output, 0, -2);
	$output .= '</p>';
}

return $modx->error->success('', array('noPrice'=> $output));
