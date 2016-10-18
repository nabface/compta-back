<?php
	
	namespace Compta\DAO;
	
	use Compta\Domain\User;
	
	class UserDAO extends DAO {
		
		private function get($info) {
			$where = ($info == (int) $info) ? 'id = :info' : 'name = :info' ;
			$query = $this->getDb()->createQueryBuilder();
			$query->select('*')
			      ->from('users')
			      ->where($where)
			      ->setParameter(':info', $info);
			$statement = $query->execute();
			$statement->setFetchMode(\PDO::FETCH_CLASS, 'Compta\Domain\User');
			return $statement->fetch();
		}
		
		public function findByGroup($group_id) {
			$query = $this->getDb()->createQueryBuilder();
			$query->select('*')
			      ->from('mapping_groups')
			      ->where('group_id = :group_id')
			      ->setParameter(':group_id', $group_id);
			$answer = $query->execute()->fetchAll(\PDO::FETCH_ASSOC);
			$users = [];
			foreach ($answer as $row) $users[] = $this->get($row['user_id']);
			return $users;
		}
		
		public function removeFromGroup($group_id) {
			//TODO
		}
		
		public function save(User $user) {
			//TODO
		}
		
		public function delete($id) {
			$this->getDb()->delete('users', array('id' => $id));
		}
		
	}
	
?>