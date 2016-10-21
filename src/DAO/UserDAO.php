<?php
	
	namespace Compta\DAO;
	
	use Compta\Domain\User;
	
	class UserDAO extends DAO {
		
		private $depenseDAO;
		
		public function getDepenseDAO() { return $this->depenseDAO; }
		
		public function setDepenseDAO(DepenseDAO $depenseDAO) {
			$this->depenseDAO = $depenseDAO;
		}
		
		public function get($info) {
			$where = (is_numeric($info)) ? 'id = :info' : 'name = :info' ;
			$query = $this->getDb()->createQueryBuilder();
			$query->select('*')
			      ->from('users')
			      ->where($where)
			      ->setParameter(':info', $info);
			$statement = $query->execute();
			$statement->setFetchMode(\PDO::FETCH_CLASS, 'Compta\Domain\User');
			$user = $statement->fetch();
			if ($user) {
				$query = $this->getDb()->createQueryBuilder();
				$query->select('*')
				      ->from('mapping_groups')
				      ->where('user_id = :user_id')
				      ->setParameter(':user_id', $user->getId());
				$answer = $query->execute()->fetchAll(\PDO::FETCH_ASSOC);
				$groups = [];
				foreach ($answer as $row) {
					$groups[] = $row['group_id'];
				}
				$user->setGroups($groups);
			}
			return $user;
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
		
		public function save(User $user) {
			// create/update entry in 'users' table
			$data = array(
				'name' => $user->getName(),
				'color' => $user->getColor()
			);
			$id = $user->getId();
			if ( $id != NULL)
				$this->getDb()->update('users', $data, array('id' => $id));
			else {
				$this->getDb()->insert('users', $data);
				$id = $this->getDb()->lastInsertId();
				$user->setId($id);
			}
			// get entries from 'mapping_groups' table
			$query = $this->getDb()->createQueryBuilder();
			$query->select('*')
			      ->from('mapping_groups')
			      ->where('user_id = :user_id')
			      ->setParameter(':user_id', $user->getId());
			$answer = $query->execute()->fetchAll(\PDO::FETCH_ASSOC);
			$groups = $user->getGroups();
			// create entries in 'mapping_groups' table
			foreach ($groups as $group) {
				$found = false;
				foreach ($answer as $row)
					if ($row['group_id'] == $group) $found = true;
				if (!$found)
					$this->getDb()->insert('mapping_groups', array(
						'user_id' => $id,
						'group_id' => $group
					));
			}
			// remove entries in 'mapping_groups' table
			foreach ($answer as $row) {
				$found = false;
				foreach ($groups as $group)
					if ($row['group_id'] == $group) $found = true;
				if (!$found) {
					$this->getDb()->delete('mapping_groups', array(
						'user_id' => $id,
						'group_id' => $row['group_id']
					));
				}
			}
		}
		
		public function delete($id) {
			$this->getDb()->delete('users', array('id' => $id));
			$this->getDb()->delete('mapping_groups', array('user_id' => $id));
			$this->getDepenseDAO()->deleteByUser($id);
		}
		
		public function removeFromGroup($group_id) {
			// get entries from 'mapping_groups' table
			$query = $this->getDb()->createQueryBuilder();
			$query->select('*')
			      ->from('mapping_groups')
			      ->where('group_id = :group_id')
			      ->setParameter(':group_id', $group_id);
			$answer = $query->execute()->fetchAll(\PDO::FETCH_ASSOC);
			// remove unreferenced entries from 'users' table
			foreach ($answer as $row) {
				$id = $row['user_id'];
				$user = $this->get($id)->removeGroup($group_id);
				if ($user->getGroups() == NULL) $this->delete($id);
				else $this->save($user);
			}
		}
		
	}
	
?>