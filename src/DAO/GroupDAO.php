<?php
	
	namespace Compta\DAO;
	
	use Compta\Domain\Group;
	
	class GroupDAO extends DAO {
		
		public function get($info) {
			$where = (is_numeric($info)) ? 'id = :info' : 'name = :info' ;
			$query = $this->getDb()->createQueryBuilder();
			$query->select('*')
			      ->from('groups')
			      ->where($where)
			      ->setParameter(':info', $info);
			$statement = $query->execute();
			$statement->setFetchMode(\PDO::FETCH_CLASS, 'Compta\Domain\Group');
			return $statement->fetch();
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