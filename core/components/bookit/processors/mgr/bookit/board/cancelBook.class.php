<?php
class CancelBookProcessor extends modObjectProcessor {
	public $objectType = 'bookit';
	public $languageTopics = array('bookit:default');
	private $item;

	public function process() {
		$id = $this->getProperty('id');
		$time = $this->getProperty('time');
		$colName = $this->getProperty('colName');
		$date = $this->getProperty('date');
		
		if ((empty($id)) && ((empty($time)) || (empty($colName)))) return $this->modx->error->failure($this->modx->lexicon('bookit.error_no_item'));
		
		if($id > 0){
			$item = $this->modx->getObject('Books',$id);
		}else{
			$itemid = explode("-", $colName);
			$itemid = $itemid[1];
		
			$time = explode(":", $time);
			$time = $time[0];
		
			$date = (!empty($date))? strtotime($date) : mktime(0,0,0,date("n"),date("j"),date("Y"));
		
			$where = array("idItem" => $itemid, "bookFrom" => $time, "bookDate" => $date);
		
			$this->item = $this->modx->getObject("Books", $where);
		}
		
		if (empty($this->item)) return $this->modx->error->failure($this->modx->lexicon('bookit.error_no_item'));
		
		if ($this->item->remove() == false) {
			return $this->modx->error->failure($this->modx->lexicon('bookit.error_remove'));
		}

		return $this->cleanup();
	}

	public function cleanup() {
		return $this->success('', $this->item);
	}
}
return 'CancelBookProcessor';
