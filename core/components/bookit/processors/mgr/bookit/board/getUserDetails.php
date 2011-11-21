<?php
$user = $modx->getObject("modUser", $scriptProperties["id"]);
$profile = $user->getOne("Profile");

$ret = array(
			"phone" => $profile->get('mobilephone'),
			"email" => $profile->get('email')
		);

return $modx->error->success('', $ret);