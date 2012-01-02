<?php
$itemid = explode("-", $scriptProperties["colName"]);
$itemid = $itemid[1];

$time = explode(":", $scriptProperties["time"]);
$time = $time[0];

$date = (!empty($scriptProperties["date"]))? strtotime($scriptProperties["date"]) : mktime(0,0,0,date("n"),date("j"),date("Y"));

$where = array("idItem" => $itemid, "bookFrom" => $time, "bookDate" => $date); 

$book = $modx->getObject("Books", $where);

$user = $modx->getObject("modUser", $book->get("idUser"))->getOne("Profile");

$item = $modx->getObject("BookItems", $itemid);

$extendedFields = $user->get("extended");

$credit = $extendedFields["credit"];
$credit = intval($credit) . " Kč";

$ret = array(
			"id" => $book->get('id'),
			"fullname" => $user->get("fullname"), 
			"phone" => $user->get("mobilephone"),
		  	"email" => $user->get("email"),
			"date" => date("d.m.Y", $date),
			"time" => $scriptProperties["time"],
			"item" => $item->get('name'),
			"credit" => $credit
		);




return $modx->error->success('', $ret);