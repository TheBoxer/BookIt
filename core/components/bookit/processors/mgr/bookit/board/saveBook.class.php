<?php
class BookItSaveBookCreditProcessor extends modObjectProcessor {
	public $objectType = 'bookit';
	public $languageTopics = array('bookit:default');
	private $newBook;

	public function process() {
		$user = $this->getProperty('user');
		$phone = $this->getProperty('phone');
		$date = $this->getProperty('date');
		$time = $this->getProperty('time');
		$count = $this->getProperty('count');
		$item = $this->getProperty('items');
		$email = $this->getProperty('email');
		
		if(empty($user)){
			$this->addFieldError('user', $this->modx->lexicon('bookit.error_no_user'));
		}
		if(empty($phone)){
			$this->addFieldError('phone', $this->modx->lexicon('bookit.error_no_phone'));
		}
		
		$date = (!empty($date))? strtotime($date) : mktime(0,0,0,date("n"),date("j"),date("Y"));
		$time = explode(":", $time);
		$time = $time[0];
		
		$range = range($time, $time-1+$count);
		
		$oldBooks = $this->modx->newQuery('Books');
		$oldBooks->where(array(
				"bookDate" => $date,
				"idItem" => $item,
				"bookFrom:IN" => $range
				));
		
		$oldBooksCollection = $this->modx->getCollection('Books', $oldBooks);
		if(count($oldBooksCollection) != 0){
			$this->addFieldError('date', $this->modx->lexicon('bookit.error_date_time_occupied'));
			$this->addFieldError('time', $this->modx->lexicon('bookit.error_date_time_occupied'));
			$this->addFieldError('count', $this->modx->lexicon('bookit.error_date_time_occupied'));
			$this->addFieldError('sliderCount', $this->modx->lexicon('bookit.error_date_time_occupied'));
		}

        if ($this->hasErrors()) {
            return $this->failure();
        }

		if(intval($user) == 0){
			$username = str_replace(" ", ".", trim(strtolower($this->modx->translit->translate($user, "noaccents"))));
			
			$userObject = $this->modx->getObject("modUser", array("username" => $username));
		
			while(!empty($userObject)){
				$username = $username . rand(111,999);
				$userObject = $this->modx->getObject("modUser", array("username" => $username));
			}
			
			$email = (empty($email)) ? "anonym@tenistop.cz" : $email;
			
			$newUser = $this->modx->newObject('modUser');
			$newUser->set("username", $username);
			$newUser->set("password", $username.rand(11111,99999).$username);
			$newUser->set("active", 0);
			
			$newUserProfile = $this->modx->newObject('modUserProfile');
			$newUserProfile->set('fullname',$user);
			$newUserProfile->set('email',$email);
			$newUserProfile->set('mobilephone', $phone);
			$extended = array('credit' => '0', 'warnings' => '0', 'debt' => '0');
			$newUserProfile->set('extended', $extended);
			
			$success = $newUser->addOne($newUserProfile);
			if($success){
				$newUser->save();
				$newUser->joinGroup('Customers');

			}else{
				return $this->failure();
			}
		}else{
			$profile = $this->modx->getObject('modUser', $user)->getOne('Profile');
			$extended = $profile->get('extended');
			$maxWarnings = $this->modx->getObject("BookItSettigns", array("key" => "max_warnings"))->get('value');
			
			if($extended['warnings'] >= $maxWarnings){
				return $this->failure($this->modx->lexicon('bookit.error_max_warnings_reached'));
			}
		}
		
		$max = $time+$count;
		$uid = (intval($user) == 0) ? $newUser->get('id') : intval($user);

        /** @var BookItLog $log */
        $log = $this->modx->newObject('BookItLog');

		for($i = $time; $i < $max; $i++){
						
			$userProfile = $this->modx->getObject("modUser", $uid)->getOne("Profile");
			
			$extendedFields = $userProfile->get("extended");
			$credit = $extendedFields["credit"];
			
			$day = date("N", $date)-1;
			$itemb = $this->modx->getObject("BookItems", $item);
			
			$pricing = $this->modx->getObject("PricingListItem",array(
					"pricing_list" => $itemb->get("pricing"),
					"priceDay" => $day,
					"priceFrom:<=" => $i.":00:00",
					"priceTo:>" => $i.":00:00"
			));
			
			$price = $pricing->get('price');
			
			$this->newBook = $this->modx->newObject('Books');
			$this->newBook->set("idUser", $uid);
			$this->newBook->set("bookDate", $date);
			$this->newBook->set("idItem", $item);
			$this->newBook->set("bookFrom", $i);
			
			if($credit >= $price){
				$extendedFields["credit"] -= $price;
				$userProfile->set('extended', $extendedFields);
				$userProfile->save();
					
				$this->newBook->set("paid", 2);
			}
			
			$this->newBook->save();
            $log->logNewBook($uid, $this->modx->user->get('id'), $price, $date, $i, $item);
		}




		return $this->cleanup();
	}

	public function cleanup() {
		return $this->success('', $this->newBook);
	}
}
return 'BookItSaveBookCreditProcessor';
