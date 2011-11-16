<?php
if ((empty($scriptProperties['id'])) && ((empty($scriptProperties['date'])) || (empty($scriptProperties['time'])) || (empty($scriptProperties['colName'])))) return $modx->error->failure($modx->lexicon('bookit.error_no_item'));

if($scriptProperties['id'] > 0){
	$item = $modx->getObject('Books',$scriptProperties['id']);
}else{
	$itemid = explode("-", $scriptProperties["colName"]);
	$itemid = $itemid[1];
	
	$time = explode(":", $scriptProperties["time"]);
	$time = $time[0];
	
	$date = (isset($scriptProperties["date"]))? strtotime($scriptProperties["date"]) : mktime(0,0,0,date("n"),date("j"),date("Y"));
	
	$where = array("idItem" => $itemid, "bookFrom" => $time, "bookDate" => $date); 
	
	$item = $modx->getObject("Books", $where);
}

if (empty($item)) return $modx->error->failure($modx->lexicon('bookit.error_no_item'));
 
if ($item->remove() == false) {
    return $modx->error->failure($modx->lexicon('bookit.error_remove'));
}
 
return $modx->error->success('',$item);