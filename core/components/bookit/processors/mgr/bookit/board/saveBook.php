<?php
if(empty($scriptProperties["user"])){
	$modx->error->addField('user', $modx->lexicon('bookit.error_no_user'));
}
if(empty($scriptProperties["phone"])){
	$modx->error->addField('phone', $modx->lexicon('bookit.error_no_phone'));
}

$date = (!empty($scriptProperties["date"]))? strtotime($scriptProperties["date"]) : mktime(0,0,0,date("n"),date("j"),date("Y"));
$time = explode(":", $scriptProperties["time"]);
$time = $time[0];

$range = range($time, $time-1+$scriptProperties["count"]);

$oldBooks = $modx->newQuery('Books');
$oldBooks->where(array(
		"bookDate" => $date,
		"idItem" => $scriptProperties["items"],
		"bookFrom:IN" => $range
		));

$oldBooksCollection = $modx->getCollection('Books', $oldBooks);
if(count($oldBooksCollection) != 0){
	$modx->error->addField('date', $modx->lexicon('bookit.error_date_time_occupied'));
	$modx->error->addField('time', $modx->lexicon('bookit.error_date_time_occupied'));
	$modx->error->addField('count', $modx->lexicon('bookit.error_date_time_occupied'));
	$modx->error->addField('sliderCount', $modx->lexicon('bookit.error_date_time_occupied'));
}

if ($modx->error->hasError()) {
	return $modx->error->failure();
}

if(intval($scriptProperties["user"]) == 0){
	$username = str_replace(" ", ".", trim(strtolower($modx->translit->translate($scriptProperties["user"], "noaccents"))));
	
	$user = $modx->getObject("modUser", array("username" => $username));

	while(!empty($user)){
		$username = $username . rand(111,999);
		$user = $modx->getObject("modUser", array("username" => $username));
	}
	
	$email = (empty($email)) ? "anonym@tenistop.cz" : $scriptProperties["email"];
	
	$newUser = $modx->newObject('modUser');
	$newUser->set("username", $username);
	$newUser->set("password", $username.rand(11111,99999).$username);
	$newUser->set("active", 0);
	
	$newUserProfile = $modx->newObject('modUserProfile');
	$newUserProfile->set('fullname',$scriptProperties["user"]);
	$newUserProfile->set('email',$email);
	$newUserProfile->set('mobilephone', $scriptProperties["phone"]);
	
	$success = $newUser->addOne($newUserProfile);
	if($success){
		$newUser->save();
	}else{
		return $modx->error->failure();
	}
}

$max = $time+$scriptProperties["count"];
$uid = (intval($scriptProperties["user"]) == 0) ? $newUser->get('id') : intval($scriptProperties["user"]);

for($i = $time; $i < $max; $i++){
	$newBook = $modx->newObject('Books');
	$newBook->set("idUser", $uid);
	$newBook->set("bookDate", $date);
	$newBook->set("idItem", $scriptProperties["items"]);
	$newBook->set("bookFrom", $i);
	$newBook->save();
}

return $modx->error->success('', $newBook);