<?php
class BookItUsersGetListProcessor extends modObjectGetListProcessor {
	public $classKey = 'modUser';
	public $languageTopics = array('bookit:default');
	public $defaultSortField = 'id';
	public $defaultSortDirection = 'DESC';
	public $objectType = 'bookit';
	
	public function prepareQueryBeforeCount(xPDOQuery $c) {
		$c->innerJoin ('modUserProfile','Profile');
		$c->innerJoin ('modUserGroupMember','UserGroupMembers');
		$c->innerJoin ('modUserGroup','UserGroup','`UserGroupMembers`.`user_group` = `UserGroup`.`id`');
		$c->leftJoin ('modUserGroupRole','UserGroupRole','`UserGroupMembers`.`role` = `UserGroupRole`.`id`');
		$c->where(array(
				'UserGroup.name' => 'Customers'
		));
		
		$query = $this->getProperty('query');
		if (!empty($query)) {
			$c->where(array(
					'Profile.fullname:LIKE' => '%'.$query.'%'
			));
		}
		
		return $c;
	}
	
	public function prepareRow(xPDOObject $object) {
		$itemArray = $object->toArray();
		$profile = $object->getOne('Profile');
		$extended = $profile->get('extended');
		
		$itemArray['fullname'] = $profile->get('fullname');
		$itemArray['credit'] = $extended['credit'];
		$itemArray['warnings'] = ($extended['warnings'] == 0)? $extended['warnings'] : "<span class=\"red\">".$extended['warnings']."</span>";
		$itemArray['debt'] = ($extended['debt'] == 0)? $extended['debt'] : "<span class=\"red\">".$extended['debt']."</span>";

		return $itemArray;
	}
}

return 'BookItUsersGetListProcessor';