<?php
/* parse JSON */
if (empty($scriptProperties['data'])) return $modx->error->failure('Invalid data.');
$_DATA = $modx->fromJSON($scriptProperties['data']);
if (!is_array($_DATA)) return $modx->error->failure('Invalid data.');
 
/* get obj */
if (empty($_DATA['id'])) return $modx->error->failure($modx->lexicon('bookit.error_no_item'));
$openschedule = $modx->getObject('BookItemsOpen',$_DATA['id']);
if (empty($openschedule)) return $modx->error->failure($modx->lexicon('bookit.error_no_item'));

$openschedule->fromArray($_DATA);
 
/* save */
if ($openschedule->save() == false) {
    return $modx->error->failure($modx->lexicon('bookit.error_save'));
}
 
return $modx->error->success('',$openschedule);