<?php
class BookItOpenScheduleItemsManagerController extends BookItManagerController {
	public function process(array $scriptProperties = array()) {

	}
	public function getPageTitle() {
		return $this->modx->lexicon('bookit.settings');
	}

	public function checkPermissions() {
		if(!$this->modx->hasPermission('bookit.settings')) return false;
		return true;
	}

	public function loadCustomCssJs() {
	
		$this->addJavascript($this->bookit->config['jsUrl'].'mgr/extra/combo.extra.js');

		$this->addJavascript($this->bookit->config['jsUrl'].'mgr/widgets/openScheduleItems/openScheduleItems.grid.js');
		$this->addJavascript($this->bookit->config['jsUrl'].'mgr/widgets/openScheduleItems/openScheduleItems.panel.js');
		$this->addLastJavascript($this->bookit->config['jsUrl'].'mgr/sections/openScheduleItems.js');
	}

	public function getTemplateFile() {
		return $this->bookit->config['templatesPath'].'openScheduleItems.tpl';
	}
}