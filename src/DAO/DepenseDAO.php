<?php
	
	namespace Compta\DAO;
	
	use Compta\Domain\Depense;
	
	class DepenseDAO extends DAO {
		
		private function get($id) {
			$query = $this->getDb()->createQueryBuilder();
			$query->select('*')
			      ->from('users')
			      ->where('id = :id')
			      ->setParameter(':id', $id);
			$statement = $query->execute();
			$statement->setFetchMode(\PDO::FETCH_CLASS, 'Compta\Domain\Depense');
			return $statement->fetch();
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
		
		public function deleteByGroup($group_id) {
			//TODO
		}
		
		public function deleteByUser($user_id) {
			//TODO
		}
		
		public function save(Depense $depense) {
			//TODO
		}
		
		public function delete($id) {
			$this->getDb()->delete('depenses', array('id' => $id));
		}
		
	}
	
?>