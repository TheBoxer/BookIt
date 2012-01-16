<?php
class BookItOpenScheduleListItemsGetListProcessor extends modObjectGetListProcessor {
	public $classKey = 'OpenScheduleListItem';
	public $languageTopics = array('bookit:default');
	public $defaultSortField = 'openDay';
	public $defaultSortDirection = 'ASC';
	public $objectType = 'bookit';

	public function prepareQueryBeforeCount(xPDOQuery $c) {
		$filterDay = $this->getProperty('filterDay');
		if (isset($filterDay)) {
			$c->where(array(
					'openDay' => $filterDay
			));
		}
		return $c;
	}
	
	public function prepareRow(xPDOObject $object) {
		$itemArray = $object->toArray();
		
		$openFromArray = explode(":", $itemArray["openFrom"]);
		$openFromArray[1] = (array_key_exists(1, $openFromArray))? $openFromArray[1] : 0;
		
		$openToArray = explode(":", $itemArray["openTo"]);
		$openToArray[1] = (array_key_exists(1, $openToArray))? $openToArray[1] : 0;
		
		$itemArray["openFrom"] = date("G:i", mktime($openFromArray[0], $openFromArray[1], 0, 0, 0, 0));
		$itemArray["openTo"] = date("G:i", mktime($openToArray[0], $openToArray[1], 0, 0, 0, 0));
	
		return $itemArray;
	}

}

return 'BookItOpenScheduleListItemsGetListProcessor';