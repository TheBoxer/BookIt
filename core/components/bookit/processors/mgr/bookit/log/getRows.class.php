<?php
class BookItLogGetListProcessor extends modObjectGetListProcessor {
	public $classKey = 'BookItLog';
	public $languageTopics = array('bookit:default');
	public $defaultSortField = 'timeOfAction';
	public $defaultSortDirection = 'DESC';
	public $objectType = 'bookit';

    public function prepareQueryBeforeCount(xPDOQuery $c) {
        $filterUser = $this->getProperty('filterUser');
        $filterEmploee = $this->getProperty('filterEmployee');
        $filterLogType = $this->getProperty('filterLogType');
        $filterDay = $this->getProperty('filterDay');
        $filterHour = $this->getProperty('filterHour');
        $filterItem = $this->getProperty('filterItem');

        if (!empty($filterUser)) {
            $c->where(array(
                'customer' => $filterUser
            ));
        }

        if(!empty($filterEmploee)){
            $c->where(array(
                'operator' => $filterEmploee
            ));
        }

        if(!empty($filterLogType)){
            $c->where(array(
                'type' => $filterLogType
            ));
        }

        if(!empty($filterDay)){
            $c->where(array(
                'day' => strtotime($filterDay)
            ));
        }

        if(!empty($filterHour)){
            $c->where(array(
                'hour' => $filterHour
            ));
        }

        if(!empty($filterItem)){
            $c->where(array(
                'item' => $filterItem
            ));
        }

        return $c;
    }

    public function prepareRow(xPDOObject $object) {
        $itemArray = $object->toArray();

        $itemArray['type'] = $this->modx->lexicon('bookit.'.$itemArray['type']);

        $itemArray['customer'] = $this->modx->getObject('modUser', $itemArray['customer'])->getOne('Profile')->get('fullname');
        $itemArray['operator'] = $this->modx->getObject('modUser', $itemArray['operator'])->getOne('Profile')->get('fullname');

        if(!empty($itemArray['day'])){
            $itemArray['day'] = date('d. m. Y', strtotime($itemArray['day']));
        }

        $itemArray['timeOfAction'] = date('d. m. Y H:i', strtotime($itemArray['timeOfAction']));

        if(!empty($itemArray['item'])){
            $itemArray['item'] =  $this->modx->getObject('BookItems', $itemArray['item'])->get('name');
        }

        return $itemArray;
    }

}

return 'BookItLogGetListProcessor';