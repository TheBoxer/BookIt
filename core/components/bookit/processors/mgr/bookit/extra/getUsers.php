<?php             
$c = $modx->newQuery('modUser');
if($scriptProperties['query'] != ""){
	$c->where(array('Profile.fullname:LIKE' => '%'.$scriptProperties['query'].'%'));
}

$records = $modx->getCollectionGraph('modUser', '{ "Profile":{} }', $c);

$list = array();
foreach ($records as $record) {
	$list[] = array("id" => $record->get('id'), "fullname" => $record->getOne('Profile')->get('fullname'));
}

return $this->outputArray($list);
