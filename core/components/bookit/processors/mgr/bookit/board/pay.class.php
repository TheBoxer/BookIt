<?php
class BookItPayProcessor extends modObjectProcessor {
    public $objectType = 'bookit';
    public $languageTopics = array('bookit:default');

    public function process() {
        $id = $this->getProperty('id');

        $book = $this->modx->getObject ("Books", $id);


        $book->set("paid", 1);
        $book->save();

        return $this->cleanup();
    }

    public function cleanup() {
        return $this->success();
    }
}
return 'BookItPayProcessor';
