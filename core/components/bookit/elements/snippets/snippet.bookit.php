<?php
$bookit = $modx->getService('bookit','BookIt',$modx->getOption('bookit.core_path',null,$modx->getOption('core_path').'components/bookit/').'model/bookit/',$scriptProperties);
if (!($bookit instanceof BookIt)) return '';

/* setup default properties */
$tpl = $modx->getOption('tpl',$scriptProperties,'rowTpl');
$sort = $modx->getOption('sort',$scriptProperties,'name');
$dir = $modx->getOption('dir',$scriptProperties,'ASC');
 
$output = '';


$m = $modx->getManager();
$m->createObjectContainer('OpenScheduleList');
$m->createObjectContainer('OpenScheduleListItem');
$m->createObjectContainer('PricingList');
$m->createObjectContainer('PricingListItem');
$m->createObjectContainer('BookItems');
$m->createObjectContainer('Books');
return 'Table created.';

 
$c = $modx->newQuery('BookItDB');
$c->sortby($sort,$dir);
$g = $modx->getCollection('BookItDB',$c);

foreach ($g as $gal) {
    $galArray = $gal->toArray();
    $output .= $bookit->getChunk($tpl,$galArray);
}
 
return $output;
