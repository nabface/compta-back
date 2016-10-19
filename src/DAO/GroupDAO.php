<?php
	
	namespace Compta\DAO;
	
	use Compta\Domain\Group;
	
	class GroupDAO extends DAO {
		
		public function get($id) {
			$query = $this->getDb()->createQueryBuilder();
			$query->select('*')
			      ->from('groups')
			      ->where('id = :id')
			      ->setParameter(':id', $id);
			$result = $query->execute()->fetch(\PDO::FETCH_ASSOC);
			$group = new Group();
			$group->setId($result['id'])
			     ->setName($result['name']);
			return $group;
		}
		
		public function listAll() {
			$query = $this->getDb()->createQueryBuilder();
			$query->select('*')
			      ->from('groups');
			$statement = $query->execute();
			$statement->setFetchMode(\PDO::FETCH_CLASS, 'Compta\Domain\Group');
			return $statement->fetchAll();
		}
		
		public function findByUser($user_id) {
			// TODO
			return $this;
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