<?php
class SettingsGetListProcessor extends modObjectGetListProcessor {
	public $classKey = 'BookItSettigns';
	public $languageTopics = array('bookit:default');
	public $defaultSortField = 'key';
	public $defaultSortDirection = 'ASC';
	public $objectType = 'bookit';
}

return 'SettingsGetListProcessor';