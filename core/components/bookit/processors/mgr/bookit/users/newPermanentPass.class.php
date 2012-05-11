<?php
class BookItNewPermanentPassProcessor extends modObjectProcessor {
	public $objectType = 'bookit';
	public $languageTopics = array('bookit:default');
	private $output;

	public function process() {
        $user = $this->getProperty('user');
        $phone = $this->getProperty('phone');
        $date = $this->getProperty('date');
        $time = $this->getProperty('time');
        $item = $this->getProperty('items');
        $email = $this->getProperty('email');

        if(empty($user)){
            $this->addFieldError('user', $this->modx->lexicon('bookit.error_no_user'));
        }
        if(empty($phone)){
            $this->addFieldError('phone', $this->modx->lexicon('bookit.error_no_phone'));
        }

        if(empty($time)){
            $this->addFieldError('time', $this->modx->lexicon('bookit.error_no_time'));
        }
        if(empty($item)){
            $this->addFieldError('items', $this->modx->lexicon('bookit.error_no_item_selected'));
        }

        if ($this->hasErrors()) {
            return $this->failure();
        }

        $date = (!empty($date))? strtotime($date) : mktime(0,0,0,date("n"),date("j"),date("Y"));
        $time = explode(":", $time);
        $time = $time[0];

        $countingDate = $date;
        $endDate = strtotime($this->modx->getObject("BookItSettigns", array("key" => "season_end"))->get('value'));
        $rangeDate = array();

        while($countingDate < $endDate){
            $rangeDate[] = $countingDate;
            $countingDate = strtotime("+7 days",$countingDate);
        }

        $oldBooks = $this->modx->newQuery('Books');
        $oldBooks->where(array(
            "bookDate:IN" => $rangeDate,
            "idItem" => $item,
            "bookFrom" => $time
            ));

        $oldBooksCollection = $this->modx->getCollection('Books', $oldBooks);
        if(count($oldBooksCollection) != 0){
            $occupied = 'Nelze vytvořit permanentku.<br>Tyto termíny nejsou volné:<br>';
            foreach($oldBooksCollection as $oldBook){
                $occupied .= date('d.m.Y', strtotime($oldBook->get('bookDate')))."<br>";
            }
            return $this->failure($occupied);
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

        $uid = (intval($user) == 0) ? $newUser->get('id') : intval($user);

        foreach($rangeDate as $date){
            $newBook = $this->modx->newObject('Books');
            $newBook->set("idUser", $uid);
            $newBook->set("bookDate", $date);
            $newBook->set("idItem", $item);
            $newBook->set("bookFrom", $time);
            $newBook->set("paid", 3);
            $newBook->save();
        }

        $day = date("N", $date)-1;
        $bookItem = $this->modx->getObject("BookItems", $item);
        $pricing = $this->modx->getObject("PricingListItem",array(
            "pricing_list" => $bookItem->get("pricing"),
            "priceDay" => $day,
            "priceFrom:<=" => $time.":00:00",
            "priceTo:>" => $time.":00:00"
        ));
        $price = $pricing->get('price');

        $permanent_discount = $this->modx->getObject("BookItSettigns", array("key" => "permanent_discount"))->get('value');
        if(preg_match("/%/", $permanent_discount) == 1){
            $price = (100-$permanent_discount)/100*$price;
        }else{
            $price -= $permanent_discount;
        }

        $price = $price * count($rangeDate);

        /** @var BookItLog $log */
        $log = $this->modx->newObject('BookItLog');

        $log->logNewPermanentPass($uid, $this->modx->user->get('id'), $price, $rangeDate[0], $time, $item);

        return $this->cleanup();
	}

	public function cleanup() {
		return $this->success();
	}
}
return 'BookItNewPermanentPassProcessor';
