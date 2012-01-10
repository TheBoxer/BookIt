<?php
class BookItPricingManagerController extends BookItManagerController {
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
			
		
		$this->modx->regClientStartupScript($this->bookit->config['jsUrl'].'mgr/sections/pricing.js');
		$this->addJavascript($this->bookit->config['jsUrl'].'mgr/extra/combo.extra.js');
		
		$this->addJavascript($this->bookit->config['jsUrl'].'mgr/widgets/pricing/pricing.panel.js');
		
		$this->addLastJavascript($this->bookit->config['jsUrl'].'mgr/widgets/pricing/pricing.grid.js');
	}

	public function getTemplateFile() {
		return $this->bookit->config['templatesPath'].'pricing.tpl';
	}
}