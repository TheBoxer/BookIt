<?php
require_once dirname(dirname(dirname(dirname(__FILE__)))).'/config.core.php';
require_once MODX_CORE_PATH.'config/'.MODX_CONFIG_KEY.'.inc.php';
require_once MODX_CONNECTORS_PATH.'index.php';
 
$corePath = $modx->getOption('bookit.core_path',null,$modx->getOption('core_path').'components/bookit/');
require_once $corePath.'model/bookit/bookit.class.php';
$modx->bookit = new BookIt($modx);

$modx->getService('fire', 'modFire', $modx->getOption('core_path').'components/modfire/');
include 'D:/Web/www/modx/bookit/ChromePhp.php';
ChromePhp::useFile('D:/Web/www/modx/chromelog', 'http://modx.localhost/chromelog');

$modx->lexicon->load('bookit:default');
 
/* handle request */
$path = $modx->getOption('processorsPath',$modx->bookit->config,$corePath.'processors/');
$modx->request->handleRequest(array(
    'processors_path' => $path,
    'location' => '',
));
