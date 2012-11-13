<?php
class BookItGetPriceProcessor extends modObjectProcessor {
	public $objectType = 'bookit';
	public $languageTopics = array('bookit:default');
	private $output;

	public function process() {
		$colName = $this->getProperty('colName');
		$time = $this->getProperty('time');
		$date = $this->getProperty('date');
        $id = $this->getProperty('id');

        if(!isset($id)){
            $itemid = explode("-", $colName);
            $itemid = $itemid[1];
            $time = explode(":", $time);
            $time = $time[0];

            $date = (!empty($date))? strtotime($date) : mktime(0,0,0,date("n"),date("j"),date("Y"));
            $where = array("idItem" => $itemid, "bookFrom" => $time, "bookDate" => $date);
        }else{
            $where = $id;
        }

		$book = $this->modx->getObject("Books", $where);

		$day = date("N", strtotime($book->get("bookDate")))-1;
		$item = $this->modx->getObject("BookItems", $book->get("idItem"));
        $time = $book->get('bookFrom');

		$pricing = $this->modx->getObject("PricingListItem",array(
				"pricing_list" => $item->get("pricing"),
				"priceDay" => $day,
				"priceFrom:<=" => $book->get("bookFrom").":00:00",
				"priceTo:>" => $book->get("bookFrom").":00:00"
				));

		$price = $pricing->get('price');
		$this->output = array(
            'id' => $book->get('id'),
            'price' => $price . " Kč",
            'time' => $time . ":00",
            'item' => $item->get('name')
        );

		return $this->cleanup();
	}

	public function cleanup() {
		return $this->success('', $this->output);
	}
}
return 'BookItGetPriceProcessor';
