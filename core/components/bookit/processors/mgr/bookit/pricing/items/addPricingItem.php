<?php
if(empty($scriptProperties['pricing_list'])) {
     $modx->error->failure();
}

$scriptProperties['priceDay'] = $scriptProperties['openDay'];
unset($scriptProperties['openDay']);

if(empty($scriptProperties['priceDay'])) {
    $scriptProperties['priceDay'] = 0;
}


if(empty($scriptProperties['priceFrom'])) {
    $modx->error->addField('priceFrom',$modx->lexicon('bookit.error_no_pricefrom'));
}

if(empty($scriptProperties['priceTo'])) {
    $modx->error->addField('priceTo',$modx->lexicon('bookit.error_no_priceto'));
}

$schedulelist = $modx->getObject('PricingList', $scriptProperties['pricing_list']);
$schedulelistId = $schedulelist->get('openschedule_list');

$schedule = $modx->newQuery('OpenScheduleListItem');
$schedule->where(array(
			'openschedule_list' => $schedulelistId
			,'openDay' => $scriptProperties['priceDay']
			,'openFrom:<=' => $scriptProperties['priceFrom']
			,'openTo:>=' => $scriptProperties['priceTo']
	));

$scheduleCount = $modx->getCount('OpenScheduleListItem',$schedule);

if($scheduleCount == 0){
	$modx->error->addField('openDay',$modx->lexicon('bookit.error_schedule_unexists'));
    $modx->error->addField('priceFrom',$modx->lexicon('bookit.error_schedule_unexists'));
    $modx->error->addField('priceTo',$modx->lexicon('bookit.error_schedule_unexists'));
}

$timeFromArray = explode(":", $scriptProperties['priceFrom']);
$timeToArray = explode(":", $scriptProperties['priceTo']);
$timeFrom = mktime($timeFromArray[0], $timeFromArray[1], 0, 0, 0, 0);
$timeTo = mktime($timeToArray[0], $timeToArray[1], 0, 0, 0, 0);

if($timeFrom >= $timeTo){
	$modx->error->addField('priceFrom',$modx->lexicon('bookit.error_from_gtoe_to'));
    $modx->error->addField('priceTo',$modx->lexicon('bookit.error_from_gtoe_to'));
}


$e = $modx->newQuery('PricingListItem');

$e->where(
    array(
        array(
            array(
                array(
                    'priceFrom:<=' => $scriptProperties['priceFrom'],
                    'priceTo:>=' => $scriptProperties['priceFrom']
                ),
                array(
                    'OR:priceFrom:<=' => $scriptProperties['priceTo'],
                    'priceTo:>=' => $scriptProperties['priceTo']
                )
            ),
            array(
                    'OR:priceFrom:>=' => $scriptProperties['priceFrom'],
                    'priceTo:<=' => $scriptProperties['priceTo']
                )
        ),
        'pricing_list' => $scriptProperties['pricing_list'],
        'priceDay' => $scriptProperties['priceDay'],
    )
);

$count = $modx->getCount('PricingListItem',$e);


if($count != 0){
    $modx->error->addField('openDay',$modx->lexicon('bookit.error_price_exists'));
    $modx->error->addField('priceFrom',$modx->lexicon('bookit.error_price_exists'));
    $modx->error->addField('priceTo',$modx->lexicon('bookit.error_price_exists'));
}

if ($modx->error->hasError()) { return $modx->error->failure(); }

 
$item = $modx->newObject('PricingListItem');
$item->fromArray($scriptProperties);
 
if ($item->save() == false) {
    return $modx->error->failure($modx->lexicon('bookit.error_save'));
}
 
return $modx->error->success('',$item);