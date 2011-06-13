<?php
require_once MODX_CORE_PATH . 'model/modx/modrequest.class.php';
class bookitControllerRequest extends modRequest {
    public $bookit = null;
    public $actionVar = 'action';
    public $defaultAction = 'index';
 
    function __construct(BookIt &$bookit) {
        parent :: __construct($bookit->modx);
        $this->bookit =& $bookit;
    }
 
    public function handleRequest() {
        $this->loadErrorHandler();
 
        /* save page to manager object. allow custom actionVar choice for extending classes. */
        $this->action = isset($_REQUEST[$this->actionVar]) ? $_REQUEST[$this->actionVar] : $this->defaultAction;
 
        $modx =& $this->modx;
        $bookit =& $this->bookit;
        $viewHeader = include $this->bookit->config['corePath'].'controllers/mgr/header.php';
 
        $f = $this->bookit->config['corePath'].'controllers/mgr/'.$this->action.'.php';
        if (file_exists($f)) {
            $viewOutput = include $f;
        } else {
            $viewOutput = 'Controller not found: '.$f;
        }
 
        return $viewHeader.$viewOutput;
    }
}