<?php
class BookItPricingListItemCreateProcessor extends modObjectCreateProcessor {
	public $classKey = 'PricingListItem';
	public $languageTopics = array('bookit:default');
	public $objectType = 'bookit';

	public function beforeSave() {
		$pricingList = $this->getProperty('pricing_list');
		if(empty($pricingList)) {
			return $modx->error->failure();
		}
		
		$priceDay = $this->getProperty('openDay');
		$priceFrom = $this->getProperty('priceFrom');
		$priceTo = $this->getProperty('priceTo');
		$price = $this->getProperty('price');
		
		$this->setProperty('priceDay', $priceDay);
		$this->setProperty('openDay', null);
		
		if(empty($priceDay)) {
			$this->setProperty('priceDay', 0);
		}
				
		if(empty($priceFrom)) {
			$this->addFieldError('priceFrom',$this->modx->lexicon('bookit.error_no_pricefrom'));
		}
				
		if(empty($priceTo)) {
			$this->addFieldError('priceTo',$this->modx->lexicon('bookit.error_no_priceto'));
		}
				
		if(empty($price) || ($price == 0)) {
			$this->addFieldError('price',$this->modx->lexicon('bookit.error_no_price'));
		}

		$schedulelist = $this->modx->getObject('PricingList', $pricingList);
		$schedulelistId = $schedulelist->get('openschedule_list');
		
		$schedule = $this->modx->newQuery('OpenScheduleListItem');
		$schedule->where(array(
				'openschedule_list' => $schedulelistId
				,'openDay' => $priceDay
				,'openFrom:<=' => $priceFrom
				,'openTo:>=' => $priceTo
		));
		
		$scheduleCount = $this->modx->getCount('OpenScheduleListItem',$schedule);
		
		if($scheduleCount == 0){
			$this->addFieldError('openDay',$this->modx->lexicon('bookit.error_schedule_unexists'));
			$this->addFieldError('priceFrom',$this->modx->lexicon('bookit.error_schedule_unexists'));
			$this->addFieldError('priceTo',$this->modx->lexicon('bookit.error_schedule_unexists'));
		}
		
		$timeFromArray = explode(":", $priceFrom);
		$timeToArray = explode(":", $priceTo);
		$timeFrom = mktime($timeFromArray[0], $timeFromArray[1], 0, 0, 0, 0);
		$timeTo = mktime($timeToArray[0], $timeToArray[1], 0, 0, 0, 0);
		
		if($timeFrom >= $timeTo){
			$this->addFieldError('priceFrom',$this->modx->lexicon('bookit.error_from_gtoe_to'));
			$this->addFieldError('priceTo',$this->modx->lexicon('bookit.error_from_gtoe_to'));
		}
		
		$e = $this->modx->newQuery('PricingListItem');
		
		$e->where(
				array(
						array(
								array(
										array(
												'priceFrom:<' => $priceFrom,
												'priceTo:>' => $priceFrom
										),
										array(
												'OR:priceFrom:<' => $priceTo,
												'priceTo:>' => $priceTo
										)
								),
								array(
										'OR:priceFrom:>=' => $priceFrom,
										'priceTo:<=' => $priceTo
								)
						),
						'pricing_list' => $pricingList,
						'priceDay' => $priceDay,
				)
		);
		
		$count = $this->modx->getCount('PricingListItem',$e);
		
		
		if($count != 0){
			$this->addFieldError('openDay',$this->modx->lexicon('bookit.error_price_exists'));
			$this->addFieldError('priceFrom',$this->modx->lexicon('bookit.error_price_exists'));
			$this->addFieldError('priceTo',$this->modx->lexicon('bookit.error_price_exists'));
		}

		return parent::beforeSave();
	}
}
return 'BookItPricingListItemCreateProcessor';