<?php
class OpenScheduleListGetListProcessor extends modObjectGetListProcessor {
	public $classKey = 'OpenScheduleList';
	public $languageTopics = array('bookit:default');
	public $defaultSortField = 'name';
	public $defaultSortDirection = 'ASC';
	public $objectType = 'bookit';

}

return 'OpenScheduleListGetListProcessor';