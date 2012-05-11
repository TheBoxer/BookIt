<?php
class BookItPayByCreditProcessor extends modObjectProcessor {
	public $objectType = 'bookit';
	public $languageTopics = array('bookit:default');

	public function process() {
		$id = $this->getProperty('id');

		$book = $this->modx->getObject ("Books", $id);
		$userProfile = $this->modx->getObject("modUser", $book->get("idUser"))->getOne("Profile");
		
		$extendedFields = $userProfile->get("extended");
		$credit = $extendedFields["credit"];
		
		$day = date("N", strtotime($book->get("bookDate")))-1;
		$item = $this->modx->getObject("BookItems", $book->get("idItem"));
		
		$pricing = $this->modx->getObject("PricingListItem",array(
				"pricing_list" => $item->get("pricing"),
				"priceDay" => $day,
				"priceFrom:<=" => $book->get("bookFrom").":00:00",
				"priceTo:>" => $book->get("bookFrom").":00:00"
				));
		
		$price = $pricing->get('price');
		
		if($credit < $price){
			return $this->failure();
		}
		
		$extendedFields["credit"] -= $price;
		
		$userProfile->set('extended', $extendedFields);
		$userProfile->save();
		
		$book->set("paid", 2);
		$book->save();

        /** @var BookItLog $log */
        $log = $this->modx->newObject('BookItLog');
        $log->logPayByCredit($book->get("idUser")->get('id'), $this->modx->user->get('id'), $price, $book->get("bookDate"), $book->get("bookFrom"), $book->get("idItem"));

		return $this->cleanup();
	}

	public function cleanup() {
		return $this->success();
	}
}
return 'BookItPayByCreditProcessor';
