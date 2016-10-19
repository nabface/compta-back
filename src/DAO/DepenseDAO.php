<?php
	
	namespace Compta\DAO;
	
	use Compta\Domain\Depense;
	
	class DepenseDAO extends DAO {
		
		public function get($id) {
			$query = $this->getDb()->createQueryBuilder();
			$query->select('*')
			      ->from('depenses')
			      ->where('id = :id')
			      ->setParameter(':id', $id);
			$statement = $query->execute();
			$statement->setFetchMode(\PDO::FETCH_CLASS, 'Compta\Domain\Depense');
			$depense = $statement->fetch();
			$query = $this->getDb()->createQueryBuilder();
			$query->select('*')
			      ->from('mapping_users')
			      ->where('depense_id = :depense_id')
			      ->setParameter(':depense_id', $depense->getId());
			$answer = $query->execute()->fetchAll(\PDO::FETCH_ASSOC);
			$users = [];
			foreach ($answer as $row) {
				$users[] = $row['user_id'];
			}
			$depense->setUsers($users);
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
			$depenses = [];
			foreach ($statement->fetchAll() as $depense) {
				$query = $this->getDb()->createQueryBuilder();
				$query->select('*')
				      ->from('mapping_users')
				      ->where('depense_id = :depense_id')
				      ->setParameter(':depense_id', $depense->getId());
				$map = $query->execute()->fetchAll(\PDO::FETCH_ASSOC);
				foreach ($map as $association)
					$depense->addUser($association['user_id']);
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
			$query = $this->getDb()->createQueryBuilder();
			$query->select('*')
			      ->from('mapping_users')
			      ->where('depense_id = :depense_id')
			      ->setParameter(':depense_id', $depense->getId());
			$answer = $query->execute()->fetchAll(\PDO::FETCH_ASSOC);
			$users = $depense->getUsers();
			// create entries in 'mapping_users' table
			foreach ($users as $user) {
				$found = false;
				foreach ($answer as $row)
					if ($row['user_id'] == $user) $found = true;
				if (!$found)
					$this->getDb()->insert('mapping_users', array(
						'depense_id' => $id,
						'user_id' => $user
					));
			}
			// remove entries in 'mapping_users' table
			foreach ($answer as $row) {
				$found = false;
				foreach ($users as $group)
					if ($row['group_id'] == $user) $found = true;
				if (!$found) {
					$query = $this->getDb()->createQueryBuilder();
					$query->delete('*')
					      ->from('mapping_users')
					      ->where('depense_id = :depense_id')
					      ->andWhere('user_id = :user_id')
					      ->setParameter(':depense_id', $id)
					      ->setParameter(':user_id', $user)
					      ->execute();
				}
			}
		}
		
		public function deleteByGroup($group_id) {
			//TODO
		}
		
		public function deleteByUser($user_id) {
			//TODO
		}
		
		public function delete($id) {
			$this->getDb()->delete('depenses', array('id' => $id));
		}
		
	}
	
?>