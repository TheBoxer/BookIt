<?php
/* parse JSON */
if (empty($scriptProperties['data'])) return $modx->error->failure('Invalid data.');
$_DATA = $modx->fromJSON($scriptProperties['data']);
if (!is_array($_DATA)) return $modx->error->failure('Invalid data.');


$e = $modx->newQuery('BookItemsOpen');

$e->where(
    array(
        array(
            array(
                array(
                    'openFrom:<=' => $_DATA['openFrom'],
                    'openTo:>=' => $_DATA['openFrom']
                ),
                array(
                    'OR:openFrom:<=' => $_DATA['openTo'],
                    'openTo:>=' => $_DATA['openTo']
                )
            ),
            array(
                    'OR:openFrom:>=' => $_DATA['openFrom'],
                    'openTo:<=' => $_DATA['openTo']
                )
        ),
        'idItem' => $_DATA['idItem'],
        'openDay' => $_DATA['openDay'],
    )
);

$count = $modx->getCount('BookItemsOpen',$e);


if($count != 0){
     return $modx->error->failure($modx->lexicon('bookit.error_schedule_exists'));
}
 
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