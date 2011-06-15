<?php
/* parse JSON */
if (empty($scriptProperties['data'])) return $modx->error->failure('Invalid data.');
$_DATA = $modx->fromJSON($scriptProperties['data']);
if (!is_array($_DATA)) return $modx->error->failure('Invalid data.');


 
/* get obj */
if (empty($_DATA['id'])) return $modx->error->failure($modx->lexicon('bookit.error_no_item'));
$openschedule = $modx->getObject('OpenScheduleListItem',$_DATA['id']);
if (empty($openschedule)) return $modx->error->failure($modx->lexicon('bookit.error_no_item'));

$e = $modx->newQuery('OpenScheduleListItem');

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
        'openschedule_list' => $_DATA['openschedule_list'],
        'openDay' => $_DATA['openDay'],
    )
);

$count = $modx->getCount('OpenScheduleListItem',$e);


if($count != 0){
	return $modx->error->failure($modx->lexicon('bookit.error_schedule_exists'));
}


 

$openschedule->fromArray($_DATA);
 
/* save */
if ($openschedule->save() == false) {
    return $modx->error->failure($modx->lexicon('bookit.error_save'));
}
 
return $modx->error->success('',$openschedule);