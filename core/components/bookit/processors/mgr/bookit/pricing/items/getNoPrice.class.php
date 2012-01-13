<?php
class GetNoPriceProcessor extends modObjectProcessor {
	public $classKey = 'OpenScheduleListItem';
	public $objectType = 'bookit';
	public $languageTopics = array('bookit:default');
	private $output;

	public function process() {
		$id = $this->getProperty('id');

		if(empty($id)) return $this->failure($this->modx->lexicon('bookit.error_no_item'));

		$schedulelist = $this->modx->getObject('PricingList', $id);
		$schedulelistId = $schedulelist->get('openschedule_list');
		
		$s = $this->modx->newQuery($this->classKey);
		$s->where(array('openschedule_list' => $schedulelistId));
		
		$items = $this->modx->getIterator($this->classKey, $s);
		
		$schedule = array();
		
		foreach ($items as $item){
			$itemArray = $item->toArray();
			$openFromArray = explode(":", $itemArray["openFrom"]);
		    $openFromArray[1] = (array_key_exists(1, $openFromArray))? $openFromArray[1] : 0;
		    
		    $openToArray = explode(":", $itemArray["openTo"]);
		    $openToArray[1] = (array_key_exists(1, $openToArray))? $openToArray[1] : 0;
		    
		    $itemArray["openFrom"] = date("G:i", mktime($openFromArray[0], $openFromArray[1], 0, 0, 0, 0));
		    $itemArray["openTo"] = date("G:i", mktime($openToArray[0], $openToArray[1], 0, 0, 0, 0));
		    
			$schedule[$itemArray['openDay']][] = array('openFrom' => $itemArray['openFrom'], 'openTo' => $itemArray['openTo']);
		}
		
		$d = array( 0 => 'monday', 1 => 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday');
		
		$this->output = "";
		
		foreach($schedule as $k => $v){
			$this->output .= '<p>'.$this->modx->lexicon('bookit.'.$d[$k]) .": ";
			foreach($v as $day){
				$this->output .= $day['openFrom'].' - '.$day['openTo'].', ';
			}
			$this->output = substr($this->output, 0, -2);
			$this->output .= '</p>';
		}
			

		return $this->cleanup();
	}

	public function cleanup() {
		return $this->success('',array('noPrice' => $this->output));
	}
}
return 'GetNoPriceProcessor';
