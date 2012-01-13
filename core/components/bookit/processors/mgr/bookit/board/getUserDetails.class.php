<?php
class GetUserDetailsProcessor extends modObjectProcessor {
	public $objectType = 'bookit';
	public $languageTopics = array('bookit:default');
	private $output;

	public function process() {
		$id = $this->getProperty('id');
		$user = $this->modx->getObject("modUser", $id);
		$profile = $user->getOne("Profile");
		
		$this->output = array(
			"phone" => $profile->get('mobilephone'),
			"email" => $profile->get('email')
		);
		
		return $this->cleanup();
	}

	public function cleanup() {
		return $this->success('', $this->output);
	}
}
return 'GetUserDetailsProcessor';
