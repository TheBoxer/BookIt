<?php
/* parse JSON */
if (empty($scriptProperties['data'])) return $modx->error->failure('Invalid data.');
$_DATA = $modx->fromJSON($scriptProperties['data']);
if (!is_array($_DATA)) return $modx->error->failure('Invalid data.');

/* get obj */
if (empty($_DATA['id'])) return $modx->error->failure($modx->lexicon('bookit.error_no_item'));
$item = $modx->getObject('BookItems',$_DATA['id']);
if (empty($item)) return $modx->error->failure($modx->lexicon('bookit.error_no_item'));

$item->fromArray($_DATA);
 
/* save */
if ($item->save() == false) {
    return $modx->error->failure($modx->lexicon('bookit.error_save'));
}
 
return $modx->error->success('',$item);