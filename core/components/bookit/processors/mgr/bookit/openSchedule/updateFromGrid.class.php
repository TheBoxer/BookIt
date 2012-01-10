<?php
class OpenScheduleListUpdateItemFromGridProcessor extends modObjectUpdateProcessor  {
	public $classKey = 'OpenScheduleList';
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

	public function beforeSave() {
		$name = $this->getProperty('name');
		$id = $this->getProperty('id');
		
		if ($this->doesAlreadyExist(array('name' => $name, 'id:!=' => $id))) {
			return $this->modx->lexicon('bookit.error_name_exists');
		}

		return parent::beforeSave();
	}
}
return 'OpenScheduleListUpdateItemFromGridProcessor';