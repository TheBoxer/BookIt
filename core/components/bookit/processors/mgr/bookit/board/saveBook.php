<?php

ChromePhp::warn("Action: saveBook");
ChromePhp::warn($scriptProperties);

if(empty($scriptProperties["user"])){
	$modx->error->addField('user', $modx->lexicon('bookit.error_no_user'));
}
if(empty($scriptProperties["phone"])){
	$modx->error->addField('phone', $modx->lexicon('bookit.error_no_phone'));
}

if ($modx->error->hasError()) {
	return $modx->error->failure();
}

$date = (!empty($scriptProperties["date"]))? strtotime($scriptProperties["date"]) : mktime(0,0,0,date("n"),date("j"),date("Y"));
$time = explode(":", $scriptProperties["time"]);
$time = $time[0];

$newBook = $modx->newObject('Books');

$newBook->set("bookDate", $date);
$newBook->set("bookFrom", $time);
$newBook->set("idItem", $scriptProperties["items"]);

if(intval($scriptProperties["user"]) != 0){
	$newBook->set("idUser", intval($scriptProperties["user"]));
}else{
	
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
		$newBook->set("idUser", $newUser->get("id"));
	}else{
		return $modx->error->failure();
	}
}

$newBook->save();

return $modx->error->success('', null);