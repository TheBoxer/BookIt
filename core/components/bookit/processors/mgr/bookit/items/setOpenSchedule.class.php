<?php
class BookItSetOpenScheduleProcessor extends modObjectProcessor {
	public $classKey = 'BookItems';
	public $objectType = 'bookit';
	public $languageTopics = array('bookit:default');
	private $item;

	public function process() {
		$id = $this->getProperty('id');
		$openschedule = $this->getProperty('openschedule');
		
		if(empty($id)) return $this->failure($this->modx->lexicon('bookit.error_no_item'));
		
		if (empty($openschedule)) {
			$this->addFieldError('openschedule',$this->modx->lexicon('bookit.error_no_openschedule'));
		}
		
		$this->item = $this->modx->getObject($this->classKey, $id);
		$this->item->set('openschedule', $openschedule);
		$this->item->set('pricing', NULL);
		$this->item->set('active', 0);

		if ($this->item->save() == false) {
			return $this->failure($this->modx->lexicon('bookit.error_save'));
		}
		
		return $this->cleanup();
	}

	public function cleanup() {
		return $this->success('',$this->item);
	}
}
return 'BookItSetOpenScheduleProcessor';