<?php
class OpenScheduleListItemCreateProcessor extends modObjectCreateProcessor {
	public $classKey = 'OpenScheduleListItem';
	public $languageTopics = array('bookit:default');
	public $objectType = 'bookit';

	public function beforeSave() {
		$openscheduleList = $this->getProperty('openschedule_list');
		if(empty($openscheduleList)) {
			return $modx->error->failure();
		}
		
		$openDay = $this->getProperty('openDay');
		$openFrom = $this->getProperty('openFrom');
		$openTo = $this->getProperty('openTo');
		
		if(empty($openDay)) {
			$this->setProperty('openDay', 0);
		}
		
		if(empty($openFrom)) {
			$this->addFieldError('openFrom',$this->modx->lexicon('bookit.error_no_openfrom'));
		}
		
		if(empty($openTo)) {
			$this->addFieldError('openTo',$this->modx->lexicon('bookit.error_no_opento'));
		}
		
		
		$timeFromArray = explode(":", $openFrom);
		$timeToArray = explode(":", $openTo);
		$timeFrom = mktime($timeFromArray[0], $timeFromArray[1], 0, 0, 0, 0);
		$timeTo = mktime($timeToArray[0], $timeToArray[1], 0, 0, 0, 0);
		
		if($timeFrom >= $timeTo){
			$this->addFieldError('openFrom',$this->modx->lexicon('bookit.error_from_gtoe_to'));
			$this->addFieldError('openTo',$this->modx->lexicon('bookit.error_from_gtoe_to'));
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
				)
		);
		
		$count = $this->modx->getCount('OpenScheduleListItem',$e);
		
		
		if($count != 0){
			$this->addFieldError('openDay',$this->modx->lexicon('bookit.error_schedule_exists'));
			$this->addFieldError('openFrom',$this->modx->lexicon('bookit.error_schedule_exists'));
			$this->addFieldError('openTo',$this->modx->lexicon('bookit.error_schedule_exists'));
		}

		return parent::beforeSave();
	}
}
return 'OpenScheduleListItemCreateProcessor';