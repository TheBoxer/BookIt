<?php
class BookItGetBookDetailsProcessor extends modObjectProcessor {
	public $objectType = 'bookit';
	public $languageTopics = array('bookit:default');
	private $output;

	public function process() {
		$colName = $this->getProperty('colName');
		$time = $this->getProperty('time');
		$date = $this->getProperty('date');
		
		$itemid = explode("-", $colName);
		$itemid = $itemid[1];
		$time = explode(":", $time);
		$time = $time[0];
	
		$date = (!empty($date))? strtotime($date) : mktime(0,0,0,date("n"),date("j"),date("Y"));	
		$where = array("idItem" => $itemid, "bookFrom" => $time, "bookDate" => $date);
		$book = $this->modx->getObject("Books", $where);
		$user = $this->modx->getObject("modUser", $book->get("idUser"))->getOne("Profile");
		$item = $this->modx->getObject("BookItems", $itemid);
		$extended = $user->get("extended");
		$credit = (intval($extended["credit"]))." Kč";
		$warnings = (intval($extended["warnings"]));
		$debt = (intval($extended["debt"]))." Kč";
		$time = $this->getProperty('time');
		
		$this->output = array(
				"id" => $book->get('id'),
				"fullname" => $user->get("fullname"),
				"phone" => $user->get("mobilephone"),
				"email" => $user->get("email"),
				"date" => date("d.m.Y", $date),
				"time" => $time,
				"item" => $item->get('name'),
				"credit" => $credit,
				"warnings" => $warnings,
				"debt" => $debt
		);

		return $this->cleanup();
	}

	public function cleanup() {
		return $this->success('', $this->output);
	}
}
return 'BookItGetBookDetailsProcessor';
