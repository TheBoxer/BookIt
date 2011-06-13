<?php
if (empty($scriptProperties['name'])) {
    $modx->error->addField('name',$modx->lexicon('bookit.error_no_item_name'));
} else {
    $alreadyExists = $modx->getObject('BookItems',array('name' => $scriptProperties['name']));
    if ($alreadyExists) {
        $modx->error->addField('name',$modx->lexicon('bookit.error_name_exists'));
    }
}
 
if ($modx->error->hasError()) { return $modx->error->failure(); }
 
$item = $modx->newObject('BookItems');
$item->fromArray($scriptProperties);
 
if ($item->save() == false) {
    return $modx->error->failure($modx->lexicon('bookit.error_save'));
}
 
return $modx->error->success('',$item);