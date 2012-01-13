<?php
class PricingListItemGetListProcessor extends modObjectGetListProcessor {
	public $classKey = 'PricingListItem';
	public $languageTopics = array('bookit:default');
	public $defaultSortField = 'priceDay';
	public $defaultSortDirection = 'ASC';
	public $objectType = 'bookit';

	public function prepareQueryBeforeCount(xPDOQuery $c) {
		$pricingList = $this->getProperty('pricing_list');
		$c->where(array('pricing_list' => $pricingList));
		
		$priceDay = $this->getProperty('priceDay');
		if (isset($priceDay)) {
			$c->where(array(
					'priceDay' => $priceDay
			));
		}
		
		$c->sortby($this->defaultSortField,$this->defaultSortDirection);
		$c->sortby("priceFrom",$this->defaultSortDirection);
		
		return $c;
	}

	public function prepareRow(xPDOObject $object) {
		$itemArray = $object->toArray();

		$priceFromArray = explode(":", $itemArray["priceFrom"]);
    	$priceFromArray[1] = (array_key_exists(1, $priceFromArray))? $priceFromArray[1] : 0;
    
    	$priceToArray = explode(":", $itemArray["priceTo"]);
    	$priceToArray[1] = (array_key_exists(1, $priceToArray))? $priceToArray[1] : 0;
    
    	$itemArray["priceFrom"] = date("G:i", mktime($priceFromArray[0], $priceFromArray[1], 0, 0, 0, 0));
    	$itemArray["priceTo"] = date("G:i", mktime($priceToArray[0], $priceToArray[1], 0, 0, 0, 0));

		return $itemArray;
	}

}

return 'PricingListItemGetListProcessor';