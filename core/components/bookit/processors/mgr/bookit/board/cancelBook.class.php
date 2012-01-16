<?php
class BookItCancelBookProcessor extends modObjectProcessor {
	public $objectType = 'bookit';
	public $languageTopics = array('bookit:default');
	private $item;
	private $id, $time, $colName, $date;
	
	public function initialize(){
		$this->id = $this->getProperty('id');
		$this->time = $this->getProperty('time');
		$this->colName = $this->getProperty('colName');
		$this->date = $this->getProperty('date');
		
		if ((empty($this->id)) && ((empty($this->time)) || (empty($this->colName)))){
				return $this->failure($this->modx->lexicon('bookit.error_no_item'));
		}
		
		return parent::initialize();
	}

	public function process() {
		$this->setItem();

		$this->payFee();
		
		
		if ($this->item->remove() == false) {
			return $this->modx->error->failure($this->modx->lexicon('bookit.error_remove'));
		}

		return $this->cleanup();
	}
	
	private function setItem(){
		if($this->id > 0){
			$this->item = $this->modx->getObject('Books',$this->id);
		}else{
			$itemid = explode("-", $this->colName);
			$itemid = $itemid[1];
		
			$time = explode(":", $this->time);
			$time = $time[0];
		
			$date = (!empty($this->date))? strtotime($this->date) : mktime(0,0,0,date("n"),date("j"),date("Y"));
		
			$where = array("idItem" => $itemid, "bookFrom" => $time, "bookDate" => $date);
		
			$this->item = $this->modx->getObject("Books", $where);
		}
		
		if (empty($this->item)) return $this->failure($this->modx->lexicon('bookit.error_no_item'));
	}
	
	private function payFee(){
		$cancelBookLimit = $this->modx->getObject("BookItSettigns", array("key" => "cancel_book"))->get('value');
		$maxWarnings = $this->modx->getObject("BookItSettigns", array("key" => "max_warnings"))->get('value');
		
		$timestamp = strtotime($this->item->get('bookDate')) + ($this->item->get('bookFrom')*3600);
		$now = time() + $cancelBookLimit * 3600;
		
		$paid = $this->item->get('paid');
		$user = $this->modx->getObject('modUser', $this->item->get('idUser'));
		$profile = $user->getOne('Profile');
		$extended = $profile->get('extended');
		
		$bookItem = $this->modx->getObject("BookItems", $this->item->get("idItem"));
		$day = date("N", strtotime($this->item->get("bookDate")))-1;
			
		$pricing = $this->modx->getObject("PricingListItem",array(
				"pricing_list" => $bookItem->get("pricing"),
				"priceDay" => $day,
				"priceFrom:<=" => $this->item->get("bookFrom").":00:00",
				"priceTo:>" => $this->item->get("bookFrom").":00:00"
		));
		
		$price = $pricing->get('price');
		
		if($now <= $timestamp){			
			if($paid == 2){
				$discount = $this->modx->getObject("BookItSettigns", array("key" => "credit_discount"))->get('value');
				
				if(preg_match("/%/", $discount) == 1){
					$price = (100-$discount)/100*$price;
				}else{
					$price -= $discount;
				}
			}
			
			if($paid == 3){
				$discount = $this->modx->getObject("BookItSettigns", array("key" => "permanent_discount"))->get('value');
			
				if(preg_match("/%/", $discount) == 1){
					$price = (100-$discount)/100*$price;
				}else{
					$price -= $discount;
				}
			}
			
			$extended['credit'] += $price;
			
			$profile->set('extended', $extended);
			$profile->save();
			return;
		}
		
		if($paid == 0){
			$extended['warnings'] = (empty($extended['warnings']))? 1 : $extended['warnings']+1;
			
			if($extended['warnings'] >= $maxWarnings){
				$extended['debt'] = (empty($extended['debt']))? $price : $extended['debt']+$price;
			}
			
			$profile->set('extended', $extended);
			$profile->save();
			return;
		}
		
	}

	public function cleanup() {
		return $this->success('', $this->item);
	}
}
return 'BookItCancelBookProcessor';
