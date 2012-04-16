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
		
		if($credit >= $debt){
			$credit -= $debt;
			$extendedFields["credit"] += $credit;
			if($extendedFields["debt"] > 0){
				$extendedFields["debt"] -= $debt;
				$extendedFields["warnings"] = ($extendedFields["warnings"] == 1)? 0 : 1;
			}
		}else{
			$extendedFields["debt"] -= $credit;
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
