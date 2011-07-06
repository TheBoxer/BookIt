<?php
if(empty($scriptProperties['id'])) return $modx->error->failure($modx->lexicon('bookit.error_no_item'));

if (empty($scriptProperties['openschedule'])) {
    $modx->error->addField('openschedule',$modx->lexicon('bookit.error_no_openschedule'));
}
 
if ($modx->error->hasError()) { return $modx->error->failure(); }
 
$item = $modx->getObject('BookItems', $scriptProperties['id']);
$item->set('openschedule', $scriptProperties['openschedule']);


if ($item->save() == false) {
    return $modx->error->failure($modx->lexicon('bookit.error_save'));
}
 
return $modx->error->success('',$item);