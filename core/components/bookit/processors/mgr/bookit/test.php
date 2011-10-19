<?php

$ret = array();

$ret[] = array("surname" => "test", "firstname" => "ja");

ChromePhp::warn("test");

return $modx->error->success('', array('surname'=> "aaa", 'firstname' => 'ja'));