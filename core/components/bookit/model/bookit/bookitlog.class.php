<?php
class BookItLog extends xPDOSimpleObject {

    const NEW_PERMANENT_PASS    = 'log_new_permanent_pass';
    const NEW_BOOK              = 'log_new_book';
    const PAY_DEBT              = 'log_pay_debt';
    const ADD_CREDIT            = 'log_add_credit';
    const ADD_DEBT              = 'log_add_debt';
    const CANCEL_BOOK           = 'log_cancel_book';
    const PAY                   = 'log_pay';
    const PAY_BY_CREDIT         = 'log_pay_by_credit';
    const CLIENT_DIDNT_COME     = 'log_client_didnt_come';

    public function logNewPermanentPass($customer, $operator, $price, $day, $hour, $item){
        $this->log(self::NEW_PERMANENT_PASS, $customer, $operator, $price, $day, $hour, $item);
    }

    public function logAddCredit($customer, $operator, $price){
        $this->log(self::ADD_CREDIT, $customer, $operator, $price);
    }

    public function logPayDebt($customer, $operator, $price){
        $this->log(self::PAY_DEBT, $customer, $operator, $price);
    }
    public function logNewBook($customer, $operator, $price, $day, $hour, $item){
        $this->log(self::NEW_BOOK, $customer, $operator, $price, $day, $hour, $item);
    }

    public function logCancelBook($customer, $operator, $price, $day, $hour, $item){
        $this->log(self::CANCEL_BOOK, $customer, $operator, $price, $day, $hour, $item);
    }

    public function logAddDebt($customer, $operator, $price, $day, $hour, $item){
        $this->log(self::ADD_DEBT, $customer, $operator, $price, $day, $hour, $item);
    }

    public function logPay($customer, $operator, $price, $day, $hour, $item){
        $this->log(self::PAY, $customer, $operator, $price, $day, $hour, $item);
    }

    public function logPayByCredit($customer, $operator, $price, $day, $hour, $item){
        $this->log(self::PAY_BY_CREDIT, $customer, $operator, $price, $day, $hour, $item);
    }

    public function logClientDidntCome($customer, $operator, $price, $day, $hour, $item){
        $this->log(self::PAY_BY_CREDIT, $customer, $operator, $price, $day, $hour, $item);
    }

    private function log($type, $customer, $operator, $price, $day = null, $hour = null, $item = null){
        $this->setType($type);
        $this->setCustomer($customer);
        $this->setOperator($operator);
        $this->setPrice($price);
        $this->setDay($day);
        $this->setHour($hour);
        $this->setItem($item);
        $this->setTimeOfAction();
        $this->save();
    }

    private function setType($type){
        $this->set('type', $type);
    }

    private function setCustomer($id){
        $this->set('customer', $id);
    }

    private function setOperator($id){
        $this->set('operator', $id);
    }

    private function setPrice($price){
        $this->set('price', $price);
    }

    private function setDay($day){
        $this->set('day', $day);
    }

    private function setHour($hour){
        $this->set('hour', $hour);
    }

    private function setItem($item){
        $this->set('item', $item);
    }

    private function setTimeOfAction(){
        $this->set('timeOfAction', time());
    }


}