<?php
if (empty($scriptProperties['id'])) return $modx->error->failure($modx->lexicon('bookit.error_no_item'));
$item = $modx->getObject('BookItems',$scriptProperties['id']);
if (empty($item)) return $modx->error->failure($modx->lexicon('bookit.error_no_item'));
 
if ($item->remove() == false) {
    return $modx->error->failure($modx->lexicon('bookit.error_remove'));
}
 
return $modx->error->success('',$item);