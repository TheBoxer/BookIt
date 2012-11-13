<?php
class BookItHomeManagerController extends BookItManagerController {
    public function process(array $scriptProperties = array()) {

    }
    public function getPageTitle() { return $this->modx->lexicon('bookit'); }
    
    public function loadCustomCssJs() {
    	
        $c = $this->modx->newQuery('BookItems');
		$c->where(array('active'=>1));
		$items = $this->modx->getIterator('BookItems', $c);
		$fields = "";
		$columns = "";
		foreach ($items as $item) {
		    $itemArray = $item->toArray(); 
		    $fields .= "'item-".$itemArray["id"]."', ";
		    $columns .= "{header: '".$itemArray["name"]."',dataIndex: 'item-".$itemArray["id"]."'},";
		}

		$fields = substr($fields, 0, -2);
		$columns = substr($columns, 0, -1);

		$this->addHtml("<script type=\"text/javascript\">

		var boarderFields = ['id', 'time', ".$fields."]

		var columns = [{header: _('bookit.time'),dataIndex: 'time'},".$columns."]

		</script>", 1);


		$this->addJavascript($this->bookit->config['jsUrl'].'mgr/extra/combo.extra.js');
		$this->addJavascript($this->bookit->config['jsUrl'].'mgr/widgets/users/users.grid.js');
        $this->addJavascript($this->bookit->config['jsUrl'].'mgr/widgets/users/users.windows.js');
        $this->addJavascript($this->bookit->config['jsUrl'].'mgr/widgets/board.grid.js');
		$this->addJavascript($this->bookit->config['jsUrl'].'mgr/widgets/home.panel.js');
		$this->addLastJavascript($this->bookit->config['jsUrl'].'mgr/sections/index.js');
    }

    public function getTemplateFile() { return $this->bookit->config['templatesPath'].'home.tpl'; }
}