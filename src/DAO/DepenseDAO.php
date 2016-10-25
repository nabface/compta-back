<?php
	
	namespace Compta\DAO;
	
	use Compta\Domain\Depense;
	
	class DepenseDAO extends DAO {
		
		public function getUsersList(Depense $depense) {
			$query = $this->getDb()->createQueryBuilder();
			$query->select('user_id')
			      ->from('mapping_users')
			      ->where('depense_id = :depense_id')
			      ->setParameter(':depense_id', $depense->getId());
			$map = $query->execute()->fetchAll(\PDO::FETCH_ASSOC);
			$users = [];
			foreach ($map as $row) $users[] = $row['user_id'];
			return $users;
		}
		
		public function addUsers(Depense $depense) {
			$users = $this->getUsersList($depense);
			foreach ($users as $user) $depense->addUser($user);
		}
		
		public function get($id) {
			$query = $this->getDb()->createQueryBuilder();
			$query->select('*')
			      ->from('depenses')
			      ->where('id = :id')
			      ->setParameter(':id', $id);
			$statement = $query->execute();
			$statement->setFetchMode(\PDO::FETCH_CLASS, 'Compta\Domain\Depense');
			$depense = $statement->fetch();
			if (!$depense) return false;
			$this->addUsers($depense);
			return $depense;
		}
		
		public function findByGroup($group_id) {
			$query = $this->getDb()->createQueryBuilder();
			$query->select('*')
			      ->from('depenses')
			      ->where('group_id = :group_id')
			      ->setParameter(':group_id', $group_id);
			$statement = $query->execute();
			$statement->setFetchMode(\PDO::FETCH_CLASS, 'Compta\Domain\Depense');
			$answer = $statement->fetchAll();
			if (count($answer) == 0) return false;
			foreach ($answer as $depense) {
				$this->addUsers($depense);
				$depenses[] = $depense;
			}
			return $depenses;
		}
		
		public function save(Depense $depense) {
			// create/update entry in 'depenses' table
			$data = array(
				'montant' => $depense->getMontant(),
				'date' => $depense->getDate(),
				'name' => $depense->getName(),
				'group_id' => $depense->getGroupId(),
				'user_id' => $depense->getUserId(),
			);
			$id = $depense->getId();
			if ( $id != NULL)
				$this->getDb()->update('depenses', $data, array('id' => $id));
			else {
				$this->getDb()->insert('depenses', $data);
				$id = $this->getDb()->lastInsertId();
				$depense->setId($id);
			}
			// get entries from 'mapping_users' table
			$users_from_db = $this->getUsersList($depense);
			$users = $depense->getUsers();
			// create entries in 'mapping_users' table
			foreach ($users as $user) {
				$found = false;
				foreach ($users_from_db as $user_from_db)
					if ($user_from_db == $user) $found = true;
				if (!$found)
					$this->getDb()->insert('mapping_users', array(
						'depense_id' => $id,
						'user_id' => $user
					));
			}
			// remove entries in 'mapping_users' table
			foreach ($users_from_db as $user_from_db) {
				$found = false;
				foreach ($users as $user)
					if ($user_from_db == $user) $found = true;
				if (!$found)
					$this->getDb()->delete('mapping_users', array(
						'depense_id' => $id,
						'user_id' => $user
					));
			}
		}
		
		public function delete($id) {
			$this->getDb()->delete('depenses', array('id' => $id));
		}
		
		public function deleteByUser($user_id) {
			// remove dependent entries from 'depenses' table
			$query = $this->getDb()->createQueryBuilder();
			$query->select('*')
			      ->from('depenses')
			      ->where('user_id = :user_id')
			      ->setParameter(':user_id', $user_id);
			$statement = $query->execute();
			$statement->setFetchMode(\PDO::FETCH_CLASS, 'Compta\Domain\Depense');
			$depenses = $statement->fetchAll();
			foreach ($depenses as $depense) {
				$id = $depense->getId();
				$this->delete($id);
				$this->getDb()->delete('mapping_users', array('depense_id' => $id));
			}
			// get entries from 'mapping_users' table
			$query = $this->getDb()->createQueryBuilder();
			$query->select('*')
			      ->from('mapping_users')
			      ->where('user_id = :user_id')
			      ->setParameter(':user_id', $user_id);
			$answer = $query->execute()->fetchAll(\PDO::FETCH_ASSOC);
			// remove unreferenced entries from 'depenses' table
			foreach ($answer as $row) {
				$id = $row['depense_id'];
				$depense = $this->get($id)->removeUser($user_id);
				if ($depense->getUsers() == NULL) $this->delete($id);
				else $this->save($depense);
			}
			// remove entries from 'mapping_users' table
			$this->getDb()->delete('mapping_users', array('user_id' => $user_id));
		}
		
		public function deleteByGroup($group_id) {
			// remove dependent entries from 'depenses' table
			$query = $this->getDb()->createQueryBuilder();
			$query->select('*')
			      ->from('depenses')
			      ->where('group_id = :group_id')
			      ->setParameter(':group_id', $group_id);
			$statement = $query->execute();
			$statement->setFetchMode(\PDO::FETCH_CLASS, 'Compta\Domain\Depense');
			$depenses = $statement->fetchAll();
			foreach ($depenses as $depense) {
				$id = $depense->getId();
				$this->delete($id);
				$this->getDb()->delete('mapping_users', array('depense_id' => $id));
			}
		}
		
	}
	
?>