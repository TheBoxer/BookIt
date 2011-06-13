<?php
require_once dirname(dirname(__FILE__)).'/model/bookit/bookit.class.php';
$bookit = new BookIt($modx);

return $bookit->initialize('mgr');