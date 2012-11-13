<?php
class BookItGetReservationProcessor extends modObjectGetListProcessor  {
	private $filterDay;
	
	public function initialize(){
		
		$this->filterDay = $this->getProperty("filterDay");
		if(empty($this->filterDay)){
			$this->filterDay = mktime(0,0,0,date("n"),date("j"),date("Y"));
		}else{
			$this->filterDay = strtotime($this->filterDay);
		}
        return true;
	}
	
	public function process(){
		$board = $this->createBoard();
		
		$c = $this->modx->newQuery('Books');
		$c->where(array("bookDate" => $this->filterDay));

        $items = $this->modx->getIterator('Books', $c);

		foreach ($items as $item) {
			$itemArray = $item->toArray();
			$user = $this->modx->getObject('modUser', $itemArray["idUser"]);
			switch($itemArray["paid"]){
				case 0: $color = 'red'; break;
				case 1: $color = 'green'; break;
				case 2: $color = 'green'; break;
				case 3: $color = 'green'; break;
				case 9: $color = 'black'; break;
				default: $color = 'red';
				
			}

			$board[$itemArray["bookFrom"]] = array_merge($board[$itemArray["bookFrom"]], array("item-".$itemArray["idItem"] => "<span class=\"$color\">".$user->getOne("Profile")->get("fullname")."</span>"));
		}
		
		$retBoard = array();
		foreach($board as $k => $v){
			$temp = array("time" => $k.":00");
			$retBoard[] = array_merge($temp, $v);
		}
		
		return $this->outputArray($retBoard,count($retBoard));
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
}
return 'BookItGetReservationProcessor';
