<?php
$c = $modx->newQuery('OpenScheduleListItem');
$c->select('MIN(openFrom) AS openFromMin');
$c->select('MAX(openTo) AS openToMax');
$c->prepare();
$item = $modx->getObject('OpenScheduleListItem', $c);

$openFrom = explode(":", $item->get('openFromMin'));
$openFrom = (int) $openFrom[0];
$openTo = explode(":", $item->get('openToMax'));
$openTo = (int) $openTo[0];

$board = array();

for($i = $openFrom; $i < $openTo; $i++){
	$board[$i] = array();
}

$c = $modx->newQuery('Books');
if(isset($scriptProperties["filterDay"])){
	$c->where(array("bookDate" => strtotime($scriptProperties["filterDay"])));
}else{
	$c->where(array("bookDate" => mktime(0,0,0,date("n"),date("j"),date("Y"))));	
}


$items = $modx->getIterator('Books', $c);
 
foreach ($items as $item) {
    $itemArray = $item->toArray(); 
    $user = $modx->getObject('modUser', $itemArray["idUser"]);
    $color = ($itemArray["paid"] == false)? "red" : "green";
    $board[$itemArray["bookFrom"]] = array_merge($board[$itemArray["bookFrom"]], array("item-".$itemArray["idItem"] => "<span class=\"$color\">".$user->getOne("Profile")->get("fullname")."</span>"));
}

$retBoard = array();
foreach($board as $k => $v){
	$temp = array("time" => $k.":00");
	$retBoard[] = array_merge($temp, $v);
}

return $this->outputArray($retBoard,count($retBoard));
