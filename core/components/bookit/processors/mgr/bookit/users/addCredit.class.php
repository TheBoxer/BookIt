<?php
class BookItAddCreditProcessor extends modObjectProcessor {
	public $objectType = 'bookit';
	public $languageTopics = array('bookit:default');
	private $output;

	public function process() {
		$id = $this->getProperty('id');
		$credit = $this->getProperty('value');
		
		$creditBonus = $this->modx->getObject("BookItSettigns", array("key" => "credit_bonus"))->get('value');
		
		if(preg_match("/%/", $creditBonus) == 1){
			$creditBonus = str_replace('%', '', $creditBonus);
			$credit = (100+$creditBonus)/100*$credit;
		}else{
			$credit += $creditBonus;
		}

		$userProfile = $this->modx->getObject("modUser", $id)->getOne("Profile");
		
		$extendedFields = $userProfile->get("extended");
		$debt = $extendedFields["debt"];

        /** @var BookItLog $log */
        $log = $this->modx->newObject('BookItLog');

		if($credit >= $debt){
			$credit -= $debt;
            $log->logAddCredit($id, $this->modx->user->get('id'), $credit);

			$extendedFields["credit"] += $credit;
			if($extendedFields["debt"] > 0){
                $log->logPayDebt($id, $this->modx->user->get('id'), $debt);
				$extendedFields["debt"] -= $debt;
				$extendedFields["warnings"] = ($extendedFields["warnings"] == 1)? 0 : 1;
			}
		}else{
			$extendedFields["debt"] -= $credit;
            $log->logPayDebt($id, $this->modx->user->get('id'), $credit);
		}
		
			
		$userProfile->set('extended', $extendedFields);
		$userProfile->save();

		return $this->cleanup();
	}

	public function cleanup() {
		return $this->success();
	}
}
return 'BookItAddCreditProcessor';
