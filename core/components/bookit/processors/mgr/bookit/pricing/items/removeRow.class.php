<?php
class PricingListItemRemoveItemProcessor extends modObjectRemoveProcessor {
	public $classKey = 'PricingListItem';
	public $languageTopics = array('bookit:default');
	public $objectType = 'bookit';
}

return 'PricingListItemRemoveItemProcessor';