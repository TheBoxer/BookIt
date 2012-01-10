<?php
class BookItGetItemsProcessor extends modObjectGetListProcessor {
    public $classKey = 'BookItems';
    public $languageTopics = array('bookit:default');
    public $defaultSortField = 'name';
    public $defaultSortDirection = 'ASC';
    public $objectType = 'bookit';

	public function prepareRow(xPDOObject $object) {
		$itemArray = $object->toArray();
	
		
		if(!empty($itemArray['openschedule'])){
			$os = $this->modx->getObject('OpenScheduleList', $itemArray['openschedule']);
			$itemArray['openschedule_label'] = $os->get('name');
				
			if(!empty($itemArray['pricing'])){
				$pr = $this->modx->getObject('PricingList', $itemArray['pricing']);
				$itemArray['pricing_label'] = $pr->get('name');
			}else{
				$itemArray['pricing_label'] = "";
			}
				
		}else{
			$itemArray['openschedule_label'] = "";
		}
		
		return $itemArray;
	}

}
return 'BookItGetItemsProcessor';