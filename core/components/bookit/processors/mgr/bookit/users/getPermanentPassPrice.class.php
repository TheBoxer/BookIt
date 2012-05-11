<?php
class BookItGetPermanentPassPriceProcessor extends modObjectProcessor {
	public $objectType = 'bookit';
	public $languageTopics = array('bookit:default');
	private $price;

	public function process() {
        $item = $this->getProperty('item');
        $time = $this->getProperty('time');
        $date = $this->getProperty('date');

        if(empty($item) || empty($time)){
            return $this->failure();
        }

        $countingDate = (!empty($date))? strtotime($date) : mktime(0,0,0,date("n"),date("j"),date("Y"));
        $time = explode(":", $time);
        $time = $time[0];

        $bookItem = $this->modx->getObject("BookItems", $item);
        $day = date("N", $countingDate)-1;

        $pricing = $this->modx->getObject("PricingListItem",array(
            "pricing_list" => $bookItem->get("pricing"),
            "priceDay" => $day,
            "priceFrom:<=" => $time.":00:00",
            "priceTo:>" => $time.":00:00"
        ));
        $price = $pricing->get('price');


        $endDate = strtotime($this->modx->getObject("BookItSettigns", array("key" => "season_end"))->get('value'));
        $weeksCount = 0;
        while($countingDate < $endDate){
            $weeksCount++;
            $countingDate = strtotime("+7 days",$countingDate);
        }



        $permanent_discount = $this->modx->getObject("BookItSettigns", array("key" => "permanent_discount"))->get('value');
        if(preg_match("/%/", $permanent_discount) == 1){
            $price = (100-$permanent_discount)/100*$price;
        }else{
            $price -= $permanent_discount;
        }

        $this->price = $price * $weeksCount . " Kč";

		return $this->cleanup();
	}

	public function cleanup() {
		return $this->success('', array('permanentPassPrice' => $this->price));
	}
}
return 'BookItGetPermanentPassPriceProcessor';
