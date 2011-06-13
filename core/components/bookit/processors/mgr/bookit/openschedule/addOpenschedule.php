<?php
if(empty($scriptProperties['idItem'])) {
     $modx->error->failure();
}

if(empty($scriptProperties['openDay'])) {
    $scriptProperties['openDay'] = 0;
}

if(empty($scriptProperties['openFrom'])) {
    $modx->error->addField('openFrom',$modx->lexicon('bookit.error_no_openfrom'));
}

if(empty($scriptProperties['openTo'])) {
    $modx->error->addField('openTo',$modx->lexicon('bookit.error_no_opentp'));
}


$e = $modx->newQuery('BookItemsOpen');

$e->where(
    array(
        array(
            array(
                array(
                    'openFrom:<=' => $scriptProperties['openFrom'],
                    'openTo:>=' => $scriptProperties['openFrom']
                ),
                array(
                    'OR:openFrom:<=' => $scriptProperties['openTo'],
                    'openTo:>=' => $scriptProperties['openTo']
                )
            ),
            array(
                    'OR:openFrom:>=' => $scriptProperties['openFrom'],
                    'openTo:<=' => $scriptProperties['openTo']
                )
        ),
        'idItem' => $scriptProperties['idItem'],
        'openDay' => $scriptProperties['openDay'],
    )
);

$count = $modx->getCount('BookItemsOpen',$e);


if($count != 0){
    $modx->error->addField('openDay',$modx->lexicon('bookit.error_schedule_exists'));
    $modx->error->addField('openFrom',$modx->lexicon('bookit.error_schedule_exists'));
    $modx->error->addField('openTo',$modx->lexicon('bookit.error_schedule_exists'));
}

if ($modx->error->hasError()) { return $modx->error->failure(); }

 
$item = $modx->newObject('BookItemsOpen');
$item->fromArray($scriptProperties);
 
if ($item->save() == false) {
    return $modx->error->failure($modx->lexicon('bookit.error_save'));
}
 
return $modx->error->success('',$item);