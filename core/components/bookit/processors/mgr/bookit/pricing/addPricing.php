<?php
if(empty($scriptProperties['openschedule_list'])) {
    return $modx->error->failure($modx->lexicon('bookit.error_no_item'));
}

if(empty($scriptProperties['name'])) {
    $modx->error->addField('name',$modx->lexicon('bookit.error_no_name'));
}


if ($modx->error->hasError()) { return $modx->error->failure(); }

 
$item = $modx->newObject('PricingList');
$item->fromArray($scriptProperties);
 
if ($item->save() == false) {
    return $modx->error->failure($modx->lexicon('bookit.error_save'));
}
 
return $modx->error->success('',$item);