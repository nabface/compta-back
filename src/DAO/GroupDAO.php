<?php
	
	namespace Compta\DAO;
	
	use Compta\Domain\Group;
	
	class GroupDAO extends DAO {
		
		public function save(Group $group) {
			$data = array(
				'name' => $group->getName()
			);
			$id = $group->getId();
			if ( $id != NULL)
				$this->getDb()->update('groups', $data, array('id' => $id));
			else {
				$this->getDb()->insert('groups', $data);
				$id = $this->getDb()->lastInsertId();
				$group->setId($id);
			}
		}
		
		public function delete($id) {
			$this->getDb()->delete('groups', array('id' => $id));
		}
		
	}
	
?>