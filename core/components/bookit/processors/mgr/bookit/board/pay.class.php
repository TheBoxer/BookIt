<?php
class BookItPayProcessor extends modObjectProcessor {
    public $objectType = 'bookit';
    public $languageTopics = array('bookit:default');

    public function process() {
        $id = $this->getProperty('id');

        $book = $this->modx->getObject ("Books", $id);


        $book->set("paid", 1);
        $book->save();

        $day = date("N", strtotime($book->get("bookDate")))-1;
        $item = $this->modx->getObject("BookItems", $book->get("idItem"));

        $pricing = $this->modx->getObject("PricingListItem",array(
            "pricing_list" => $item->get("pricing"),
            "priceDay" => $day,
            "priceFrom:<=" => $book->get("bookFrom").":00:00",
            "priceTo:>" => $book->get("bookFrom").":00:00"
        ));

        $price = $pricing->get('price');

        /** @var BookItLog $log */
        $log = $this->modx->newObject('BookItLog');
        $log->logPay($book->get('idUser'), $this->modx->user->get('id'), $price, $book->get('bookDate'), $book->get('bookFrom'), $book->get('idItem'));

        return $this->cleanup();
    }

    public function cleanup() {
        return $this->success();
    }
}
return 'BookItPayProcessor';
