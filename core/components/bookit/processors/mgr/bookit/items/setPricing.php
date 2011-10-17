<?php
if(empty($scriptProperties['id'])) return $modx->error->failure($modx->lexicon('bookit.error_no_item'));

if (empty($scriptProperties['pricing'])) {
    $modx->error->addField('pricing',$modx->lexicon('bookit.error_no_pricing'));
}
 
if ($modx->error->hasError()) { return $modx->error->failure(); }
 
$item = $modx->getObject('BookItems', $scriptProperties['id']);
$item->set('pricing', $scriptProperties['pricing']);


if ($item->save() == false) {
    return $modx->error->failure($modx->lexicon('bookit.error_save'));
}
 
return $modx->error->success('',$item);