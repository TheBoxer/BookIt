<?php
class BookItPrintManagerController extends BookItManagerController {
	public function process(array $scriptProperties = array()) {

	}
	public function getPageTitle() {
		return $this->modx->lexicon('bookit.log');
	}

	public function checkPermissions() {
		if(!$this->modx->hasPermission('bookit.log')) return false;
		return true;
	}

	public function loadCustomCssJs() {

	}

	public function getTemplateFile() {
		return $this->bookit->config['templatesPath'].'log.tpl';
	}

    public function getHeader(){
        $filterDay = mktime(0,0,0,date("n"),date("j"),date("Y"));
        $this->getTable($filterDay);
        $this->getTable(strtotime("+1 day",$filterDay));
        $this->getTable(strtotime("+2 day",$filterDay));
        $this->getTable(strtotime("+3 day",$filterDay));
        $this->getTable(strtotime("+4 day",$filterDay));
        $this->getTable(strtotime("+5 day",$filterDay));
        $this->getTable(strtotime("+6 day",$filterDay));


    }

    private function getTable($time){
        $a = $this->prepareArray($time);
        echo "<style>
        table{
            float: left;
            text-align: center;
        }

        table td{
            width: 40px;
            border-right: thin solid black;
            border-top: thin solid black;
        }

        .time{
            width: 20px;
        }

        </style>";
        echo "<table cellpadding='0' cellspacing='0'><tr><th>".date("d/m", $time)."</th><th>1</th><th>2</th><th>3</th><th>4</th><th>5</th></tr>";
        foreach($a as $r){
            echo "<tr><td class='time'>$r[time]</td>";
            if(!empty($r['#1'])){
                echo "<td>".$r['#1']."</td>";
            }else{
                 echo "<td>&nbsp;</td>";
            }

            if(!empty($r['#2'])){
                echo "<td>".$r['#2']."</td>";
            }else{
                echo "<td>&nbsp;</td>";
            }

            if(!empty($r['#3'])){
                echo "<td>".$r['#3']."</td>";
            }else{
                echo "<td>&nbsp;</td>";
            }

            if(!empty($r['#4'])){
                echo "<td>".$r['#4']."</td>";
            }else{
                echo "<td>&nbsp;</td>";
            }

            if(!empty($r['#5'])){
                echo "<td>".$r['#5']."</td>";
            }else{
                echo "<td>&nbsp;</td>";
            }

        }
        echo "</table>";

    }

    private function createBoard(){
        $c = $this->modx->newQuery('OpenScheduleListItem');
        $c->select('MIN(openFrom) AS openFromMin');
        $c->select('MAX(openTo) AS openToMax');
        $c->prepare();
        $item = $this->modx->getObject('OpenScheduleListItem', $c);

        $openFrom = explode(":", $item->get('openFromMin'));
        $openFrom = (int) $openFrom[0];
        $openTo = explode(":", $item->get('openToMax'));
        $openTo = (int) $openTo[0];

        $board = array();

        for($i = $openFrom; $i < $openTo; $i++){
            $board[$i] = array();
        }

        return $board;
    }

    private function prepareArray($time){
        $board = $this->createBoard();

        $c = $this->modx->newQuery('Books');
        $c->where(array("bookDate" => $time));

        $items = $this->modx->getIterator('Books', $c);

        foreach ($items as $item) {
            $itemArray = $item->toArray();
            $user = $this->modx->getObject('modUser', $itemArray["idUser"]);
            $bookitItem = $this->modx->getObject('BookItems', $itemArray["idItem"]);
            $itemName = $bookitItem->get('name');
            preg_match("|\d+|", $itemName, $m);

            $name = $user->getOne("Profile")->get("fullname");
            $name = explode(" ", $name);
            if(count($name) > 1){
                $name = $name[1];
            }else{
                $name = $name[0];
            }
            $board[$itemArray["bookFrom"]] = array_merge($board[$itemArray["bookFrom"]], array('#'.$m[0] => $name));

        }

        $retBoard = array();
        foreach($board as $k => $v){
            $temp = array("time" => $k);
            $retBoard[] = array_merge($temp, $v);
        }

        return $retBoard;
    }
}