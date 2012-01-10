<?php
class BookItPricingItemsManagerController extends BookItManagerController {
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
			

		$this->modx->regClientStartupScript($this->bookit->config['jsUrl'].'mgr/sections/pricingItems.js');
		
		$this->modx->regClientStartupScript($this->bookit->config['jsUrl'].'mgr/extra/combo.extra.js');
		
		$this->modx->regClientStartupScript($this->bookit->config['jsUrl'].'mgr/widgets/pricing/items/pricingItems.panel.js');
		
		$this->modx->regClientStartupScript($this->bookit->config['jsUrl'].'mgr/widgets/pricing/items/pricingItems.grid.js');
		
	}

	public function getTemplateFile() {
		return $this->bookit->config['templatesPath'].'pricingItems.tpl';
	}
}