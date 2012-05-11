<?php
class BookItLogManagerController extends BookItManagerController {
	public function process(array $scriptProperties = array()) {

	}
	public function getPageTitle() {
		return $this->modx->lexicon('bookit.log');
	}
	
	public function checkPermissions() {
		if(!$this->modx->hasPermission('bookit.log')) return false;
		return true;
	}

	public function loadCustomCssJs() {
        $this->addJavascript($this->bookit->config['jsUrl'].'mgr/extra/combo.extra.js');
		$this->addJavascript($this->bookit->config['jsUrl'].'mgr/widgets/log/log.grid.js');
		$this->addJavascript($this->bookit->config['jsUrl'].'mgr/widgets/log/log.panel.js');
		$this->addLastJavascript($this->bookit->config['jsUrl'].'mgr/sections/log.js');


	}

	public function getTemplateFile() {
		return $this->bookit->config['templatesPath'].'log.tpl';
	}
}