<?php
class BookItOpenscheduleListItemUpdateItemFromGridProcessor extends modObjectUpdateProcessor  {
	public $classKey = 'OpenScheduleListItem';
	public $languageTopics = array('bookit:default');
	public $objectType = 'bookit';

	public function initialize() {
		$data = $this->getProperty('data');
		if (empty($data)) return $this->modx->lexicon('invalid_data');
		$data = $this->modx->fromJSON($data);
		if (empty($data)) return $this->modx->lexicon('invalid_data');
		$this->setProperties($data);
		$this->unsetProperty('data');

		return parent::initialize();
	}

	public function beforeSet() {
		$openDay = $this->getProperty('openDay');
		$openFrom = $this->getProperty('openFrom');
		$openTo = $this->getProperty('openTo');
		$id = $this->getProperty('id');
		$openscheduleList = $this->getProperty('openschedule_list');
		
		if(empty($openFrom)) {
			return $this->modx->lexicon('bookit.error_no_openfrom');
		}
		
		if(empty($openTo)) {
			return $this->modx->lexicon('bookit.error_no_opento');
		}
		
		
		$timeFromArray = explode(":", $openFrom);
		$timeToArray = explode(":", $openTo);
		$timeFrom = mktime($timeFromArray[0], $timeFromArray[1], 0, 0, 0, 0);
		$timeTo = mktime($timeToArray[0], $timeToArray[1], 0, 0, 0, 0);
		
		if($timeFrom >= $timeTo){
			return $this->modx->lexicon('bookit.error_from_gtoe_to');
		}
		
		$e = $this->modx->newQuery('OpenScheduleListItem');
		
		$e->where(
				array(
						array(
								array(
										array(
												'openFrom:<=' => $openFrom,
												'openTo:>=' => $openFrom
										),
										array(
												'OR:openFrom:<=' => $openTo,
												'openTo:>=' => $openTo
										)
								),
								array(
										'OR:openFrom:>=' => $openFrom,
										'openTo:<=' => $openTo
								)
						),
						'openschedule_list' => $openscheduleList,
						'openDay' => $openDay,
						'id:!=' => $id,
				)
		);
		
		
		$count = $this->modx->getCount('OpenScheduleListItem',$e);
		
		
		if($count != 0){
			return $this->modx->lexicon('bookit.error_schedule_exists');
		}
		
		return parent::beforeSet();
	}
}
return 'BookItOpenscheduleListItemUpdateItemFromGridProcessor';