<?php                   
class BookItemsExtraGetListProcessor extends modObjectGetListProcessor {
	public $classKey = 'BookItems';
	public $languageTopics = array('bookit:default');
	public $defaultSortField = 'name';
	public $defaultSortDirection = 'ASC';
	public $objectType = 'bookit';
}

return 'BookItemsExtraGetListProcessor';