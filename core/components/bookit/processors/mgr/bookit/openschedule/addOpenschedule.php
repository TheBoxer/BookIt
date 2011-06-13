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

/*
$e = $modx->newQuery('BookItemsOpen');

$e->where(
        array(
            'idItem' => $scriptProperties['idItem'],
            'openDay' => $scriptProperties['openDay']
   )
);
$e->andCondition(
                array(
                    'openFrom:<=' => $scriptProperties['openFrom'],
                    'openTo:>=' => $scriptProperties['openFrom']
                ), null, 1);
$e->andCondition(
                array(
                    'OR:openFrom:<=' => $scriptProperties['openTo'],
                    'openTo:>=' => $scriptProperties['openTo']
                ), null, 1);
                
                $e->prepare();
                $modx->fire->warn($e->toSQL(), "sql");
                return;


$e->where(
    array(
        'idItem' => $scriptProperties['idItem'],
        'openDay' => $scriptProperties['openDay'],
        array(
            array(
                'openFrom:<=' => $scriptProperties['openFrom'],
                'openTo:>=' => $scriptProperties['openFrom']
            ),
            array(
                'OR:openFrom:<=' => $scriptProperties['openTo'],
                'openTo:>=' => $scriptProperties['openTo']
            )
        )
    )
);

$e->prepare();
//$modx->fire->warn($e->toSQL(), "SQL");
 */
//$count = $modx->getCount('BookItemsOpen',$e);

$query = "SELECT `BookItemsOpen`.`id` AS `BookItemsOpen_id`, `BookItemsOpen`.`idItem` AS `BookItemsOpen_idItem`, `BookItemsOpen`.`openDay` AS `BookItemsOpen_openDay`, `BookItemsOpen`.`openFrom` AS `BookItemsOpen_openFrom`, `BookItemsOpen`.`openTo` AS `BookItemsOpen_openTo` FROM `modx_book_items_open` AS `BookItemsOpen` WHERE  
    `BookItemsOpen`.`idItem` = ".$scriptProperties['idItem']." AND `BookItemsOpen`.`openDay` = ".$scriptProperties['openDay']." 
    AND 
    (
        ( 
            (
                ( 
                    `BookItemsOpen`.`openFrom` <= '".$scriptProperties['openFrom']."' 
                    AND 
                    `BookItemsOpen`.`openTo` >= '".$scriptProperties['openFrom']."' 
                ) 
                OR 
                ( 
                    `BookItemsOpen`.`openFrom` <= '".$scriptProperties['openTo']."' 
                    AND 
                    `BookItemsOpen`.`openTo` >= '".$scriptProperties['openTo']."' 
                ) 
            )
        ) 
        OR 
        (
            `BookItemsOpen`.`openFrom` >= '".$scriptProperties['openFrom']."' 
            AND 
            `BookItemsOpen`.`openTo` <= '".$scriptProperties['openTo']."'
        )
    )  ";

//$modx->fire->warn($qeury, "query");

$stmt= $modx->query($query);
$stmt->execute();
$results= $stmt->fetchAll(PDO::FETCH_COLUMN);



$count = count($results);
                                       

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