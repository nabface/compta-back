<?php
	
	namespace Compta\DAO;
	
	use Compta\Domain\Group;
	
	class GroupDAO extends DAO {
		
		public function get($info) {
			return $this->getObject($info, 'groups', 'Compta\Domain\Group');
		}
		
		public function listAll() {
			$query = $this->getDb()->createQueryBuilder();
			$query->select('*')
			      ->from('groups');
			$statement = $query->execute();
			$statement->setFetchMode(\PDO::FETCH_CLASS, 'Compta\Domain\Group');
			$group = $statement->fetchAll();
			if (!$group) return false;
			return $group;
		}
		
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