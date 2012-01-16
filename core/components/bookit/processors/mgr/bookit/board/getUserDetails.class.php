<?php
class BookItGetUserDetailsProcessor extends modObjectProcessor {
	public $objectType = 'bookit';
	public $languageTopics = array('bookit:default');
	private $output;

	public function process() {
		$id = $this->getProperty('id');
		$user = $this->modx->getObject("modUser", $id);
		$profile = $user->getOne("Profile");
		$extended = $profile->get("extended");	
		$credit = (intval($extended["credit"]))." Kč";	
		$warnings = (intval($extended["warnings"]));	
		$debt = (intval($extended["debt"]))." Kč";
		
		$this->output = array(
			"phone" => $profile->get('mobilephone'),
			"email" => $profile->get('email'),
			"credit" => $credit,
			"warnings" => $warnings,
			"debt" => $debt
		);
		
		return $this->cleanup();
	}

	public function cleanup() {
		return $this->success('', $this->output);
	}
}
return 'BookItGetUserDetailsProcessor';
