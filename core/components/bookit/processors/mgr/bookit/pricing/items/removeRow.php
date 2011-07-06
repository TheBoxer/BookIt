<?php
if (empty($scriptProperties['id'])) return $modx->error->failure($modx->lexicon('bookit.error_no_item'));
$pricing = $modx->getObject('PricingListItem',$scriptProperties['id']);
if (empty($pricing)) return $modx->error->failure($modx->lexicon('bookit.error_no_item'));
 
if ($pricing->remove() == false) {
    return $modx->error->failure($modx->lexicon('bookit.error_remove'));
}
 
return $modx->error->success('',$pricing);