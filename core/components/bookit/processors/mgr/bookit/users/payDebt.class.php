<?php
class BookItPayDebtProcessor extends modObjectProcessor {
	public $objectType = 'bookit';
	public $languageTopics = array('bookit:default');
	private $output;

	public function process() {
		$id = $this->getProperty('id');

		$userProfile = $this->modx->getObject("modUser", $id)->getOne("Profile");
		
		$extendedFields = $userProfile->get("extended");
		$debt = $extendedFields["debt"];
		

		$extendedFields["debt"] -= $debt;
		$extendedFields["warnings"] = ($extendedFields["warnings"] == 1)? 0 : 1;
		
		$userProfile->set('extended', $extendedFields);
		$userProfile->save();

        /** @var BookItLog $log */
        $log = $this->modx->newObject('BookItLog');
        $log->logPayDebt($id, $this->modx->user->get('id'), $debt);

		return $this->cleanup();
	}

	public function cleanup() {
		return $this->success();
	}
}
return 'BookItPayDebtProcessor';
