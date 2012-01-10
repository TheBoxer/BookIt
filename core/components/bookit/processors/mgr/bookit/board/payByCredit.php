<?php
ChromePhp::warn ("payByCredit action");
ChromePhp::warn ($scriptProperties);

$book = $modx->getObject ("Books", $scriptProperties["id"]);

$userProfile = $modx->getObject("modUser", $book->get("idUser"))->getOne("Profile");

$extendedFields = $userProfile->get("extended");
$credit = $extendedFields["credit"];

$day = date("N", $book->get("bookDate"));

$item = $modx->getObject("BookItems", $book->get("idItem"));

$pricing = $modx->getObject("PricingListItem",array(
		"pricing_list" => $item->get("pricing"),
		"priceDay" => $day,
		"priceFrom:<=" => $book->get("bookFrom").":00:00",
		"priceTo:>" => $book->get("bookFrom").":00:00"
		));

$price = $pricing->get('price');

$discount = $modx->getObject("BookItSettigns", array("key" => "credit_discount"))->get('value');


if(preg_match("/%/", $discount) == 1){
	$price = (100-$discount)/100*$price;
}else{
	$price -= $discount;
}

if($credit < $price){
	return $modx->error->failure();
}

$extendedFields["credit"] -= $price;

$userProfile->set('extended', $extendedFields);
$userProfile->save();

$book->set("paid", 2);
$book->save();

return $modx->error->success('');