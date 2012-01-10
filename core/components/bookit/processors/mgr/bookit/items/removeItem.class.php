<?php
class BookItRemoveItemProcessor extends modObjectRemoveProcessor {
	public $classKey = 'BookItems';
	public $languageTopics = array('bookit:default');
	public $objectType = 'bookit';
}
return 'BookItRemoveItemProcessor';