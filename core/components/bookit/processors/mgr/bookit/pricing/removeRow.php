<?php
if (empty($scriptProperties['id'])) return $modx->error->failure($modx->lexicon('bookit.error_no_item'));
$openschedule = $modx->getObject('PricingList',$scriptProperties['id']);
if (empty($openschedule)) return $modx->error->failure($modx->lexicon('bookit.error_no_item'));
 
if ($openschedule->remove() == false) {
    return $modx->error->failure($modx->lexicon('bookit.error_remove'));
}
 
return $modx->error->success('',$openschedule);