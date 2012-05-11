<?php             
class BookItGetEmployeeExtraProcessor extends modObjectGetListProcessor  {
	public function process(){
		$query = $this->getProperty('query');
		
		$c = $this->modx->newQuery('modUser');

        $c->where(array(
            'UserGroup.name' => 'Employees'
        ));
		if($query != ""){

			$c->where(array(
                'Profile.fullname:LIKE' => '%'.$query.'%'
            ));
		}

		$records = $this->modx->getCollectionGraph('modUser', '{ "Profile":{}, "UserGroupMembers":{ "UserGroup":{} } }', $c);
		
		$list = array();

		foreach ($records as $record) {
			$list[] = array("id" => $record->get('id'), "fullname" => $record->getOne('Profile')->get('fullname'));
		}

		return $this->outputArray($list);
	}


}
return 'BookItGetEmployeeExtraProcessor';
