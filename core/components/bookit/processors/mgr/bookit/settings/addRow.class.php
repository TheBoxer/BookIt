<?php
class BookItSettingsCreateItemProcessor extends modObjectCreateProcessor {
	public $classKey = 'BookItSettigns';
	public $languageTopics = array('bookit:default');
	public $objectType = 'bookit';

	public function beforeSave() {
		$key = $this->getProperty('key');

		if (empty($key)) {
			$this->addFieldError('key',$this->modx->lexicon('bookit.error_no_key'));
		} else if ($this->doesAlreadyExist(array('key' => $key))) {
			$this->addFieldError('key',$this->modx->lexicon('bookit.error_key_exists'));
		}
		return parent::beforeSave();
	}
}
return 'BookItSettingsCreateItemProcessor';