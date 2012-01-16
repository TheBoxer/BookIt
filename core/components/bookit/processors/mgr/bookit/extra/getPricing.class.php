<?php           
class BookItPricingExtraGetListProcessor extends modObjectGetListProcessor {
	public $classKey = 'PricingList';
	public $languageTopics = array('bookit:default');
	public $defaultSortField = 'name';
	public $defaultSortDirection = 'ASC';
	public $objectType = 'bookit';
	
	public function prepareQueryBeforeCount(xPDOQuery $c) {
		$itemid = $this->getProperty('itemid');
		
		$item = $this->modx->getObject('BookItems', $itemid);

		$c->where(array('openschedule_list' => $item->get('openschedule')));
			
		return $c;
	}
}

return 'BookItPricingExtraGetListProcessor';