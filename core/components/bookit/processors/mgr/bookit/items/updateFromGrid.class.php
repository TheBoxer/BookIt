<?php
class BookItUpdateItemFromGridProcessor extends modObjectUpdateProcessor  {
	public $classKey = 'BookItems';
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
		$pricing = $this->getProperty('pricing');
		$active = $this->getProperty('active');
		ChromePhp::warn($active);
		ChromePhp::warn($pricing);
		if (empty($pricing)) {
			if($active == true){
				return $this->modx->lexicon('bookit.error_save');
			}
		} 
		return parent::beforeSet();
	}
}
return 'BookItUpdateItemFromGridProcessor';