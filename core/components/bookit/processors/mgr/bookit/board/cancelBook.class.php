<?php
class BookItCancelBookProcessor extends modObjectProcessor {
	public $objectType = 'bookit';
	public $languageTopics = array('bookit:default');
	private $item;
	private $id, $time, $colName, $date, $notPaid;
	private $user;
	private $price;
    /** @var BookItLog $log */
    private $log;
    private $ltime, $lday;
	
	public function initialize(){
		$this->id = $this->getProperty('id');
		$this->time = $this->getProperty('time');
		$this->colName = $this->getProperty('colName');
		$this->date = $this->getProperty('date');
		$this->notPaid = $this->getProperty('notPaid');
		
		if ((empty($this->id)) && ((empty($this->time)) || (empty($this->colName)))){
				return $this->failure($this->modx->lexicon('bookit.error_no_item'));
		}


        $this->log = $this->modx->newObject('BookItLog');

		return parent::initialize();
	}

	public function process() {
		$this->setItem();

        if($this->item->get('paid') == 1){
            return $this->failure($this->modx->lexicon('bookit.cant_cancel_cash_paid_book'));
        }

		$this->setUser();
		$this->setPrice();
		
		$this->payFee();
		
		if($this->notPaid == true){
			$this->item->set('paid', 9);
			$this->item->save();
		}else{
			if ($this->item->remove() == false) {
				return $this->modx->error->failure($this->modx->lexicon('bookit.error_remove'));
			}
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
	
	private function setUser(){
		$this->user = $this->modx->getObject('modUser', $this->item->get('idUser'));
	}
	
	private function setPrice(){
		$bookItem = $this->modx->getObject("BookItems", $this->item->get("idItem"));
		$day = date("N", strtotime($this->item->get("bookDate")))-1;

        $pricing = $this->modx->getObject("PricingListItem",array(
				"pricing_list" => $bookItem->get("pricing"),
				"priceDay" => $day,
				"priceFrom:<=" => $this->item->get("bookFrom").":00:00",
				"priceTo:>" => $this->item->get("bookFrom").":00:00"
		));
		
		$this->price = $pricing->get('price');
        $this->log->logCancelBook($this->user->get('id'), $this->modx->user->get('id'), $this->price, $day, $this->item->get("bookFrom"), $this->item->get("idItem"));
	}
	
	private function payFee(){
		$cancelBookLimit = $this->modx->getObject("BookItSettigns", array("key" => "cancel_book"))->get('value');
		$maxWarnings = $this->modx->getObject("BookItSettigns", array("key" => "max_warnings"))->get('value');
		
		$timestamp = strtotime($this->item->get('bookDate')) + ($this->item->get('bookFrom')*3600);
		$now = time() + $cancelBookLimit * 3600;
		
		$paid = $this->item->get('paid');
		
		$profile = $this->user->getOne('Profile');
		$extended = $profile->get('extended');
		
		
		
		if($now <= $timestamp){			
// 			if($paid == 2){
// 				$discount = $this->modx->getObject("BookItSettigns", array("key" => "credit_discount"))->get('value');
				
// 				if(preg_match("/%/", $discount) == 1){
// 					$price = (100-$discount)/100*$price;
// 				}else{
// 					$price -= $discount;
// 				}
// 			}
			
// 			if($paid == 3){
// 				$discount = $this->modx->getObject("BookItSettigns", array("key" => "permanent_discount"))->get('value');
			
// 				if(preg_match("/%/", $discount) == 1){
// 					$price = (100-$discount)/100*$price;
// 				}else{
// 					$price -= $discount;
// 				}
// 			}
			
			$extended['credit'] += $this->price;
			
			$profile->set('extended', $extended);
			$profile->save();
			return;
		}
		
		if($paid == 0){
			$extended['warnings'] = (empty($extended['warnings']))? 1 : $extended['warnings']+1;
			
			if($extended['warnings'] >= $maxWarnings){
				$extended['debt'] = (empty($extended['debt']))? $this->price : $extended['debt']+$this->price;
                $this->log->logAddDebt($this->user->get('id'), $this->modx->user->get('íd'), $this->price, $this->item->get("bookDate"), $this->item->get("bookFrom"), $this->item->get('idItem'));
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
