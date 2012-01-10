<?php
class BookItSettingsManagerController extends BookItManagerController {
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
		
		$this->addJavascript($this->bookit->config['jsUrl'].'mgr/widgets/settings/openSchedule.grid.js');
		$this->addJavascript($this->bookit->config['jsUrl'].'mgr/widgets/settings/settings.grid.js');
		$this->addJavascript($this->bookit->config['jsUrl'].'mgr/widgets/settings/items.grid.js');
		$this->addJavascript($this->bookit->config['jsUrl'].'mgr/widgets/settings/settings.panel.js');
		$this->addLastJavascript($this->bookit->config['jsUrl'].'mgr/sections/settings.js');


	}

	public function getTemplateFile() {
		return $this->bookit->config['templatesPath'].'settings.tpl';
	}
}