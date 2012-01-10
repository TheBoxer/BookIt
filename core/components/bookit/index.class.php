<?php
require_once dirname(__FILE__) . '/model/bookit/bookit.class.php';
class IndexManagerController extends modExtraManagerController {
    public static function getDefaultController() { return 'home'; }
}
abstract class BookItManagerController extends modManagerController {
    public $bookit;
    public function initialize() {
        $this->bookit = new BookIt($this->modx);

        //$this->addCss($this->bookit->config['cssUrl'].'mgr.css');
        $this->addJavascript($this->bookit->config['jsUrl'].'mgr/bookit.js');
        $this->addHtml('<script type="text/javascript">
        Ext.onReady(function() {
        		
            Bookit.config = '.$this->modx->toJSON($this->bookit->config).';
        });
        </script>');
        return parent::initialize();
    }
    public function getLanguageTopics() {
        return array('bookit:default');
    }
    public function checkPermissions() { return true;}
}