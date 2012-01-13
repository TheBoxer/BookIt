<?php
class PricingListItemUpdateItemFromGridProcessor extends modObjectUpdateProcessor  {
	public $classKey = 'PricingListItem';
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
		$priceDay = $this->getProperty('priceDay');
		$priceFrom = $this->getProperty('priceFrom');
		$priceTo = $this->getProperty('priceTo');
		$price = $this->getProperty('price');
		$id = $this->getProperty('id');
		$pricingList = $this->getProperty('pricing_list');
		
		$pricing = $this->modx->getObject('PricingListItem',$id);
		if (empty($pricing)) return $this->modx->lexicon('bookit.error_no_item');
		
		if(empty($priceFrom)) {
			return $this->modx->lexicon('bookit.error_no_pricefrom');
		}
		
		if(empty($priceTo)) {
			return $this->modx->lexicon('bookit.error_no_priceto');
		}
		
		if(empty($price) || ($price == 0)) {
			return $this->modx->lexicon('bookit.error_no_price');
		}
		
		$timeFromArray = explode(":", $priceFrom);
		$timeToArray = explode(":", $priceTo);
		
		$timeFrom = mktime($timeFromArray[0], $timeFromArray[1], 0, 0, 0, 0);
		$timeTo = mktime($timeToArray[0], $timeToArray[1], 0, 0, 0, 0);
		
		
		if($timeFrom >= $timeTo){
			return $this->modx->lexicon('bookit.error_from_gtoe_to');
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
			return $this->modx->lexicon('bookit.error_schedule_unexists');
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
						'openschedule_list' => $pricingList,
						'priceDay' => $priceDay,
				)
		);
		
		$count = $this->modx->getCount('PricingListItem',$e);
		
		
		if($count != 0){
			return $this->modx->lexicon('bookit.error_price_exists');
		}

		return parent::beforeSet();
	}
}
return 'PricingListItemUpdateItemFromGridProcessor';