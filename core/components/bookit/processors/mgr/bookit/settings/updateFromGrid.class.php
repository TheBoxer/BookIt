<?php
class SettingsUpdateItemFromGridProcessor extends modObjectUpdateProcessor  {
	public $classKey = 'BookItSettigns';
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
		$key = $this->getProperty('key');
		$id = $this->getProperty('id');

		if ($this->doesAlreadyExist(array('key' => $key, 'id:!=' => $id))) {
			return $this->modx->lexicon('bookit.error_key_exists');
		}

		return parent::beforeSave();
	}
}
return 'SettingsUpdateItemFromGridProcessor';