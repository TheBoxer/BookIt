<?php
class BookItPricingListGetListProcessor extends modObjectGetListProcessor {
	public $classKey = 'PricingList';
	public $languageTopics = array('bookit:default');
	public $defaultSortField = 'name';
	public $defaultSortDirection = 'ASC';
	public $objectType = 'bookit';
}

return 'BookItPricingListGetListProcessor';