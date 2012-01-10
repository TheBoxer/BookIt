<?php
class SetPricingProcessor extends modObjectProcessor {
	public $classKey = 'BookItems';
	public $objectType = 'bookit';
	public $languageTopics = array('bookit:default');
	private $item;

	public function process() {
		$id = $this->getProperty('id');
		$pricing = $this->getProperty('pricing');

		if(empty($id)) return $this->failure($this->modx->lexicon('bookit.error_no_item'));

		if (empty($pricing)) {
			$this->addFieldError('pricing',$this->modx->lexicon('bookit.error_no_pricing'));
		}

		$this->item = $this->modx->getObject($this->classKey, $id);
		$this->item->set('pricing', $pricing);

		if ($this->item->save() == false) {
			return $this->failure($this->modx->lexicon('bookit.error_save'));
		}

		return $this->cleanup();
	}

	public function cleanup() {
		return $this->success('',$this->item);
	}
}
return 'SetPricingProcessor';