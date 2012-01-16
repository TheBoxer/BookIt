<?php
class BookItSettingsGetListProcessor extends modObjectGetListProcessor {
	public $classKey = 'BookItSettigns';
	public $languageTopics = array('bookit:default');
	public $defaultSortField = 'key';
	public $defaultSortDirection = 'ASC';
	public $objectType = 'bookit';
}

return 'BookItSettingsGetListProcessor';