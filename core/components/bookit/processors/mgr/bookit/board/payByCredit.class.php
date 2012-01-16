<?php
class BookItPayByCreditProcessor extends modObjectProcessor {
	public $objectType = 'bookit';
	public $languageTopics = array('bookit:default');
	private $output;

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
		
		$discount = $this->modx->getObject("BookItSettigns", array("key" => "credit_discount"))->get('value');
		
		if(preg_match("/%/", $discount) == 1){
			$price = (100-$discount)/100*$price;
		}else{
			$price -= $discount;
		}
		
		if($credit < $price){
			return $this->failure();
		}
		
		$extendedFields["credit"] -= $price;
		
		$userProfile->set('extended', $extendedFields);
		$userProfile->save();
		
		$book->set("paid", 2);
		$book->save();

		return $this->cleanup();
	}

	public function cleanup() {
		return $this->success();
	}
}
return 'BookItPayByCreditProcessor';
