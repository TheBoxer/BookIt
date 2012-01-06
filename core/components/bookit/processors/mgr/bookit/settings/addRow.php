<?php
if(empty($scriptProperties['key'])) {
    $modx->error->addField('key',$modx->lexicon('bookit.error_no_key'));
}


if ($modx->error->hasError()) { return $modx->error->failure(); }

 
$item = $modx->newObject('BookItSettigns');
$item->fromArray($scriptProperties);
 
if ($item->save() == false) {
    return $modx->error->failure($modx->lexicon('bookit.error_save'));
}
 
return $modx->error->success('',$item);