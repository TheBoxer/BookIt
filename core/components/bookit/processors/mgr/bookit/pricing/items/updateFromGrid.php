<?php
/* parse JSON */
if (empty($scriptProperties['data'])) return $modx->error->failure('Invalid data.');
$_DATA = $modx->fromJSON($scriptProperties['data']);
if (!is_array($_DATA)) return $modx->error->failure('Invalid data.');

/* get obj */
if (empty($_DATA['id'])) return $modx->error->failure($modx->lexicon('bookit.error_no_item'));
$pricing = $modx->getObject('PricingListItem',$_DATA['id']);
if (empty($pricing)) return $modx->error->failure($modx->lexicon('bookit.error_no_item'));

if(empty($_DATA['priceFrom'])) {
    return $modx->error->failure($modx->lexicon('bookit.error_no_pricefrom'));
}

if(empty($_DATA['priceTo'])) {
    return $modx->error->failure($modx->lexicon('bookit.error_no_priceto'));
}

if(empty($_DATA['price']) || ($_DATA['price'] == 0)) {
    return $modx->error->failure($modx->lexicon('bookit.error_no_price'));
}

$timeFromArray = explode(":", $_DATA['priceFrom']);
$timeToArray = explode(":", $_DATA['priceTo']);

$timeFrom = mktime($timeFromArray[0], $timeFromArray[1], 0, 0, 0, 0);
$timeTo = mktime($timeToArray[0], $timeToArray[1], 0, 0, 0, 0);


if($timeFrom >= $timeTo){
	return $modx->error->failure($modx->lexicon('bookit.error_from_gtoe_to'));
}

$schedulelist = $modx->getObject('PricingList', $_DATA['pricing_list']);
$schedulelistId = $schedulelist->get('openschedule_list');

$schedule = $modx->newQuery('OpenScheduleListItem');
$schedule->where(array(
			'openschedule_list' => $schedulelistId
			,'openDay' => $_DATA['priceDay']
			,'openFrom:<=' => $_DATA['priceFrom']
			,'openTo:>=' => $_DATA['priceTo']
	));

$scheduleCount = $modx->getCount('OpenScheduleListItem',$schedule);

if($scheduleCount == 0){
	return $modx->error->failure($modx->lexicon('bookit.error_schedule_unexists'));
}

$e = $modx->newQuery('PricingListItem');

$e->where(
    array(
        array(
            array(
                array(
                    'priceFrom:<' => $_DATA['priceFrom'],
                    'priceTo:>' => $_DATA['priceFrom']
                ),
                array(
                    'OR:priceFrom:<' => $_DATA['priceTo'],
                    'priceTo:>' => $_DATA['priceTo']
                )
            ),
            array(
                    'OR:priceFrom:>=' => $_DATA['priceFrom'],
                    'priceTo:<=' => $_DATA['priceTo']
                )
        ),
        'openschedule_list' => $_DATA['pricing_list'],
        'priceDay' => $_DATA['openDay'],
    )
);

$count = $modx->getCount('PricingListItem',$e);


if($count != 0){
	return $modx->error->failure($modx->lexicon('bookit.error_price_exists'));
}


 

$pricing->fromArray($_DATA);
 
/* save */
if ($pricing->save() == false) {
    return $modx->error->failure($modx->lexicon('bookit.error_save'));
}
 
return $modx->error->success('',$pricing);